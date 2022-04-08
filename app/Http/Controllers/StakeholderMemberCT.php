<?php

namespace App\Http\Controllers;

use App\Http\Traits\MenuTraits;
use App\Models\KonselorModel;
use App\Models\MenuModel;
use App\Models\StakeholderMemberModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class StakeholderMemberCT extends Controller
{
  use MenuTraits;

  private $menuName = "Master Stakeholder";

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
    $model['base_url'] = '/admin/stakeholder/members/';
    $model['users'] = $this->getUser();
    $model['stakeholders'] = $this->getStakeholder();
    return view('admin.stakeholder.member', compact('model'));
  }

  public function create()
  {
    return Datatables::of($this->getMember())->make(true);
  }

  public function edit($id)
  {
    $model = StakeholderMemberModel::where('stakeholdermembers.id', $id)->join('m_user', 'stakeholdermembers.id_user', '=', 'm_user.id')
      ->join('stakeholders', 'stakeholdermembers.id_stakeholder', '=', 'stakeholders.id')
      ->select('stakeholdermembers.*', 'm_user.nama_lengkap', 'stakeholders.name as nama_stakeholder')->first();

    return response()->json([
      'data' => $model
    ]);
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

    $isCounselor = KonselorModel::where('id_user', $request->id_user)->first();

    if (!isset($isCounselor)) {
      $model = new StakeholderMemberModel();
      $model->id_user = $request->id_user;
      $model->id_stakeholder = $request->id_stakeholder;
      $model->position = $request->position;
      $model->created_at = Carbon::now();

      $user = UserModel::find($request->id_user);

      if (isset($user->token)) {
        $response = Http::asForm()->post($this->api_url . '/api/v2/token/reset', [
          'token' => $user->token,
        ]);
      } else {
        $response = Http::asForm()->post($this->api_url . '/api/v2/token/reset', [
          'email' => $user->email,
        ]);
      }

      if ($response->status() == 200) {
        $model->save();
        Alert::success('Berhasil', 'Anda berhasil menginputkan data');
        return redirect()->to('/admin/stakeholder/members');
      } else {
        Alert::warning('Gagal', 'Gagal menambahkan anggota, coba beberapa saat lagi');
        return redirect()->to('/admin/stakeholder/members');
      }
    } else {
      Alert::warning('Gagal', 'Pengguna terdeteksi telah ditambahkan sebagai konselor!');
      return redirect()->to('/admin/stakeholder/members');
    }
  }

  public function update(Request $request, $id)
  {
    $request->validate(
      [
        'id_user' => 'required',
        'id_stakeholder' => 'required',
        'position' => 'required',
      ]
    );

    $model = StakeholderMemberModel::find($id);
    $model->id_user = $request->id_user;
    $model->id_stakeholder = $request->id_stakeholder;
    $model->position = $request->position;
    $model->updated_at = Carbon::now();
    $model->save();

    return response()->json(['success' => true]);
  }

  public function destroy($id)
  {
    $model = StakeholderMemberModel::find($id);
    $model->status = 0;

    $user = UserModel::find($model->id_user);

    if (isset($user->token)) {
      $response = Http::asForm()->post($this->api_url . '/api/v2/token/reset', [
        'token' => $user->token,
      ]);
    } else {
      $response = Http::asForm()->post($this->api_url . '/api/v2/token/reset', [
        'email' => $user->email,
      ]);
    }

    if ($response->status() == 200) {
      $model->save();
      return response()->json([
        'state' => true,
        'data' => null,
        'message' => 'Anda berhasil menghapus data!'
      ]);
    } else {
      return response()->json([
        'state' => false,
        'data' => null,
        'message' => 'Anda gagal menghapus data!, coba beberapa saat lagi'
      ]);
    }
  }

  public function restoreMember($id)
  {
    $model = StakeholderMemberModel::find($id);
    $model->status = 1;

    $user = UserModel::find($model->id_user);

    if (isset($user->token)) {
      $response = Http::asForm()->post($this->api_url . '/api/v2/token/reset', [
        'token' => $user->token,
      ]);
    } else {
      $response = Http::asForm()->post($this->api_url . '/api/v2/token/reset', [
        'email' => $user->email,
      ]);
    }

    if ($response->status() == 200) {
      $model->save();
      return response()->json([
        'state' => true,
        'data' => null,
        'message' => 'Anda berhasil mengembalikan data!'
      ]);
    } else {
      return response()->json([
        'state' => false,
        'data' => null,
        'message' => 'Anda gagal mengembalikan data!, coba beberapa saat lagi'
      ]);
    }
  }
}
