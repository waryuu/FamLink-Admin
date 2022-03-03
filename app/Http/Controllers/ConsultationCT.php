<?php

namespace App\Http\Controllers;
use App\Models\ConsultationThreadModel;
use App\Models\CtReplyModel;
use App\Models\StakeholderModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class ConsultationCT extends Controller
{
  private function getConsultation()
  {
    return DB::table('consultationthreads')
                    ->leftJoin('konselors', 'consultationthreads.id_konselor', '=', 'konselors.id')
                    ->join('m_user', 'consultationthreads.id_user', '=', 'm_user.id')
                    ->leftJoin('stakeholders', 'konselors.id_stakeholder', '=', 'stakeholders.id')
                    ->leftJoin('m_user AS users', 'konselors.id_user', '=', 'users.id')
                    ->select('consultationthreads.*', 'm_user.nama_lengkap', 'stakeholders.name AS name_stakeholder', 'users.nama_lengkap AS nama_konselor', 'users.kode_peserta as kode_konselor')
                    ->orderBy('consultationthreads.is_replied');
  }

  private function getTypeConsultation($type)
  {
    $allConsultation = $this->getConsultation();
    $filtered = $allConsultation->where("consultationthreads.type", '=', $type)->get();
    return Datatables::of($filtered)->make(true);
  }
  
  public function index()
  {
    $model['base_url'] = '/admin/consultation/';
    $model['firebase_url'] = '/admin/notification/send';
    return view('admin.consultation.index', compact('model'));
  }

  public function getById($id)
  {
    return $this->getConsultation()->where('consultationthreads.id', '=', $id)->first();
  }

  public function show($type)
  {
    if($type == 'public'){
      return $this->getTypeConsultation("public");
    }
    if($type == 'private'){
      return $this->getTypeConsultation("private");
    }
    return $this->create(); 
  }

  public function create()
  {
    $consultation = $this->getConsultation();
    return Datatables::of($consultation)->make(true);
  }

  public function destroy($id)
  {
    $ctReplyByIDThread = CtReplyModel::where('id_cthread', '=', $id);
    if (!$ctReplyByIDThread->get()->isEmpty()) {
      $ctReplyByIDThread->delete();
    }
    ConsultationThreadModel::find($id)->delete();

    return response()->json([
        'state' => true,
        'data' => null,
        'message' => 'Anda berhasil menghapus data!'
    ]);
  }
}
