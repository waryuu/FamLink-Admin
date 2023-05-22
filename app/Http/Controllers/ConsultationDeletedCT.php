<?php

namespace App\Http\Controllers;

use App\Http\Traits\MenuTraits;
use App\Models\ConsultationThreadModel;
use App\Models\CtReplyModel;
use App\Models\MenuModel;
use App\Models\StakeholderModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ConsultationDeletedCT extends Controller
{
   use MenuTraits;

   private $menuName = "Master Konsultasi";

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
      $model['base_url'] = '/admin/consultation/trash/';
      return view('admin.consultation.deleted', compact('model'));
   }

   public function show($dir)
   {
      if (is_numeric($dir)) {
         return $this->getById($dir);
      }
      if ($dir == 'public') {
         return $this->getPublicConsultation();
      }
      if ($dir == 'private') {
         return $this->getPrivateConsultation();
      }
      return;
   }

   public function create()
   {
      $consultation = $this->getConsultation();
      return Datatables::of($consultation)->make(true);
   }

   public function destroy($id)
   {
      // Find reply from data
      $ctReplyByIDThread = CtReplyModel::where('id_cthread', '=', $id);
      if (!$ctReplyByIDThread->get()->isEmpty()) {
         $ctReplyByIDThread->delete();
      }
      ConsultationThreadModel::find($id)->delete();

      return response()->json([
         'state' => true,
         'data' => null,
         'message' => 'Anda berhasil untuk menghapus data seluruhnya!'
      ]);
   }

   public function restore($id)
   {
      $model = ConsultationThreadModel::find($id);
      $model->status = 1;
      $model->save();

      return response()->json([
         'state' => true,
         'data' => null,
         'message' => 'Anda berhasil mengembalikan data!'
      ]);
   }

   private function getConsultation()
   {
      return DB::table('consultationthreads')
         ->leftJoin('konselors', 'consultationthreads.id_konselor', '=', 'konselors.id')
         ->join('m_user', 'consultationthreads.id_user', '=', 'm_user.id')
         ->leftJoin('stakeholders', 'konselors.id_stakeholder', '=', 'stakeholders.id')
         ->leftJoin('m_user AS users', 'konselors.id_user', '=', 'users.id')
         ->where('consultationthreads.status', '=', 0)
         ->select('consultationthreads.*', 'm_user.nama_lengkap', 'stakeholders.name AS name_stakeholder',
         'users.nama_lengkap AS nama_konselor', 'users.kode_peserta as kode_konselor');
   }

   private function getTypeConsultation($type)
   {
      $allConsultation = $this->getConsultation();
      $filtered = $allConsultation->where("consultationthreads.type", '=', $type)->get();
      return Datatables::of($filtered)->make(true);
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
            ->select('ctreplies.id', 'ctreplies.content', 'ctreplies.reply_from', 'ctreplies.created_at',
            'm_user.nama_lengkap AS nama_pembalas', 'stakeholders.name AS name_stakeholder')
            ->orderBy('ctreplies.created_at')->get();
      }

      return response()->json([
         'details' => $consultation,
         'replies' => $repliesConsultation,
      ]);
   }

   public function getPublicConsultation()
   {
      return $this->getTypeConsultation("public");
   }

   public function getPrivateConsultation()
   {
      return $this->getTypeConsultation("private");
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
}
