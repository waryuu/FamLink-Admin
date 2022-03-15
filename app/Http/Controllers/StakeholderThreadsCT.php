<?php

namespace App\Http\Controllers;

use App\Http\Traits\MenuTraits;
use App\Models\MenuModel;
use App\Models\RulesModel;
use App\Models\StakeholderThreadModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class StakeholderThreadsCT extends Controller
{
  use MenuTraits;

  private $menuName = "Master Diskusi Stakeholder";

  function __construct()
  {
    $this->api_url = env("API_URL", "");;

    $this->middleware('auth');
    $this->middleware(function ($request, $next) {
      $this->user = Auth::user();
      $this->menu = MenuModel::where('title', $this->menuName)->select('id')->first();
      if ($this->hasAccess($this->user->role, $this->menu->id)) return $next($request);
    });
  }

  public function index()
  {
    $menu = MenuModel::where('title', $this->menuName)->select('id')->first();
    $rules = RulesModel::where('id_menu', $menu->id)->first();

    $model['stakeholders'] = StakeholderThreadModel::all();
    $model['public_url_thread'] = $this->api_url . '/stakeholder/threads/';
    $model['public_url_replies'] = $this->api_url . '/stakeholder/replies/';
    $model['base_url'] = '/admin/stakeholder/threads/';
    $model['rules_url'] = '/admin/rules';
    $model['menu_id'] = $menu->id;

    if (isset($rules)) $model['rules'] = $rules;
    else $model['rules'] = null;
    return view('admin.stakeholder.threads', compact('model'));
  }

  private function getThreads()
  {
    return DB::table('stakeholderthreads')
      ->join('stakeholdermembers', 'stakeholderthreads.id_stmember', '=', 'stakeholdermembers.id')
      ->join('m_user', 'stakeholdermembers.id_user', '=', 'm_user.id')
      ->join('stakeholders', 'stakeholdermembers.id_stakeholder', '=', 'stakeholders.id')
      ->where('stakeholderthreads.status', '=', 1)
      ->select('stakeholderthreads.*', 'stakeholdermembers.id_user', 'm_user.nama_lengkap AS name_user', 'stakeholders.name AS name_stakeholder');
  }

  public function create()
  {
    return Datatables::of($this->getThreads()->get())->make(true);
  }

  public function destroy($id)
  {
    $model = StakeholderThreadModel::find($id);
    $model->status = 0;
    $model->save();

    return response()->json([
      'state' => true,
      'data' => null,
      'message' => 'Anda berhasil menghapus data!'
    ]);
  }

  public function show($dir)
  {
    if (is_numeric($dir)) return $this->getThreadsByID($dir);
    else return;
  }

  public function getThreadsByID($id)
  {
    $detail = $this->getThreads()->where('stakeholderthreads.id', '=', $id)->first();
    $replies = [];
    if ($detail != null) {
      $replies = DB::table('stakeholderthreads')
        ->join('streplies', 'stakeholderthreads.id', '=', 'streplies.id_sthread')
        ->join('stakeholdermembers', 'streplies.id_stmember', '=', 'stakeholdermembers.id')
        ->join('m_user', 'stakeholdermembers.id_user', '=', 'm_user.id')
        ->join('stakeholders', 'stakeholdermembers.id_stakeholder', '=', 'stakeholders.id')
        ->where('stakeholderthreads.id', '=', $id)
        ->select('streplies.*', 'stakeholdermembers.id_user', 'm_user.nama_lengkap AS name_user', 'stakeholders.name AS name_stakeholder')
        ->orderBy('streplies.created_at')->get();
    }

    return response()->json([
      'detail' => $detail,
      'replies' => $replies,
    ]);
  }

  public function closeThreads($id)
  {
    $userLoggedIn = Auth::user();
    $currentUserID = $userLoggedIn->id;

    $model = StakeholderThreadModel::find($id);
    $model->closed_by = $currentUserID;
    $model->state = "CLOSED";
    $model->closed_at = Carbon::now('Asia/Jakarta');
    $model->save();

    return response()->json([
      'state' => true,
      'data' => null,
      'message' => 'Anda berhasil menutup konsultasi!'
    ]);
  }

  public function openThreads($id)
  {
    $model = StakeholderThreadModel::find($id);
    $model->closed_by = null;
    $model->state = "OPEN";
    $model->closed_at = null;
    $model->save();

    return response()->json([
      'state' => true,
      'data' => null,
      'message' => 'Anda berhasil membuka konsultasi!'
    ]);
  }
}
