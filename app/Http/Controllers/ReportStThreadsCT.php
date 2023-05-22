<?php

namespace App\Http\Controllers;

use App\Exports\StakeholderThreadExport;
use App\Http\Traits\MenuTraits;
use App\Models\MenuModel;
use App\Models\StakeholderThreadModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class ReportStThreadsCT extends Controller
{
    use MenuTraits;

    private $menuName = "Laporan Diskusi Stakeholder";

    function __construct()
    {
        $this->api_url = env("API_URL", "");;
        
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            $this->menu = MenuModel::where('title', $this->menuName)->select('id')->first();
            if ($this->hasAccess($this->user->role, $this->menu->id)) {
                return $next($request);
            }
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model['base_url'] = '/admin/reportsthreads/';
        $model['sthread_base_url'] = '/admin/stakeholder/threads/';
        $model['public_url_thread'] = $this->api_url . '/stakeholder/threads/';
        $model['public_url_replies'] = $this->api_url . '/stakeholder/replies/';

        $allClosedSthread = StakeholderThreadModel::where('state', 'CLOSED')->get();
        $allOngoingSthread = StakeholderThreadModel::where('state', 'OPEN')->get();

        $model['total'] = count(StakeholderThreadModel::all());
        $model['total_closed'] = count($allClosedSthread);
        $model['total_ongoing'] = count($allOngoingSthread);

        return view('admin.reportsthread.index', compact('model'));
    }

    private function getThreads()
    {
        return DB::table('stakeholderthreads')
            ->join('stakeholdermembers', 'stakeholderthreads.id_stmember', '=', 'stakeholdermembers.id')
            ->join('m_user', 'stakeholdermembers.id_user', '=', 'm_user.id')
            ->join('stakeholders', 'stakeholdermembers.id_stakeholder', '=', 'stakeholders.id')
            ->select('stakeholderthreads.*', 'stakeholdermembers.id_user',
            'm_user.nama_lengkap AS name_user', 'stakeholders.name AS name_stakeholder');
    }

    public function getThreadsByFilter($filter)
    {
        $allThreads = $this->getThreads();

        if ($filter == 'closed') {
            $filtered = $allThreads->where("stakeholderthreads.state", '=', 'CLOSED')->get();
            return Datatables::of($filtered)->make(true);
        } else if ($filter == 'ongoing') {
            $filtered = $allThreads->where("stakeholderthreads.state", '=', 'OPEN')->get();
            return Datatables::of($filtered)->make(true);
        } else {
            return Datatables::of($allThreads->get())->make(true);
        }
    }

    public function downloadExcel()
    {
        return Excel::download(new StakeholderThreadExport,
        'FAMLINK_LAPORAN_DISKUSI_JEJARING_' . date('Y-m-d_His') . '.xlsx');
    }
}
