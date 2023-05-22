<?php

namespace App\Http\Controllers;

use App\Http\Traits\MenuTraits;
use App\Models\MenuModel;
use App\Models\StPhotoModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class StakeholderGalleryCT extends Controller
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
    return $this->create();
  }

  public function create()
  {
    return Datatables::of(StPhotoModel::all())->make(true);
  }

  public function store(Request $request)
  {
    $request->validate([
      'id_stakeholder' => 'required',
      'photo' => 'mimes:jpeg,jpg,png,gif|max:5000|required',
    ]);

    $model = new StPhotoModel();
    $model->id_stakeholder = $request->id_stakeholder;
    $model->created_at = Carbon::now();

    if (isset($request->photo)) {
      $fileName = $model->id . '-' . time() . '.' . $request->photo->extension();
      $request->photo->move(public_path('stakeholder') . '/' . 'gallery' . '/', $fileName);
      $model->photo = $fileName;
    }
    $model->save();
    Alert::success('Berhasil', 'Anda berhasil menginputkan data');
    return redirect()->to('/admin/stakeholder');
  }

  public function update(Request $request, $id)
  {
    $fileData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->photo));
    $bytesFile = (int) (strlen(rtrim($request->photo, '=')) * 3 / 4) / 1024;

    if ($bytesFile > 5120) {
      Alert::warning('Gagal', 'Gambar yang Anda masukan terlalu besar!');
      return response()->json([
        'success' => false,
        'data' => null,
        'message' => 'File gambar terlalu besar!'
      ], 422);
    }

    $model = StPhotoModel::find($id);
    $model->updated_at = Carbon::now();
    $model->photo = $request->fileName;
    File::put(public_path('stakeholder') . '/gallery/' . $request->fileName, $fileData);
    $model->save();

    return response()->json([
      'success' => true,
      'data' => null,
      'message' => 'Anda berhasil mengedit data!'
    ]);
  }

  public function destroy($id)
  {
    StPhotoModel::find($id)->delete();
    return response()->json([
      'state' => true,
      'data' => null,
      'message' => 'Anda berhasil menghapus data!'
    ]);
  }

  public function show($id)
  {
    if (is_numeric($id)) {
      return $this->getPhotoByStakeholderID($id);
    }
    if ($id == 'nonactive') {
      return $this->deletedStakeholder();
    }
    return;
  }

  public function getPhotoByStakeholderID($id)
  {
    return StPhotoModel::where('id_stakeholder', '=', $id)->get();
  }
}
