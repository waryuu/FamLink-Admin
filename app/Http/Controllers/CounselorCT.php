<?php

namespace App\Http\Controllers;

use App\Http\Traits\MenuTraits;
use App\Models\KonselorModel;
use App\Models\MenuModel;
use App\Models\RulesModel;
use App\Models\StakeholderModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CounselorCT extends Controller
{
  use MenuTraits;

  private $menuName = "Master Konselor";

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


  public function edit($id)
  {
    $model = KonselorModel::where('konselors.id', $id)->join('m_user', 'konselors.id_user', '=', 'm_user.id')
      ->join('stakeholders', 'konselors.id_stakeholder', '=', 'stakeholders.id')
      ->select('konselors.*', 'm_user.nama_lengkap', 'stakeholders.name as nama_stakeholder')->first();

    return response()->json([
      'data' => $model
    ]);
  }

  public function store(Request $request)
  {
    $request->validate([
      'id_user' => 'required',
      'id_stakeholder' => 'required',
      'expertise' => 'required',
    ]);

    $model = new KonselorModel();
    $model->id_user = $request->id_user;
    $model->status = 1;
    $model->id_stakeholder = $request->id_stakeholder;
    $model->expertise = $request->expertise;
    $model->created_at = Carbon::now();

    $user = UserModel::find($request->id_user);

    $response = Http::asForm()->post($this->api_url . '/api/v2/token/reset', [
      'token' => $user->token,
    ]);

    if ($response->status() == 200) {
      $model->save();
      Alert::success('Berhasil', 'Anda berhasil menginputkan data');
      return redirect()->to('/admin/counselor');
    } else {
      Alert::warning('Gagal', 'Gagal menambahkan konselor, coba beberapa saat lagi');
      return redirect()->to('/admin/counselor');
    }
  }

  public function update(Request $request, $id)
  {
    $request->validate(
      [
        'id_user' => 'required',
        'id_stakeholder' => 'required',
        'expertise' => 'required',
      ]
    );

    $model = KonselorModel::find($id);
    $model->id_user = $request->id_user;
    $model->id_stakeholder = $request->id_stakeholder;
    $model->expertise = $request->expertise;
    $model->updated_at = Carbon::now();
    $model->save();

    return response()->json(['success' => true]);
  }

  public function destroy($id)
  {
    $model = KonselorModel::find($id);
    $model->status = 0;

    $user = UserModel::find($model->id_user);
    $response = Http::asForm()->post($this->api_url . '/api/v2/token/reset', [
      'token' => $user->token,
    ]);

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

  public function restore($id)
  {
    $model = KonselorModel::find($id);
    $model->status = 1;

    $user = UserModel::find($model->id_user);
    $response = Http::asForm()->post($this->api_url . '/api/v2/token/reset', [
      'token' => $user->token,
    ]);
    
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
