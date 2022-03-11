<?php

namespace App\Http\Controllers;

use App\Http\Traits\MenuTraits;
use Illuminate\Http\Request;

use App\Models\AssessmentDetailModel;
use App\Models\AssessmentResultModel;
use App\Models\MenuModel;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AssesmentResultCT extends Controller
{
    use MenuTraits;

    private $menuName = "Master Assessment";

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
        return view('admin.index');
    }

    public function data(Request $request, $id)
    {
        return Datatables::of(AssessmentResultModel::select('id', 'title', 'range_down', 'range_up', 'color')->where('id_assessment', $id))->make(true);
    }


    public function store(Request $request)
    {
        $request->validate([
            'assesment_id' => 'required',
            'title' => 'required',
            'color' => 'required',
            'description' => 'required',
            'range_down' => 'required',
            'range_up' => 'required'
        ]);

        $data = AssessmentDetailModel::findOrFail($request->assesment_id);

        $model = new AssessmentResultModel();
        $model->id_assessment = $request->assesment_id;
        $model->result_type = 1;
        $model->title = $request->title;
        $model->description = $request->description;
        $model->color = $request->color;
        $model->range_down = $request->range_down;
        $model->range_up = $request->range_up;
        $model->created_at = Carbon::now('Asia/Jakarta');
        $model->save();

        Alert::success('Berhasil', 'Anda berhasil menginputkan data');
        return redirect()->to('/admin/assessment/'.$request->assesment_id);
    }

    public function show($id)
    {
        $model['base_url'] = '/admin/assessment-result';
        $model['id'] = $id;
        return view('admin.assessment.result_create', compact('model'));
    }

    public function edit($id)
    {
        $data = AssessmentResultModel::find($id);

        $model['base_url'] = '/admin/assessment-result/';
        $model['id'] = $id;

        $model['data'] = $data;

        return view('admin.assessment.result_edit', compact('model'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'color' => 'required',
            'description' => 'required',
            'range_down' => 'required',
            'range_up' => 'required'
        ]);

        $model = AssessmentResultModel::findOrFail($id);
        $model->title = $request->title;
        $model->description = $request->description;
        $model->color = $request->color;
        $model->range_down = $request->range_down;
        $model->range_up = $request->range_up;
        $model->save();

        Alert::success('Berhasil', 'Anda berhasil mengubah data');
        return redirect()->to('/admin/assessment/'.$model->id_assessment);
    }

    public function destroy($id)
    {
        AssessmentResultModel::findOrFail($id)->delete();
        return response()->json([
            'state' => true,
            'data' => null,
            'message' => 'Anda berhasil menghapus data!'
            ]
        );
    }
}
