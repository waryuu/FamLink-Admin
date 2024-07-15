<?php

namespace App\Http\Controllers;

use App\Exports\AssignmentExport;
use App\Exports\AssignmentNativeExport;
use App\Http\Traits\MenuTraits;
use App\Models\AssignmentDetailModel;
use App\Models\AssignmentModel;
use App\Models\MenuModel;
use App\Models\RoleHasModel;
use App\Models\TrAssignmentModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


class ReportAssignmentCT extends Controller
{
    use MenuTraits;

    private $menuName = "Laporan Assignment";

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
    
    public function index(Request $request)
    {
        $model['base_url'] = '/admin/reportassignment/';
        $model['assignment'] = DB::select('SELECT b.id, b.title, COUNT(*) AS jumlah FROM t_assignment_master a
        INNER JOIN assignment b ON a.id_assignment = b.id
        GROUP BY a.id_assignment');
        return view('admin.reportassignment.index', compact('model'));
    }
    public function data(Request $request)
    {
        $model = TrAssignmentModel::with('user', 'assignment');
        if(isset($request->id)){
            return Datatables::of($model->where('id_assignment', $request->id)->orderBy('id', 'desc'))->toJson();
        }
        return Datatables::of(TrAssignmentModel::with('user', 'assignment')
        ->orderBy('id', 'desc'))->toJson();
    }

    public function downloadExcel() {
        return Excel::download(new AssignmentExport, 'FAMLINK_LAPORAN_ASSIGNMENT_'.date('Y-m-d_His').'.xlsx');
    }

    public function downloadNative() {
        return Excel::download(new AssignmentNativeExport,
        'FAMLINK_LAPORAN_ASSIGNMENT_DATA_MENTAH_'.date('Y-m-d_His').'.xlsx');
    }
}
