<?php

namespace App\Http\Controllers;

use App\Http\Traits\MenuTraits;
use App\Models\KonselorModel;
use App\Models\MenuModel;
use App\Models\RulesModel;
use App\Models\StakeholderModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CounselorCT extends Controller
{
  use MenuTraits;

  private $menuName = "Master Konselor";

  function __construct()
  {
    $this->middleware('auth');
    $this->middleware(function ($request, $next) {
      $this->user = Auth::user();
      $this->menu = MenuModel::where('title', $this->menuName)->select('id')->first();
      if ($this->hasAccess($this->user->role, $this->menu->id)) return $next($request);
    });
  }

  private function getKonselor()
  {
    $konselor = DB::table('konselors')
      ->join('m_user', 'konselors.id_user', '=', 'm_user.id')
      ->join('stakeholders', 'konselors.id_stakeholder', '=', 'stakeholders.id')
      ->select('konselors.*', 'stakeholders.name', 'stakeholders.focus', 'm_user.nama_lengkap', 'm_user.jenis_kelamin', 'm_user.education', 'm_user.pekerjaan', 'm_user.instansi', 'm_user.created_at');
    return $konselor;
  }

  private function getNonActiveKonselor()
  {
    return $this->getKonselor()->where('konselors.status', '=', 0)->get();
  }

  private function getUser()
  {
    return DB::table('m_user')->select('id', 'nama_lengkap')->orderBy('nama_lengkap')->get();
  }

  private function getStakeholder()
  {
    return DB::table('stakeholders')->where('status', '=', '1')->select('id', 'name', 'focus')->orderBy('name')->get();
  }

  public function show($query)
  {
    if ($query == "nonactive") return Datatables::of($this->getNonActiveKonselor())->make(true);
    return;
  }

  public function index()
  {
    $menu = MenuModel::where('title', $this->menuName)->select('id')->first();
    $rules = RulesModel::where('id_menu', $menu->id)->first();
    
    $model['counselors'] = $this->getKonselor()->where('konselors.status', '=', 1)->get();
    $model['users'] = $this->getUser();
    $model['stakeholders'] = $this->getStakeholder();
    $model['base_url'] = '/admin/counselor/';
    $model['rules_url'] = '/admin/rules';
    $model['menu_id'] = $menu->id;

    if (isset($rules)) $model['rules'] = $rules;
    else $model['rules'] = null;
    
    return view('admin.counselor.index', compact('model'));
  }

  public function create()
  {
    $konselor = $this->getKonselor()->where('konselors.status', '=', 1)->get();
    return Datatables::of($konselor)->make(true);
  }

  public function store(Request $request)
  {
    $request->validate([
      'id_user' => 'required',
      'id_stakeholder' => 'required',
    ]);

    $model = new KonselorModel();
    $model->id_user = $request->id_user;
    $model->status = 1;
    $model->id_stakeholder = $request->id_stakeholder;
    $model->created_at = Carbon::now();
    $model->save();

    Alert::success('Berhasil', 'Anda berhasil menginputkan data');
    return redirect()->to('/admin/counselor');
  }


  public function destroy($id)
  {
    // KonselorModel::find($id)->delete();
    $model = KonselorModel::find($id);
    $model->status = 0;
    $model->save();

    return response()->json([
      'state' => true,
      'data' => null,
      'message' => 'Anda berhasil menghapus data!'
    ]);
  }

  public function restore($id)
  {
    // KonselorModel::find($id)->delete();
    $model = KonselorModel::find($id);
    $model->status = 1;
    $model->save();

    return response()->json([
      'state' => true,
      'data' => null,
      'message' => 'Anda berhasil mengembalikan data!'
    ]);
  }
}
