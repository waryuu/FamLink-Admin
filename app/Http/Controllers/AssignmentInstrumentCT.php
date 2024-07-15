<?php

namespace App\Http\Controllers;

use App\Http\Traits\MenuTraits;
use Illuminate\Http\Request;
use App\Models\MenuModel;
use App\Models\AssignmentInstrumentModel;
use App\Models\AssignmentModel;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AssignmentInstrumentCT extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    use MenuTraits;
    private $menuName = "Master Assignment";

     function __construct()
     {
         $this->fcm_key = env("FCM_KEY", "");;
         
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
    //     $model['base_url'] = '/admin/assignment/';
    //     $model['assignments'] = AssignmentModel::with('answers')->oldest()->paginate(5);
    //     $model['i'] = $model['assignments']->firstItem();
    //     return view('admin.assignment.index', compact('model'));
    }
    public function data()
    {
        $model = AssignmentInstrumentModel::join(
            'assignment', 'assignment_instrument.id_assignment', '=', 'assignment.id')
            ->join('m_staff', 'assignment_instrument.id_staff', '=', 'm_staff.id')
            ->select('assignment_instrument.*', 'assignment.title', 'm_staff.name')
            ->get();
        return DataTables::of($model)->toJson();
    }
     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create()
    {
        $model['assignment'] = AssignmentModel::all();
        $model['instrument_url'] = '/admin/assignment-instrument';
        $model['assignment_url'] = '/admin/assignment';
        return view('admin.assignment.create', compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required',
            'question' => 'required'
            ]
        );
        
        $user = Auth::user();
        $model['instrument'] = new AssignmentInstrumentModel();
        $model['instrument']->id_staff = $user->id;
        $model['instrument']->id_assignment = $request->id_assignment;
        $model['instrument']->question = $request->question;
        $model['instrument']->option_a = $request->option_a;
        $model['instrument']->option_b = $request->option_b;
        $model['instrument']->option_c = $request->option_c;
        $model['instrument']->option_d = $request->option_d;
        $model['instrument']->correct_answer = $request->correct_answer;
        $model['instrument']->status = $request->status;
        $model['instrument']->created_at = Carbon::now();
       
        $model['instrument']->save();
     
        Alert::success('Berhasil', 'Anda berhasil menginputkan data');
        return redirect()->to('/admin/assignment');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model['assignment_url'] = '/admin/assignment/';
        $model['instrument_url'] = '/admin/assignment-instrument/';
        $model['assignment'] = AssignmentModel::all();
        $model['instrument'] = AssignmentInstrumentModel::find($id);
        //$model['answer'] = AnswerModel::where('assignment_model_id', $model['assignment']->id)->get();
        return view('admin.assignment.show', compact('model'));
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
        $request->validate(
      [
        
      ]
      );
      
        $user = Auth::user();
        $model['instrument'] = AssignmentInstrumentModel::find($id);
        $model['instrument']->id_staff = $user->id;
        $model['instrument']->id_assignment = $request->id_assignment;
        $model['instrument']->question = $request->question;
        $model['instrument']->option_a = $request->option_a;
        $model['instrument']->option_b = $request->option_b;
        $model['instrument']->option_c = $request->option_c;
        $model['instrument']->option_d = $request->option_d;
        $model['instrument']->status = $request->status;
        $model['instrument']->correct_answer = $request->correct_answer;
        $model['instrument']->updated_at = Carbon::now();
        $model['instrument']->save();


        Alert::success('Berhasil', 'Anda berhasil mengupdate data');
            return redirect()->to('/admin/assignment');
    }


    // public function delete($id)
    // {
    //     $assignment = AssignmentModel::find($id);

    //     return view('admin.assignment.delete', compact('assignment'));
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        AssignmentInstrumentModel::find($id)->delete();

        return response()->json([
            'state' => true,
            'data' => null,
            'message' => 'Anda berhasil menghapus data!'
            ]
        );
    }
    
}
