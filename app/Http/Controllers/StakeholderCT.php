<?php

namespace App\Http\Controllers;
use App\Models\StakeholderModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;

class StakeholderCT extends Controller
{ 
  public function index()
  {
    $model['stakeholders'] = StakeholderModel::all();
    $model['base_url'] = '/admin/stakeholder/';
    $model['public_url'] = '/stakeholder/';
    $model['provinces'] = $this->getProvinces();
    return view('admin.stakeholder.index', compact('model'));
  }

  public function create()
  {
    return Datatables::of(StakeholderModel::all())->make(true);
  }

  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required', 
      'established' => 'required', 
      'focus' => 'required', 
      'id_province' => 'required', 
      'id_regency' => 'required', 
      'logo' => 'mimes:jpeg,jpg,png,gif|max:1000|required',
    ]);

    $model = new StakeholderModel();
    $model->name = $request->name;
    $model->established = $request->established;
    $model->focus = $request->focus;
    $model->email = $request->email;
    $model->id_province = $request->id_province;
    $model->id_regency = $request->id_regency;
    $model->created_at = Carbon::now();
    $model->save();
    
    if (isset($request->logo)){
      $fileName = $model->id.'-'.time().'.'.$request->logo->extension();
      $request->logo->move(public_path('stakeholder'), $fileName);
      $model->logo = $fileName;
    }

    $model->save();

    Alert::success('Berhasil', 'Anda berhasil menginputkan data');
    return redirect()->to('/admin/stakeholder');
  }

  public function update(Request $request, $id)
  {   
    $request->validate([
      'name' => 'required', 
      'established' => 'required', 
      'focus' => 'required', 
      'id_province' => 'required', 
      'id_regency' => 'required', 
    ]);

    $model = StakeholderModel::find($id);
    $model->name = $request->name;
    $model->established = $request->established;
    $model->focus = $request->focus;
    $model->email = $request->email;
    $model->id_province = $request->id_province;
    $model->id_regency = $request->id_regency;
    $model->updated_at = Carbon::now();

    if($request->fileName != null) {
      $fileData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->logo));
      $bytesFile = (int) (strlen(rtrim($request->logo, '=')) * 3 / 4) / 1024;
      // $bytesFile = round((((int)strlen(base64_decode($request->logo))) / 1024.0) * 0.67, 2);

      if($bytesFile > 1024) return response()->json(['success' => false], 422);

      File::put(public_path('stakeholder') . '/' . $request->fileName, $fileData);
      $model->logo = $request->fileName;
    }
    
    $model->save();

    return response()->json([ 'success' => true ]);
  }

  public function destroy($id)
  {
    StakeholderModel::find($id)->delete();

    return response()->json([
        'state' => true,
        'data' => null,
        'message' => 'Anda berhasil menghapus data!'
    ]);
  }

  public function show($id)
  {
    return $this->getStakeholderByID($id);
  }


  public function getRegencyByProvince($id)
  {
    $province = DB::table('regencies')->where('province_id', '=', $id)->select('id', 'name')->get();
    return $province;
  }

  public function getProvinces()
  {
    return DB::table('provinces')->select("*")->get();
  }

  public function getStakeholderByID($id)
  {
    return StakeholderModel::find($id);
  }
}
