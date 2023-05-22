<?php

namespace App\Http\Controllers;

use App\Http\Traits\MenuTraits;
use App\Models\MenuModel;
use App\Models\StakeholderModel;
use App\Models\StakeholderMemberModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class StakeholderCT extends Controller
{
  use MenuTraits;

  private $menuName = "Master Stakeholder";

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
    $model['stakeholders'] = StakeholderModel::all();
    $model['base_url'] = '/admin/stakeholder/';
    $model['public_url'] = '/stakeholder/';
    $model['provinces'] = $this->getProvinces();
    return view('admin.stakeholder.index', compact('model'));
  }

  public function create()
  {
    return Datatables::of(StakeholderModel::where('status', '=', '1')->get())->make(true);
  }

  public function deletedStakeholder()
  {
    return Datatables::of(StakeholderModel::where('status', '=', '0')->get())->make(true);
  }

  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required',
      'established' => 'required',
      'focus' => 'required',
      'description' => 'required',
      'id_province' => 'required',
      'id_regency' => 'required',
      'cp_number' => 'min:8|max:13',
      'logo' => 'mimes:jpeg,jpg,png,gif|max:1000|required',
    ]);

    $model = new StakeholderModel();
    $model->name = $request->name;
    $model->established = $request->established;
    $model->focus = $request->focus;
    $model->email = $request->email;
    $model->description = $request->description;
    $model->cp_name = $request->cp_name;
    $model->cp_number = $request->cp_number;
    $model->id_province = $request->id_province;
    $model->id_regency = $request->id_regency;
    $model->created_at = Carbon::now();

    if (isset($request->logo)) {
      $fileName = $model->id . '-' . time() . '.' . $request->logo->extension();
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
      'description' => 'required',
      'id_province' => 'required',
      'id_regency' => 'required',
    ]);

    $model = StakeholderModel::find($id);
    $model->name = $request->name;
    $model->established = $request->established;
    $model->focus = $request->focus;
    $model->email = $request->email;
    $model->description = $request->description;
    $model->cp_name = $request->cp_name;
    $model->cp_number = $request->cp_number;
    $model->id_province = $request->id_province;
    $model->id_regency = $request->id_regency;
    $model->updated_at = Carbon::now();

    if ($request->fileName != null) {
      $fileData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->logo));
      $bytesFile = (int) (strlen(rtrim($request->logo, '=')) * 3 / 4) / 1024;

      if ($bytesFile > 1024) {
        Alert::warning('Gagal', 'Gambar yang Anda masukan terlalu besar!');
        redirect()->to('/admin/stakeholder');
        return response()->json([
          'success' => false,
          'data' => null,
          'message' => 'File gambar terlalu besar!'
        ], 422);
      }

      File::put(public_path('stakeholder') . '/' . $request->fileName, $fileData);
      $model->logo = $request->fileName;
    }

    $model->save();

    return response()->json([
      'success' => true,
      'data' => null,
      'message' => 'Anda berhasil mengedit data!'
    ]);
  }

  public function destroy($id)
  {
    // Make all members nonactive
    $members = StakeholderMemberModel::where('id_stakeholder', '=', $id)->get();
    foreach ($members as $member) {
      $member->status = 0;
      $member->save();
    }

    $model = StakeholderModel::find($id);
    $model->status = 0;
    $model->save();

    return response()->json([
      'state' => true,
      'data' => null,
      'message' => 'Anda berhasil menghapus data!'
    ]);
  }

  public function restoreStakeholder($id)
  {
    $model = StakeholderModel::find($id);
    $model->status = 1;
    $model->save();

    return response()->json([
      'state' => true,
      'data' => null,
      'message' => 'Anda berhasil mengembalikan data!'
    ]);
  }

  public function show($id)
  {
    if (is_numeric($id)) {
      return $this->getStakeholderByID($id);
    }
    if ($id == 'nonactive') {
      return $this->deletedStakeholder();
    }
    return;
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
