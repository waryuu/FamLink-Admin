<?php

namespace App\Http\Controllers;

use App\Http\Traits\MenuTraits;
use Illuminate\Http\Request;
use App\Models\MenuModel;
use App\Models\AssignmentModel;
use App\Models\AssignmentCategoryModel;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AssignmentCT extends Controller
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
    //  public function index()
    // {
    //     $model['base_url'] = '/admin/assignment/';
    //     $model['assignments'] = AssignmentModel::with('answers')->oldest()->paginate(5);
    //     $model['i'] = $model['assignments']->firstItem();
    //     return view('admin.assignment.index', compact('model'));
    // }
     public function index()
    {
        $model['base_url'] = '/admin/assignment/';
        $model['category_base_url'] = '/admin/assignment-category/';
        return view('admin.assignment.index', compact('model'));
    }

    public function data()
    {
        $resprotect = Datatables::of(
            AssignmentModel::join('assignment_categorys', 'assignment.id_category', '=', 'assignment_categorys.id')
            ->select('assignment.*', 'assignment_categorys.name')
            ->get())->make(true);

        $res = $resprotect->getData();
        return $res;
    }

    public function data_category()
    {
        return Datatables::of(AssignmentCategoryModel::all())->make(true);
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create()
    {
        $model['category'] = AssignmentCategoryModel::all();
        $model['base_url'] = '/admin/assignment';
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
        $model['assignment'] = new AssignmentModel();
        $model['assignment']->id_staff = $user->id;
        $model['assignment']->id_category = $request->id_category;
        $model['assignment']->question = $request->question;
        $model['assignment']->option_a = $request->option_a;
        $model['assignment']->option_b = $request->option_b;
        $model['assignment']->option_c = $request->option_c;
        $model['assignment']->option_d = $request->option_d;
        
        $model['assignment']->status = $request->status;
        $model['assignment']->created_at = Carbon::now();
        $model['assignment']->correct_answer = $request->correct_answer;

        
        $model['assignment']->save();
        
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
        $model['base_url'] = '/admin/assignment/';
        $model['category'] = AssignmentCategoryModel::all();
        $model['assignment'] = AssignmentModel::find($id);
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
        $model['assignment'] = AssignmentModel::find($id);
        $model['assignment']->id_staff = $user->id;
        $model['assignment']->id_category = $request->id_category;

        $model['assignment']->question = $request->question;
        $model['assignment']->option_a = $request->option_a;
        $model['assignment']->option_b = $request->option_b;
        $model['assignment']->option_c = $request->option_c;
        $model['assignment']->option_d = $request->option_d;
        $model['assignment']->status = $request->status;
        $model['assignment']->correct_answer = $request->correct_answer;
        $model['assignment']->updated_at = Carbon::now();
        $model['assignment']->save();


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
        AssignmentModel::find($id)->delete();

        return response()->json([
            'state' => true,
            'data' => null,
            'message' => 'Anda berhasil menghapus data!'
            ]
        );
    }
    
}
