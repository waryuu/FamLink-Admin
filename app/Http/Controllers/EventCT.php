<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventModel;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class EventCT extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model['base_url'] = '/admin/event/';
        return view('admin.event.index', compact('model'));
    }

    public function data()
    {
        return Datatables::of(EventModel::all())->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model['base_url'] = '/admin/event';
        return view('admin.event.create', compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $request;
        // $request->validate([
        //     'title' => 'required',
        //     'content' => 'required',
        //     'status' => 'required',
        //     'image' => 'required|mimes:jpeg,jpg,png,gif|required|max:1000',
        //     ]
        // );

        // $model = new ArticleModel();
        // $model->title = $request->title;
        // $model->content = $request->content;
        // $model->status = $request->status;
        // $model->type = $request->type;
        // $model->created_at = Carbon::now();
        // $model->save();

        // $fileName = $model->id.'-'.time().'.'.$request->image->extension();
        // $request->image->move(public_path('article'), $fileName);
        // $model->image = $fileName;
        // $model->save();

        // if (isset($request->type_value)) {
        //     $fileName = $model->id.'-'.time().'.'.$request->type_value->extension();
        //     $request->type_value->move(public_path('article_pdf'), $fileName);
        //     $model->type_value = $fileName;
        //     $model->save();
        // }

        // $fcm_data['to'] = "/topics/GLOBAL";

        // $data['title'] = 'Artikel Terbaru Famlink';
        // $data['body'] = $model->title;
        // $fcm_data['data'] = $data;

        // $response = Http::withHeaders([
        //     'Authorization' => 'key=AAAAbuzphk8:APA91bHu2-MEMfW1UlZwLQRjczUhGQRy9Vuse8un-DJTpW7M5_igZ-L9GpXXU3OV_7AVjbZ9coRTtjpIeXNqUlDhoz0sC5jbV3j5e3urlclhDtDtBQ2DDybYCNHdmR5QRm-7RHFJMB_Y',
        //     'Content-Type' => 'application/json'
        // ])->post('https://fcm.googleapis.com/fcm/send', $fcm_data);


        // Alert::success('Berhasil', 'Anda berhasil menginputkan data');
        // return redirect()->to('/admin/article');
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
