<?php

namespace App\Http\Controllers;

use App\Http\Traits\MenuTraits;
use Illuminate\Http\Request;
use App\Models\MaterialModel;
use App\Models\CategoryModel;
use App\Models\MenuModel;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class MaterialCT extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use MenuTraits;

    private $menuName = "Master Material";

    function __construct()
    {
        $this->fcm_key = env("FCM_KEY", "");
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
        $model['base_url'] = '/admin/material/';
        $model['category_base_url'] = '/admin/category/';
        return view('admin.material.index', compact('model'));
    }

    public function data()
    {
        $resprotect = Datatables::of(
            MaterialModel::join('categorys', 'materials.id_category', '=', 'categorys.id')
            ->select('materials.*', 'categorys.name')
            ->get())->make(true);

        $res = $resprotect->getData();
        for ($i=0; $i < count($res->data); $i++) { 
            if ($res->data[$i]->link_yt) {
                $res->data[$i]->link_yt = "https://www.youtube.com/embed/".substr($res->data[$i]->link_yt, 32);
            }
        }
        return $res;
    }

    public function data_category()
    {
        return Datatables::of(CategoryModel::all())->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model['category'] = CategoryModel::all();
        $model['base_url'] = '/admin/material';
        return view('admin.material.create', compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'mimes:jpeg,jpg,png,gif|max:1000',
            'id_category' => 'required',
            'title' => 'required',
            'type' => 'required',
            'description' => 'required',
            'status' => 'required',
            ]
        );

        $user = Auth::user();
        $model = new MaterialModel();
        $model->id_staff = $user->id;
        $model->id_category = $request->id_category;
        $model->title = $request->title;
        $model->type = $request->type;
        $model->description = $request->description;
        $model->status = $request->status;
        $model->created_at = Carbon::now();
        $model->save();

        if ($request->type == "video") {
            $model->link_yt = $request->link_yt;
            $model->image = NULL;
            $model->is_locked = 0;
            $model->download_pass = NULL;
        }

        if ($request->type == "default") {
            $fileName = $model->id.'-'.time().'.'.$request->image->extension();
            $request->image->move(public_path('material'), $fileName);
            $model->image = $fileName;
            $model->link_yt = NULL;
            $model->is_locked = $request->is_locked;
            if ($request->is_locked) {
                $model->download_pass = Hash::make($request->download_pass);
            }
        }

        $model->save();

        $fcm_data['to'] = "/topics/GLOBAL";

        $data['title'] = 'Materi Edukasi Baru Famlink';
        $data['body'] = $model->title;
        $fcm_data['data'] = $data;

        $response = Http::withHeaders([
            'Authorization' => 'key='.$this->fcm_key,
            'Content-Type' => 'application/json'
        ])->post('https://fcm.googleapis.com/fcm/send', $fcm_data);

        Alert::success('Berhasil', 'Anda berhasil menginputkan data');
        return redirect()->to('/admin/material');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model['base_url'] = '/admin/material/';
        $model['base_url_id'] = '/admin/material/'.$id;
        $model['file_base_url'] = '/admin/material/file/';
        $model['file_data_url'] = '/admin/material/file/datatable/list/'.$id;
        $model['category'] = CategoryModel::all();
        $model['data'] = MaterialModel::find($id);
        return view('admin.material.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'mimes:jpeg,jpg,png,gif|max:1000',
            'id_category' => 'required',
            'title' => 'required',
            'type' => 'required',
            'description' => 'required',
            'status' => 'required',
            ]
        );

        $user = Auth::user();
        $model = MaterialModel::find($id);

        if ($request->is_locked == 1 && $request->download_pass == NULL && $model->download_pass == NULL) {
            $request->validate([
                'download_pass' => 'required',
            ],
            [
                'download_pass.required'=>'Password file belum diisi',
            ]
            );
        }

        $model->id_staff = $user->id;
        $model->id_category = $request->id_category;
        $model->title = $request->title;
        $model->type = $request->type;
        $model->description = $request->description;
        $model->status = $request->status;
        $model->updated_at = Carbon::now();

        if ($request->type == "video") {
            $model->link_yt = $request->link_yt;
            $model->image = NULL;
            $model->is_locked = 0;
            $model->download_pass = NULL;
        }

        if ($request->type == "default") {
            
            if (isset($request->image)){
                $fileName = $model->id.'-'.time().'.'.$request->image->extension();
                $request->image->move(public_path('material'), $fileName);
                $model->image = $fileName;
            }

            $model->link_yt = NULL;
            $model->is_locked = $request->is_locked;

            if ($request->is_locked == 0) {
                $model->download_pass = NULL;
            }

            if ($request->is_locked) {
                $model->download_pass = NULL;
            }

            if ($request->is_locked && $request->download_pass) {
                $model->download_pass = Hash::make($request->download_pass);
            }
        }

        $model->save();

        Alert::success('Berhasil', 'Anda berhasil update data');
        return redirect()->to('/admin/material');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MaterialModel::find($id)->delete();

        return response()->json([
            'state' => true,
            'data' => null,
            'message' => 'Anda berhasil menghapus data!'
            ]
        );
    }
}
