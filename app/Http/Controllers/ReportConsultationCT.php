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
            if ($this->hasAccess($this->user->role, $this->menu->id)) return $next($request);
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

    public function getQuery()
    {
        // VIEW REPLIES THREAD 
        // return StReplyModel::join('stakeholderthreads', 'streplies.id_sthread', '=', 'stakeholderthreads.id')
        //     ->join('stakeholdermembers', 'streplies.id_stmember', '=', 'stakeholdermembers.id')
        //     ->join('m_user', 'stakeholdermembers.id_user', '=', 'm_user.id')
        //     ->join('stakeholders', 'stakeholdermembers.id_stakeholder', '=', 'stakeholders.id')
        //     ->select(
        //         'stakeholderthreads.id',
        //         'm_user.nama_lengkap',
        //         'stakeholders.name AS name_stakeholder',
        //         'stakeholderthreads.title',
        //         'streplies.content',
        //         'streplies.images',
        //         'stakeholderthreads.state',
        //         'stakeholderthreads.status',
        //         'streplies.created_at',
        //         'stakeholderthreads.closed_at',
        //     )
        //     // ->get();
        //     ->toSql();

        // VIEW STAKEHOLDER THREAD 
        // return StakeholderThreadModel::join('stakeholdermembers', 'stakeholderthreads.id_stmember', '=', 'stakeholdermembers.id')
        //     ->join('m_user', 'stakeholdermembers.id_user', '=', 'm_user.id')
        //     ->join('stakeholders', 'stakeholdermembers.id_stakeholder', '=', 'stakeholders.id')
        //     ->select(
        //         'stakeholderthreads.id',
        //         'm_user.nama_lengkap',
        //         'stakeholders.name AS name_stakeholder',
        //         'stakeholderthreads.title',
        //         'stakeholderthreads.content',
        //         'stakeholderthreads.images',
        //         'stakeholderthreads.state',
        //         'stakeholderthreads.status',
        //         'stakeholderthreads.created_at',
        //         'stakeholderthreads.closed_at',
        //     )
        //     // ->get();
        //     ->toSql();


        // VIEW KONSULTASI 
        // return ConsultationThreadModel::join('m_user', 'consultationthreads.id_user', '=', 'm_user.id')
        //     ->leftJoin('konselors', 'consultationthreads.id_user', '=', 'konselors.id_user')
        //     ->leftJoin('stakeholders', 'konselors.id_stakeholder', '=', 'stakeholders.id')
        //     ->leftJoin('m_user AS konselor_user', 'konselors.id_user', '=', 'konselor_user.id')
        //     // ->where("consultationthreads.type", '=', 'public')
        //     ->select(
        //         'consultationthreads.id',
        //         'm_user.nama_lengkap',
        //         'stakeholders.name AS name_stakeholder',
        //         'consultationthreads.type',
        //         'consultationthreads.title',
        //         'consultationthreads.content',
        //         'consultationthreads.state',
        //         'consultationthreads.open_to_all',
        //         'consultationthreads.status',
        //         'consultationthreads.role_who_closed',
        //         'consultationthreads.closed_at',
        //         'consultationthreads.created_at'
        //     )
        //     // ->get();
        // ->toSql();

        // // VIEW BALASAN KONSULTASI 
        // return CtReplyModel::join('consultationthreads', 'ctreplies.id_cthread', '=', 'consultationthreads.id')
        //     ->join('m_user', 'ctreplies.id_user', '=', 'm_user.id')
        //     ->leftJoin('konselors', 'ctreplies.id_user', '=', 'konselors.id_user')
        //     ->leftJoin('stakeholders', 'konselors.id_stakeholder', '=', 'stakeholders.id')
        //     // ->where("consultationthreads.type", '=', 'public')
        //     ->select(
        //         'consultationthreads.id',
        //         'm_user.nama_lengkap',
        //         'stakeholders.name AS name_stakeholder',
        //         'consultationthreads.type',
        //         'consultationthreads.title',
        //         'ctreplies.content',
        //         'ctreplies.reply_from',
        //         'consultationthreads.state',
        //         'consultationthreads.open_to_all',
        //         'consultationthreads.status',
        //         'consultationthreads.role_who_closed',
        //         'ctreplies.created_at',
        //         'consultationthreads.closed_at',
        //     )
        //     // ->get();
        //     ->toSql();
    }
}
