<?php

namespace App\Http\Controllers;

use App\Http\Traits\MenuTraits;
use App\Models\AssessmentDetailModel;
use App\Models\MenuModel;
use App\Models\ArticleModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ArticleCT extends Controller
{
    use MenuTraits;

    private $menuName = "Master Article";

    function __construct()
    {
        $this->fcm_key = env("FCM_KEY", "");;

        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            $this->menu = MenuModel::where('title', $this->menuName)->select('id')->first();
            if ($this->hasAccess($this->user->role, $this->menu->id)) return $next($request);
        });
    }

    public function index()
    {
        $model['base_url'] = '/admin/article/';
        return view('admin.article.index', compact('model'));
    }

    public function data()
    {
        return Datatables::of(ArticleModel::all())->make(true);
    }

    public function create()
    {
        $model['base_url'] = '/admin/article';
        return view('admin.article.create', compact('model'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'status' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png,gif|required|max:1000',
            ]
        );

        $model = new ArticleModel();
        $model->title = $request->title;
        $model->content = $request->content;
        $model->status = $request->status;
        $model->type = $request->type;
        $model->created_at = Carbon::now();
        $model->save();

        $fileName = $model->id.'-'.time().'.'.$request->image->extension();
        $request->image->move(public_path('article'), $fileName);
        $model->image = $fileName;
        $model->save();

        if (isset($request->type_value)) {
            $fileName = $model->id.'-'.time().'.'.$request->type_value->extension();
            $request->type_value->move(public_path('article_pdf'), $fileName);
            $model->type_value = $fileName;
            $model->save();
        }

        $fcm_data['to'] = "/topics/GLOBAL";

        $data['title'] = 'Artikel Terbaru Famlink';
        $data['body'] = $model->title;
        $fcm_data['data'] = $data;

        $response = Http::withHeaders([
            'Authorization' => 'key='.$this->fcm_key,
            'Content-Type' => 'application/json'
        ])->post('https://fcm.googleapis.com/fcm/send', $fcm_data);


        Alert::success('Berhasil', 'Anda berhasil menginputkan data');
        return redirect()->to('/admin/article');
    }

    public function show($id)
    {
        $model['base_url'] = '/admin/article/';
        $model['data'] = ArticleModel::find($id);
        $model['detail'] = AssessmentDetailModel::where('id_assessment', $model['data']->id)->get();
        return view('admin.article.show', compact('model'));
    }

    public function edit($id)
    {
        $model = ArticleModel::find($id);

        return response()->json([
            'data' => $model
            ]
        );
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'status' => 'required',
            'image' => 'mimes:jpeg,jpg,png,gif|max:1000',
            ]
        );

        $model = ArticleModel::find($id);
        $model->title = $request->title;
        $model->content = $request->content;
        $model->status = $request->status;
        $model->type = $request->type;
        $model->updated_at = Carbon::now();
        if (isset($request->image)){
            $fileName = $id.'-'.time().'.'.$request->image->extension();
            $request->image->move(public_path('article'), $fileName);
            $model->image = $fileName;
        }
        if (isset($request->type_value)) {
            $fileName = $model->id.'-'.time().'.'.$request->type_value->extension();
            $request->type_value->move(public_path('article_pdf'), $fileName);
            $model->type_value = $fileName;
        }
        $model->save();

        Alert::success('Berhasil', 'Anda berhasil update data');
        return redirect()->to('/admin/article');
    }

    public function destroy($id)
    {
        ArticleModel::find($id)->delete();

        return response()->json([
            'state' => true,
            'data' => null,
            'message' => 'Anda berhasil menghapus data!'
            ]
        );
    }
}
