<?php

namespace App\Http\Controllers;

use App\Models\AssessmentDetailModel;
use App\Models\BannerModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;

class BannerCT extends Controller
{
    public function index()
    {
        $model['base_url'] = '/admin/banner/';
        return view('admin.banner.index', compact('model'));
    }

    public function data()
    {
        return Datatables::of(BannerModel::all())->make(true);
    }

    public function create()
    {
        $model['base_url'] = '/admin/banner';
        return view('admin.banner.create', compact('model'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'status' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png,gif|required|max:1000',
            ]
        );

        $model = new BannerModel();
        $model->title = $request->title;
        $model->status = $request->status;
        $model->created_at = Carbon::now();
        $model->save();

        $fileName = $model->id.'-'.time().'.'.$request->image->extension();
        $request->image->move(public_path('banner'), $fileName);
        $model->image = $fileName;
        $model->save();

        Alert::success('Berhasil', 'Anda berhasil menginputkan data');
        return redirect()->to('/admin/banner');
    }

    public function show($id)
    {
        $model['base_url'] = '/admin/banner/';
        $model['data'] = BannerModel::find($id);
        $model['detail'] = AssessmentDetailModel::where('id_assessment', $model['data']->id)->get();
        return view('admin.banner.show', compact('model'));
    }

    public function edit($id)
    {
        $model = BannerModel::find($id);

        return response()->json([
            'data' => $model
            ]
        );
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'title' => 'required',
            'status' => 'required',
            'image' => 'mimes:jpeg,jpg,png,gif|max:1000',
            ]
        );

        $model = BannerModel::find($id);
        $model->title = $request->title;
        $model->status = $request->status;
        $model->updated_at = Carbon::now();
        if (isset($request->image)){
            $fileName = $id.'-'.time().'.'.$request->image->extension();
            $request->image->move(public_path('banner'), $fileName);
            $model->image = $fileName;
        }
        $model->save();

        Alert::success('Berhasil', 'Anda berhasil update data');
        return redirect()->to('/admin/banner');
    }

    public function destroy($id)
    {
        BannerModel::find($id)->delete();

        return response()->json([
            'state' => true,
            'data' => null,
            'message' => 'Anda berhasil menghapus data!'
            ]
        );
    }
}
