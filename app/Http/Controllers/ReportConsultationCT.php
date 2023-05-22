<?php

namespace App\Http\Controllers;

use App\Exports\ConsultationExport;
use App\Http\Traits\MenuTraits;
use App\Models\ConsultationThreadModel;
use App\Models\CtReplyModel;
use App\Models\MenuModel;
use App\Models\StakeholderThreadModel;
use App\Models\StReplyModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class ReportConsultationCT extends Controller
{
    use MenuTraits;

    private $menuName = "Laporan Konsultasi";

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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model['base_url'] = '/admin/reportconsultation/';
        $model['consul_base_url'] = '/admin/consultation/';
        $allPrivateConsul = ConsultationThreadModel::where('type', 'private')->get();
        $allPublicConsul = ConsultationThreadModel::where('type', 'public')->get();
        $allClosedConsul = ConsultationThreadModel::where('state', 'closed')->get();
        $allOngoingConsul = ConsultationThreadModel::where('state', '!=', 'closed')->get();

        $model['total'] = count(ConsultationThreadModel::all());
        $model['total_private'] = count($allPrivateConsul);
        $model['total_public'] = count($allPublicConsul);
        $model['total_closed'] = count($allClosedConsul);
        $model['total_ongoing'] = count($allOngoingConsul);

        return view('admin.reportconsul.index', compact('model'));
    }

    public function downloadExcel()
    {
        return Excel::download(new ConsultationExport, 'FAMLINK_LAPORAN_KONSULTASI_' . date('Y-m-d_His') . '.xlsx');
    }
}
