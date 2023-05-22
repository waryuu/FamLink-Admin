<?php

namespace App\Http\Controllers;

use App\Http\Traits\MenuTraits;
use Illuminate\Http\Request;
use App\Models\MenuModel;
use App\Models\AssignmentModel;
use App\Models\AnswerModel;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
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
    private $menuName = "Bank Soal";

     function __construct()
     {
         $this->fcm_key = env("FCM_KEY", "");;
         
         $this->middleware('auth');
         $this->middleware(function ($request, $next) {
             $this->user = Auth::user();
             $this->menu = MenuModel::where('title', $this->menuName)->select('id')->first();
             if ($this->hasAccess($this->user->role, $this->menu->id)) return $next($request);
         });
     }
     public function index()
    {
        $model['base_url'] = '/admin/assignment/';
        $model['assignments'] = AssignmentModel::with('answers')->paginate(20);
        return view('admin.assignment.index', compact('model'));
    }
     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create()
    {
        $model['base_url'] = '/admin/assignment/';
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
        $model['assignment'] = new AssignmentModel();
        $model['answer'] = new AnswerModel();

        $model['assignment']->id = floor(time()-99999999);
        $model['assignment']->question = $request->question;
        $model['assignment']->category = "Easy"; 
        //$model->answer = $request->answer;
        $model['assignment']->status = $request->status;
        $model['assignment']->created_at = Carbon::now();
        $model['assignment']->correct_answer = $request->correct_answer;


        $model['answer']->answer = $request->input('answer', []);
        $model['answer']->assignment_model_id = $model['assignment']->id;
        $model['answer']->correctness = $request->input('correctness', []);

        $answers = [];
        foreach ($model['answer']->correctness as $index => $answer) {$answers[] = [
                "assignment_model_id" => $model['assignment']->id,
                "answer" => $model['answer']->answer[$index],
                "correctness" => $model['answer']->correctness[$index]
            ];
        }

        //$model['answer']->created_at = Carbon::now();
        $model['assignment']->save();
        AnswerModel::insert($answers);
        
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
        $model['data'] = AssignmentModel::find($id);
        $model['answer'] = AnswerModel::where('assignment_model_id', $model['data']->id)->get();
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

        $model['assignment'] = AssignmentModel::find($id);
        $model['assignment']->question = $request->question;
        $model['assignment']->status = $request->status;
        $model['assignment']->correct_answer = $request->correct_answer;
        $model['assignment']->updated_at = Carbon::now();
        $model['assignment']->save();
         

          foreach($request->id as $key => $value){
            $item = AnswerModel::find($value);
            $item->answer = $request->answer[$key];
            $item->updated_at = Carbon::now();

            $item->save();
        }    
        //return response()->json(['success' => true]);
        Alert::success('Berhasil', 'Anda berhasil mengupdate data');
            return redirect()->to('/admin/assignment');
    }


    public function delete($id)
    {
        $assignment = AssignmentModel::find($id);

        return view('admin.assignment.delete', compact('assignment'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        AssignmentModel::find($id)->delete();

        AnswerModel::where('assignment_model_id',$id)->delete();

        // return response()->json(
        //     [
        //         'state' => true,
        //         'data' => null,
        //         'message' => 'Anda berhasil menghapus data!'
        //     ]
        // );
        Alert::success('Berhasil', 'Anda berhasil menghapus data');
            return redirect()->to('/admin/assignment');
    }

    
}
