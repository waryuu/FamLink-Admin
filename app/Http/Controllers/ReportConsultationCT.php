<?php

namespace App\Http\Controllers;

use App\Http\Traits\MenuTraits;
use App\Models\ConsultationThreadModel;
use App\Models\MenuModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    // public function data($type)
    // {
    //     if($type == 'all'){
    //         return Datatables::of(ConsultationThreadModel::with('user', 'assessment', 'assessment_result')->where('result', '!=', null)->where('id_assessment', $request->id)->orderBy('id', 'desc'))->make(true);
    //     }
    //     return Datatables::of(ConsultationThreadModel::with('user', 'assessment', 'assessment_result')->where('result', '!=', null)->orderBy('id', 'desc'))->make(true);
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
