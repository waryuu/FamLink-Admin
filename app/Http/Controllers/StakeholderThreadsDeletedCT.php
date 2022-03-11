<?php

namespace App\Http\Controllers;

use App\Http\Traits\MenuTraits;
use App\Models\MenuModel;
use App\Models\StakeholderThreadModel;
use App\Models\StReplyModel;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class StakeholderThreadsDeletedCT extends Controller
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
    $model['stakeholders'] = StakeholderThreadModel::all();
    $model['public_url_thread'] = $this->api_url.'/stakeholder/threads/';
    $model['public_url_replies'] = $this->api_url.'/stakeholder/replies/';
    $model['base_url'] = '/admin/stakeholder/threads/trash/';
    return view('admin.stakeholder.threadsDeleted', compact('model'));
  }

  private function getThreads()
  {
    return DB::table('stakeholderthreads')
                ->join('stakeholdermembers', 'stakeholderthreads.id_stmember', '=', 'stakeholdermembers.id')
                ->join('m_user', 'stakeholdermembers.id_user', '=', 'm_user.id')
                ->join('stakeholders', 'stakeholdermembers.id_stakeholder', '=', 'stakeholders.id')
                ->where('stakeholderthreads.status', '=', 0)
                ->select('stakeholderthreads.*', 'stakeholdermembers.id_user', 'm_user.nama_lengkap AS name_user', 'stakeholders.name AS name_stakeholder');
  }

  public function create()
  {
    return Datatables::of($this->getThreads()->get())->make(true);
  }

  public function update($id)
  {
    $model = StakeholderThreadModel::find($id);
    $model->status = 1;
    $model->save();

    return response()->json([
        'state' => true,
        'data' => null,
        'message' => 'Anda berhasil mengembalikan data!'
    ]);
  }

  public function destroy($id)
  {
    // Find replies from data
    $stReplyByIDThread = StReplyModel::where('id_sthread', '=', $id);
      if (!$stReplyByIDThread->get()->isEmpty()) {
         $stReplyByIDThread->delete();
      }
    StakeholderThreadModel::find($id)->delete();

    return response()->json([
        'state' => true,
        'data' => null,
        'message' => 'Anda berhasil menghapus data seluruhnya!'
    ]);
  }

  public function show($dir)
  {
    if(is_numeric($dir)) return $this->getThreadsByID($dir);
    else return;
  }

  public function getThreadsByID($id)
  {
    $detail = $this->getThreads()->where('stakeholderthreads.id', '=', $id)->first();
    $replies = [];
    if($detail != null) {
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
}
