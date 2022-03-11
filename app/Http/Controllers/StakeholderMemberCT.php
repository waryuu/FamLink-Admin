<?php

namespace App\Http\Controllers;

use App\Http\Traits\MenuTraits;
use App\Models\MenuModel;
use App\Models\StakeholderMemberModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class StakeholderMemberCT extends Controller
{
  use MenuTraits;

  private $menuName = "Master Stakeholder";

  function __construct()
  {
    $this->middleware('auth');
    $this->middleware(function ($request, $next) {
      $this->user = Auth::user();
      $this->menu = MenuModel::where('title', $this->menuName)->select('id')->first();
      if ($this->hasAccess($this->user->role, $this->menu->id)) return $next($request);
    });
  }
  
  public function index()
  {
    $model['base_url'] = '/admin/stakeholder/members/';
    $model['users'] = $this->getUser();
    $model['stakeholders'] = $this->getStakeholder();
    return view('admin.stakeholder.member', compact('model'));
  }

  public function create()
  {
    return Datatables::of($this->getMember())->make(true);
  }

  private function getMember()
  {
    $konselor = DB::table('stakeholdermembers')
      ->join('m_user', 'stakeholdermembers.id_user', '=', 'm_user.id')
      ->join('stakeholders', 'stakeholdermembers.id_stakeholder', '=', 'stakeholders.id')
      ->where('stakeholdermembers.status', '=', 1)
      ->select('stakeholdermembers.*', 'stakeholders.name AS name_stakeholder', 'stakeholders.focus', 'm_user.nama_lengkap', 'm_user.jenis_kelamin', 'm_user.education', 'm_user.pekerjaan')
      ->get();
    return $konselor;
  }

  private function getNonActiveMember()
  {
    $konselor = DB::table('stakeholdermembers')
      ->join('m_user', 'stakeholdermembers.id_user', '=', 'm_user.id')
      ->join('stakeholders', 'stakeholdermembers.id_stakeholder', '=', 'stakeholders.id')
      ->where('stakeholdermembers.status', '=', 0)
      ->select('stakeholdermembers.*', 'stakeholders.name AS name_stakeholder', 'stakeholders.focus', 'm_user.nama_lengkap', 'm_user.jenis_kelamin', 'm_user.education', 'm_user.pekerjaan')
      ->get();
    return $konselor;
  }

  private function getUser()
  {
    return DB::table('m_user')->select('id', 'nama_lengkap')->orderBy('nama_lengkap')->get();
  }

  private function getStakeholder()
  {
    return DB::table('stakeholders')->where('status', '=', '1')->select('id', 'name', 'focus')->orderBy('name')->get();
  }

  public function show($dir)
  {
    if ($dir == 'nonactive') return Datatables::of($this->getNonActiveMember())->make(true);
    return;
  }

  public function store(Request $request)
  {
    $request->validate([
      'id_user' => 'required',
      'id_stakeholder' => 'required',
      'position' => 'required',
    ]);

    $model = new StakeholderMemberModel();
    $model->id_user = $request->id_user;
    $model->id_stakeholder = $request->id_stakeholder;
    $model->position = $request->position;
    $model->created_at = Carbon::now();
    $model->save();

    Alert::success('Berhasil', 'Anda berhasil menginputkan data');
    return redirect()->to('/admin/stakeholder/members');
  }

  public function destroy($id)
  {
    $model = StakeholderMemberModel::find($id);
    $model->status = 0;
    $model->save();

    return response()->json([
      'state' => true,
      'data' => null,
      'message' => 'Anda berhasil menghapus data!'
    ]);
  }

  public function restoreMember($id)
  {
    $model = StakeholderMemberModel::find($id);
    $model->status = 1;
    $model->save();

    return response()->json([
      'state' => true,
      'data' => null,
      'message' => 'Anda berhasil mengembalikan data!'
    ]);
  }
}
