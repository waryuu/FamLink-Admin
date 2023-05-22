<?php

namespace App\Http\Controllers;

use App\Http\Traits\MenuTraits;
use App\Models\AssessmentInstrumentModel;
use App\Models\MenuModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AssessmentInstrumenCT extends Controller
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
    
    public function index(Request $request)
    {
        return Datatables::of(AssessmentInstrumentModel::query()->with('detail'))->make(true);
        return view('admin.index');
    }

    public function data(Request $request, $id)
    {
        $assessment = AssessmentInstrumentModel::query()->with('detail')->whereHas('detail', function ($q) use($id) {
            $q->where('id_assessment', $id);
        })->orderBy('id', 'desc');

        return Datatables::of($assessment)->toJson();
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_assessment' => 'required',
            'assessment_detail_category' => 'required',
            'question' => 'required',
            ]
        );

        $model = new AssessmentInstrumentModel();
        $model->id_assessment_detail = $request->assessment_detail_category;
        $model->question = $request->question;
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
        $model = AssessmentInstrumentModel::find($id);

        return response()->json([
            'data' => $model
            ]
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'question' => 'required',
            ]
        );

        $model = AssessmentInstrumentModel::find($id);
        $model->question = $request->question;
        $model->save();

        return response()->json([ 'success' => true ]);
    }

    public function destroy($id)
    {
        AssessmentInstrumentModel::find($id)->delete();

        return response()->json([
            'state' => true,
            'data' => null,
            'message' => 'Anda berhasil menghapus data!'
            ]);
        }
    }
