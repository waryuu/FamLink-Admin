<?php

namespace App\Http\Controllers;

use App\Exports\AssessmentExport;
use App\Exports\AssessmentNativeExport;
use App\Http\Traits\MenuTraits;
use App\Models\AssessmentDetailModel;
use App\Models\AssessmentModel;
use App\Models\MenuModel;
use App\Models\RoleHasModel;
use App\Models\TrAssessmentModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


class ReportCT extends Controller
{
    use MenuTraits;

    private $menuName = "Laporan Assessment";

    function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            $this->menu = MenuModel::where('title', $this->menuName)->select('id')->first();
            if ($this->hasAccess($this->user->role, $this->menu->id)) return $next($request);
        });
    }
    
    public function index(Request $request)
    {
        $model['base_url'] = '/admin/report/';
        $model['assessment'] = DB::select('SELECT b.id, b.title, b.image, COUNT(*) AS jumlah FROM t_assessment_master a
        INNER JOIN m_assessment b ON a.id_assessment = b.id
        WHERE a.result IS NOT NULL
        GROUP BY a.id_assessment');
        return view('admin.report.index', compact('model'));
    }

    public function data(Request $request)
    {
        if(isset($request->id)){
            return Datatables::of(TrAssessmentModel::with('user', 'assessment', 'assessment_result')->where('result', '!=', null)->where('id_assessment', $request->id)->orderBy('id', 'desc'))->make(true);
        }
        return Datatables::of(TrAssessmentModel::with('user', 'assessment', 'assessment_result')->where('result', '!=', null)->orderBy('id', 'desc'))->make(true);
    }

    public function create()
    {
        $model['base_url'] = '/admin/report/';
        return view('admin.report.create', compact('model'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'status' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png,gif|required|max:1000',
            ]
        );

        $model = new TrAssessmentModel();
        $model->title = $request->title;
        $model->content = $request->content;
        $model->status = $request->status;
        $model->created_at = Carbon::now();
        $model->save();

        $fileName = $model->id.'-'.time().'.'.$request->image->extension();
        $request->image->move(public_path('report'), $fileName);
        $model->image = $fileName;
        $model->save();

        Alert::success('Berhasil', 'Anda berhasil menginputkan data');
        return redirect()->to('/admin/report');
    }

    public function show($id)
    {
        $model['base_url'] = '/admin/report/';
        $model['data'] = TrAssessmentModel::find($id);
        $model['detail'] = AssessmentDetailModel::where('id_assessment', $model['data']->id)->get();
        return view('admin.report.show', compact('model'));
    }

    public function edit($id)
    {
        $model = TrAssessmentModel::find($id);

        return response()->json([
            'data' => $model
            ]
        );
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'status' => 'required',
            'image' => 'mimes:jpeg,jpg,png,gif|max:1000',
            ]
        );

        $model = TrAssessmentModel::find($id);
        $model->title = $request->title;
        $model->content = $request->content;
        $model->status = $request->status;
        $model->updated_at = Carbon::now();
        if (isset($request->image)){
            $fileName = $id.'-'.time().'.'.$request->image->extension();
            $request->image->move(public_path('report'), $fileName);
            $model->image = $fileName;
        }
        $model->save();

        Alert::success('Berhasil', 'Anda berhasil update data');
        return redirect()->to('/admin/report');
    }

    public function destroy($id)
    {
        TrAssessmentModel::find($id)->delete();

        return response()->json([
            'state' => true,
            'data' => null,
            'message' => 'Anda berhasil menghapus data!'
            ]
        );
    }

    public function download() {
        return Excel::download(new AssessmentExport, 'FAMLINK_LAPORAN_ASSESSMENT_'.date('Y-m-d_His').'.xlsx');
    }

    public function downloadNative() {
        return Excel::download(new AssessmentNativeExport, 'FAMLINK_LAPORAN_ASSESSMENT_DATA_MENTAH_'.date('Y-m-d_His').'.xlsx');
    }
}
