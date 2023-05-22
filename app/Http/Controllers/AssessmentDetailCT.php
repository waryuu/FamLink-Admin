<?php

namespace App\Http\Controllers;

use App\Http\Traits\MenuTraits;
use App\Models\AssessmentDetailModel;
use App\Models\MenuModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AssessmentDetailCT extends Controller
{
    use MenuTraits;

    private $menuName = "Master Assessment";

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
    
    public function index()
    {
        return view('admin.index');
    }

    public function data(Request $request, $id)
    {
        return Datatables::of(AssessmentDetailModel::query()->where('id_assessment', $id))->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_assessment' => 'required',
            'category' => 'required',
            'type' => 'required',
            'percentage' => 'required'
        ]);

        $model = new AssessmentDetailModel();
        $model->id_assessment = $request->id_assessment;
        $model->category = $request->category;
        $model->percentage = $request->percentage;
        $model->type = $request->type;
        $model->created_at = Carbon::now();
        $model->save();

        Alert::success('Berhasil', 'Anda berhasil menginputkan data');
        return redirect()->to('/admin/assessment/'.$request->id_assessment);
    }

    public function show($id)
    {
        // TODO
    }

    public function edit($id)
    {
        $model = AssessmentDetailModel::find($id);

        return response()->json([
            'data' => $model
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category' => 'required',
            'percentage' => 'required'
        ]);

        $model = AssessmentDetailModel::find($id);
        $model->category = $request->category;
        $model->percentage = $request->percentage;
        $model->save();

        return response()->json([ 'success' => true ]);
    }

    public function destroy($id)
    {
        AssessmentDetailModel::find($id)->delete();

        return response()->json([
            'state' => true,
            'data' => null,
            'message' => 'Anda berhasil menghapus data!'
        ]);
    }
}
