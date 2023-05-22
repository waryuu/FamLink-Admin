<?php

namespace App\Http\Controllers;

use App\Http\Traits\MenuTraits;
use App\Models\AssessmentDetailModel;
use App\Models\MenuModel;
use App\Models\AssessmentModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AssessmentCT extends Controller
{
    use MenuTraits;

    private $menuName = "Master Assessment";

    function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            $this->menu = MenuModel::where('title', $this->menuName)->select('id')->first();
            if ($this->hasAccess($this->user->role, $this->menu->id)) {
                return $next($request);
            }
        });
    }

    public function index()
    {
        $model['base_url'] = '/admin/assessment/';
        return view('admin.assessment.index', compact('model'));
    }

    public function create()
    {
        // TODO
        return Datatables::of(AssessmentModel::query())->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png,gif|required|max:1000',
            ]
        );

        $model = new AssessmentModel();
        $model->title = $request->title;
        $model->description = $request->description;
        $model->status = 0;
        $model->created_at = Carbon::now();
        $model->save();

        $fileName = $model->id.'-'.time().'.'.$request->image->extension();
        $request->image->move(public_path('menu'), $fileName);
        $model->image = $fileName;
        $model->save();

        Alert::success('Berhasil', 'Anda berhasil menginputkan data');
        return redirect()->to('/admin/assessment');
    }

    public function show($id)
    {
        $model['base_url'] = '/admin/assessment/';
        $model['data'] = AssessmentModel::find($id);
        $model['detail'] = AssessmentDetailModel::where('id_assessment', $model['data']->id)->get();
        return view('admin.assessment.show', compact('model'));
    }

    public function edit($id)
    {
        $model = AssessmentModel::find($id);
        // dd($model);

        return response()->json([
            'data' => $model
            ]
        );
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'status' => 'required',
            'image' => 'mimes:jpeg,jpg,png,gif|max:1000',
            ]
        );

        $model = AssessmentModel::find($id);
        $model->title = $request->title;
        $model->description = $request->description;
        $model->status = $request->status;
        $model->updated_at = Carbon::now();
        if (isset($request->image)){
            $fileName = $id.'-'.time().'.'.$request->image->extension();
            $request->image->move(public_path('menu'), $fileName);
            $model->image = $fileName;
        }
        $model->save();

        Alert::success('Berhasil', 'Anda berhasil update data');
        return redirect()->to('/admin/assessment');
    }

    public function destroy($id)
    {
        AssessmentModel::find($id)->delete();

        return response()->json([
            'state' => true,
            'data' => null,
            'message' => 'Anda berhasil menghapus data!'
            ]
        );
    }
}
