<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaterialModel;
use App\Models\FileModel;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class FileCT extends Controller
{
    public function data($id)
    {
        return Datatables::of(
            FileModel::where('id_materials', $id)
            ->get())->make(true);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $model['base_url'] = '/admin/material/file/';
        $model['materials'] = MaterialModel::find($id);

        if ($model['materials']->type == 'video') {
            Alert::warning('Gagal', 'Anda tidak dapat menambahkan file untuk materi jenis Video');
            return redirect()->to("/admin/material/". $model['materials']->id);
        } else {
            return view('admin.material.file.create', compact('model'));
        }
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'id_materials' => 'required',
            'title' => 'required',
            'new_file' => 'mimes:pdf|required',
            'status' => 'required',
            ]
        );

        $model = new FileModel();
        $model->id_materials = $request->id_materials;
        $model->title = $request->title;
        $model->status = $request->status;
        $model->created_at = Carbon::now();
        $model->save();
        
        $fileName = $model->id.'-'.time().'.'.$request->new_file->extension();
        $request->new_file->move(public_path('material/file'), $fileName);
        $model->file = $fileName;
        
        $model->size = File::size(public_path('material/file/'.$fileName));

        $model->save();

        $materials = MaterialModel::find($model->id_materials);

        $fcm_data['to'] = "/topics/GLOBAL";

        $data['title'] = 'Update Materi Edukasi Famlink';
        $data['body'] = 'File '.$model->title.' ditambahkan pada Materi '.$materials->title;
        $fcm_data['data'] = $data;

        $response = Http::withHeaders([
            'Authorization' => 'key=AAAAbuzphk8:APA91bHu2-MEMfW1UlZwLQRjczUhGQRy9Vuse8un-DJTpW7M5_igZ-L9GpXXU3OV_7AVjbZ9coRTtjpIeXNqUlDhoz0sC5jbV3j5e3urlclhDtDtBQ2DDybYCNHdmR5QRm-7RHFJMB_Y',
            'Content-Type' => 'application/json'
        ])->post('https://fcm.googleapis.com/fcm/send', $fcm_data);
        
        Alert::success('Berhasil', 'Anda berhasil menambahkan file');
        return redirect()->to("/admin/material/".$model->id_materials);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model['base_url'] = '/admin/material/file/';
        $model['data'] = FileModel::find($id);
        $model['materi'] = MaterialModel::find($model['data']->id_materials);
        return view('admin.material.file.show', compact('model'));
    }

    public function edit($id)
    {
        $model = FileModel::find($id);
        return response()->json([
            'data' => $model
        ]);
    }

    public function update(Request $request, $id)
    {
        // return $request->new_file;
        
        $request->validate([
            'id_materials' => 'required',
            'title' => 'required',
            'new_file' => 'mimes:pdf',
            'status' => 'required',
            ]
        );
        
        $model = FileModel::find($id);
        $model->title = $request->title;
        $model->status = $request->status;
        $model->updated_at = Carbon::now();
        
        if (isset($request->new_file)){
            $fileName = $model->id.'-'.time().'.'.$request->new_file->extension();
            $request->new_file->move(public_path('material/file'), $fileName);
            $model->file = $fileName;
            $model->size = File::size(public_path('material/file/'.$fileName));
        }

        $model->save();

        Alert::success('Berhasil', 'Anda berhasil mengupdate file');
        return redirect()->to("/admin/material/".$model->id_materials);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        FileModel::find($id)->delete();

        return response()->json([
            'state' => true,
            'data' => null,
            'message' => 'Anda berhasil menghapus data!'
        ]);
    }
}
