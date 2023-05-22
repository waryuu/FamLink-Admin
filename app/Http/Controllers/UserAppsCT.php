<?php

namespace App\Http\Controllers;

use App\Exports\UserAppsExport;
use App\Http\Traits\MenuTraits;
use App\Models\AssessmentDetailModel;
use App\Models\MenuModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class UserAppsCT extends Controller
{
    use MenuTraits;

    private $menuName = "Laporan Pengguna";

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
        $model['base_url'] = '/admin/userapps/';
        $_user = UserModel::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as jumlah'))
                            ->groupBy(DB::raw('DATE(created_at)'))
                            ->orderBy('created_at', 'asc');
        $model['chart_user_date'] = $_user->pluck('date');
        $model['chart_user_jumlah'] = $_user->pluck('jumlah');

        $_pekerjaan = UserModel::select(DB::raw('pekerjaan as data'), DB::raw('COUNT(*) as jumlah'))
                                ->groupBy(DB::raw('pekerjaan'))->having('jumlah', '>', 10)
                                ->orderBy('pekerjaan', 'asc')->limit(10);
        $model['chart_pekerjaan_data'] = $_pekerjaan->pluck('data');
        $model['chart_pekerjaan_jumlah'] = $_pekerjaan->pluck('jumlah');

        $_gender = UserModel::select(DB::raw('jenis_kelamin as data'), DB::raw('COUNT(*) as jumlah'))
                            ->groupBy(DB::raw('jenis_kelamin'))
                            ->orderBy('jenis_kelamin', 'asc');
        $model['chart_gender_data'] = $_gender->pluck('data');
        $model['chart_gender_jumlah'] = $_gender->pluck('jumlah');

        $_usia[] = DB::select("select CONCAT('0 - 5') as title,
                            count(usia) as usia from v_report_pengguna where usia BETWEEN 0 and 5")[0];
		$_usia[] = DB::select("select CONCAT('6 - 19') as title,
                            count(usia) as usia from v_report_pengguna where usia BETWEEN 6 and 19")[0];
		$_usia[] = DB::select("select CONCAT('20 - 29') as title,
                            count(usia) as usia from v_report_pengguna where usia BETWEEN 20 and 29")[0];
		$_usia[] = DB::select("select CONCAT('30 - 39') as title,
                            count(usia) as usia from v_report_pengguna where usia BETWEEN 30 and 39")[0];
		$_usia[] = DB::select("select CONCAT('40 - 49') as title,
                            count(usia) as usia from v_report_pengguna where usia BETWEEN 40 and 49")[0];
		$_usia[] = DB::select("select CONCAT('50 - 59') as title,
                            count(usia) as usia from v_report_pengguna where usia BETWEEN 50 and 59")[0];
		$_usia[] = DB::select("select CONCAT('60 - 60') as title,
                            count(usia) as usia from v_report_pengguna where usia BETWEEN 60 and 69")[0];
		$_usia[] = DB::select("select CONCAT('70 - 79') as title,
                            count(usia) as usia from v_report_pengguna where usia BETWEEN 70 and 79")[0];
		$_usia[] = DB::select("select CONCAT('> 80') as title,
                            count(usia) as usia from v_report_pengguna where usia > 80")[0];

        $model['chart_usia'] = $_usia;

        $model['total'] = UserModel::count();

        return view('admin.userapps.index', compact('model'));
    }

    public function data()
    {
        return Datatables::of(UserModel::orderBy('id', 'desc'))->toJson();
    }

    public function create()
    {
        $model['base_url'] = '/admin/userapps/';
        return view('admin.userapps.create', compact('model'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'status' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png,gif|required|max:1000',
            ]
        );

        $model = new UserModel();
        $model->title = $request->title;
        $model->status = $request->status;
        $model->created_at = Carbon::now();
        $model->save();

        $fileName = $model->id.'-'.time().'.'.$request->image->extension();
        $request->image->move(public_path('banner'), $fileName);
        $model->image = $fileName;
        $model->save();

        Alert::success('Berhasil', 'Anda berhasil menginputkan data');
        return redirect()->to('/admin/banner');
    }

    public function show($id)
    {
        $model['base_url'] = '/admin/userapps/';
        $model['data'] = UserModel::find($id);
        $model['detail'] = AssessmentDetailModel::where('id_assessment', $model['data']->id)->get();
        return view('admin.userapps.show', compact('model'));
    }

    public function edit($id)
    {
        $model = UserModel::find($id);

        return response()->json([
            'data' => $model
            ]
        );
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'title' => 'required',
            'status' => 'required',
            'image' => 'mimes:jpeg,jpg,png,gif|max:1000',
            ]
        );

        $model = UserModel::find($id);
        $model->title = $request->title;
        $model->status = $request->status;
        $model->updated_at = Carbon::now();
        if (isset($request->image)){
            $fileName = $id.'-'.time().'.'.$request->image->extension();
            $request->image->move(public_path('banner'), $fileName);
            $model->image = $fileName;
        }
        $model->save();

        Alert::success('Berhasil', 'Anda berhasil update data');
        return redirect()->to('/admin/banner');
    }

    public function destroy($id)
    {
        UserModel::find($id)->delete();

        return response()->json([
            'state' => true,
            'data' => null,
            'message' => 'Anda berhasil menghapus data!'
            ]
        );
    }

    public function download() {
        return Excel::download(new UserAppsExport, 'FAMLINK_LAPORAN_PENGGUNA_'.date('Y-m-d_His').'.xlsx');
    }
}
