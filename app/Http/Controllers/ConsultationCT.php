<?php

namespace App\Http\Controllers;

use App\Http\Traits\MenuTraits;
use App\Models\ConsultationThreadModel;
use App\Models\CtReplyModel;
use App\Models\MenuModel;
use App\Models\RulesModel;
use App\Models\StakeholderModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class ConsultationCT extends Controller
{
  use MenuTraits;

  private $menuName = "Master Konsultasi";

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
    $menu = MenuModel::where('title', $this->menuName)->select('id')->first();
    $rules = RulesModel::where('id_menu', $menu->id)->first();

    $model['base_url'] = '/admin/consultation/';
    $model['firebase_url'] = '/admin/notification/send';
    $model['rules_url'] = '/admin/rules';
    $model['menu_id'] = $menu->id;

    if (isset($rules)) $model['rules'] = $rules;
    else $model['rules'] = null;

    return view('admin.consultation.index', compact('model'));
  }

  private function getConsultation()
  {
    return DB::table('consultationthreads')
      ->leftJoin('konselors', 'consultationthreads.id_konselor', '=', 'konselors.id')
      ->join('m_user', 'consultationthreads.id_user', '=', 'm_user.id')
      ->leftJoin('stakeholders', 'konselors.id_stakeholder', '=', 'stakeholders.id')
      ->leftJoin('m_user AS users', 'konselors.id_user', '=', 'users.id')
      ->select('consultationthreads.*', 'm_user.nama_lengkap', 'm_user.kode_peserta as kode_user', 'stakeholders.name AS name_stakeholder', 'users.nama_lengkap AS nama_konselor', 'users.kode_peserta as kode_konselor');
  }

  private function getTypeConsultation($type)
  {
    $allConsultation = $this->getConsultation();
    $filtered = $allConsultation->where("consultationthreads.type", '=', $type)->where('consultationthreads.status', '=', '1')->get();
    return Datatables::of($filtered)->make(true);
  }

  public function getTypeReportConsultation($filter)
  {
    $allConsultation = $this->getConsultation();
    
    if ($filter == 'public' || $filter == 'private') {
      $filtered = $allConsultation->where("consultationthreads.type", '=', $filter)->get();
      return Datatables::of($filtered)->make(true);
    } else if ($filter == 'closed') {
      $filtered = $allConsultation->where("consultationthreads.state", '=', 'closed')->get();
      return Datatables::of($filtered)->make(true);
    } else if ($filter == 'ongoing') {
      $filtered = $allConsultation->where("consultationthreads.state", '!=', 'closed')->get();
      return Datatables::of($filtered)->make(true);
    } else {
      return Datatables::of($allConsultation)->make(true);
    }
  }

  public function getById($id)
  {
    $consultation = $this->getConsultation()->where('consultationthreads.id', '=', $id)->first();
    $repliesConsultation = [];
    if ($consultation != null) {
      $repliesConsultation = DB::table('consultationthreads')
        ->leftJoin("ctreplies", "consultationthreads.id", "=", "ctreplies.id_cthread")
        ->join('m_user', 'ctreplies.id_user', '=', 'm_user.id')
        ->leftJoin('konselors', 'm_user.id', '=', 'konselors.id_user')
        ->leftJoin('stakeholders', 'konselors.id_stakeholder', '=', 'stakeholders.id')
        ->where('consultationthreads.id', '=', $id)
        ->select('ctreplies.id', 'ctreplies.content', 'ctreplies.reply_from', 'ctreplies.created_at', 'm_user.nama_lengkap AS nama_pembalas', 'stakeholders.name AS name_stakeholder')
        ->orderBy('ctreplies.created_at')->get();
    }

    return response()->json([
      'details' => $consultation,
      'replies' => $repliesConsultation,
    ]);
  }

  public function closeConsultation($id)
  {
    $userLoggedIn = Auth::user();
    $currentUserID = $userLoggedIn->id;

    $model = ConsultationThreadModel::find($id);
    $model->closed_by = $currentUserID; // supervisor yang mana?
    $model->state = "closed"; // 2
    $model->role_who_closed = "supervisor"; // 1
    $model->closed_at = Carbon::now();
    $model->save();

    return response()->json([
      'state' => true,
      'data' => null,
      'message' => 'Anda berhasil menutup konsultasi!'
    ]);
  }

  public function openConsultation($id)
  {
    $model = ConsultationThreadModel::find($id);
    $model->closed_by = null;
    $model->role_who_closed = null;
    $model->closed_at = null;

    $lastReply = CtReplyModel::where('id_cthread', $id)->orderBy('created_at', 'desc')->first();

    if (isset($lastReply)) {
      if ($lastReply->reply_from == "user") $model->state = "waiting_counselor";
      else $model->state = "waiting_user";
    } else $model->state = "waiting_counselor";

    $model->save();

    return response()->json([
      'state' => true,
      'data' => null,
      'message' => 'Anda berhasil membuka konsultasi!'
    ]);
  }

  public function makeOtherUserReply($id)
  {
    $model = ConsultationThreadModel::find($id);
    if ($model->type == "public") {
      $model->open_to_all = 1;
      $model->save();

      return response()->json([
        'state' => true,
        'data' => null,
        'message' => 'Anda berhasil membuka konsultasi ke user lain!'
      ]);
    } else {
      return response()->json([
        'state' => false,
        'data' => null,
        'message' => 'Anda mencoba membuka konsultasi privat ke user lain!'
      ]);
    }
  }

  public function closeOtherUserReply($id)
  {
    $model = ConsultationThreadModel::find($id);
    if ($model->type == "public") {
      $model->open_to_all = 0;
      $model->save();

      return response()->json([
        'state' => true,
        'data' => null,
        'message' => 'Anda berhasil membuka konsultasi ke user lain!'
      ]);
    } else {
      return response()->json([
        'state' => false,
        'data' => null,
        'message' => 'Anda mencoba membuka konsultasi privat ke user lain!'
      ]);
    }
  }

  public function getPublicConsultation()
  {
    return $this->getTypeConsultation("public");
  }

  public function getPrivateConsultation()
  {
    return $this->getTypeConsultation("private");
  }

  public function create()
  {
    $consultation = $this->getConsultation()->where('consultationthreads.status', '=', '1');
    return Datatables::of($consultation)->make(true);
  }

  public function deleteReply($id)
  {
    CtReplyModel::find($id)->delete();
    return response()->json(
      [
        'state' => true,
        'data' => null,
        'message' => 'Anda berhasil menghapus balasan dari konsultasi ini!'
      ]
    );
  }

  public function destroy($id)
  {
    // // Find reply from data
    // $ctReplyByIDThread = CtReplyModel::where('id_cthread', '=', $id);
    // if (!$ctReplyByIDThread->get()->isEmpty()) {
    //   $ctReplyByIDThread->delete();
    // }

    $model = ConsultationThreadModel::find($id);
    $model->status = 0;
    $model->save();

    return response()->json([
      'state' => true,
      'data' => null,
      'message' => 'Anda berhasil menghapus data!'
    ]);
  }
}
