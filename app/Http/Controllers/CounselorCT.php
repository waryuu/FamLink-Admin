<?php

namespace App\Http\Controllers;
use App\Models\KonselorModel;
use App\Models\StakeholderModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;

class CounselorCT extends Controller
{
  private function getKonselor()
  {
    $konselor = DB::table('konselors')
                    ->join('m_user', 'konselors.id_user', '=', 'm_user.id')
                    ->join('stakeholders', 'konselors.id_stakeholder', '=', 'stakeholders.id')
                    ->select('konselors.*', 'stakeholders.name', 'stakeholders.focus', 'm_user.nama_lengkap', 'm_user.jenis_kelamin', 'm_user.education', 'm_user.pekerjaan', 'm_user.instansi', 'm_user.created_at')
                    ->get();
    return $konselor;
  }

  private function getUser()
  {
    return DB::table('m_user')->select('id','nama_lengkap')->orderBy('nama_lengkap')->get();
  }

  private function getStakeholder()
  {
    return DB::table('stakeholders')->select('id','name','focus')->orderBy('name')->get();
  }
  
  public function index()
  {
    $model['counselors'] = $this->getKonselor();
    $model['users'] = $this->getUser();
    $model['stakeholders'] = $this->getStakeholder();
    $model['base_url'] = '/admin/counselor/';
    return view('admin.counselor.index', compact('model'));
  }

  public function create()
  {
    $konselor = $this->getKonselor();
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
    $model->id_stakeholder = $request->id_stakeholder;
    $model->created_at = Carbon::now();
    $model->save();

    Alert::success('Berhasil', 'Anda berhasil menginputkan data');
    return redirect()->to('/admin/counselor');
  }


    public function destroy($id)
    {
      KonselorModel::find($id)->delete();

      return response()->json([
          'state' => true,
          'data' => null,
          'message' => 'Anda berhasil menghapus data!'
      ]);
    }
}
