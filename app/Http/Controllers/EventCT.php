<?php

namespace App\Http\Controllers;

use App\Http\Traits\MenuTraits;
use Illuminate\Http\Request;
use App\Models\EventModel;
use App\Models\MenuModel;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class EventCT extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use MenuTraits;

    private $menuName = "Master Event";

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
        $request->validate(
            [
                'image' => 'required|mimes:jpeg,jpg,png,gif|max:1000',
                'title' => 'required',
                'organizer' => 'required',
                'price' => 'required',
                'start_time' => 'required',
                'end_time' => 'required|after:start_time',
                'location' => 'required',
                'description' => 'required',
                'registlink' => 'required',
                'status' => 'required',
            ],
            [
                'end_time.after' => 'Waktu selesai harus diatur setelah waktu mulai',
            ]
        );


        $user = Auth::user();
        $model = new EventModel();
        $model->title = $request->title;
        $model->id_staff = $user->id;
        $model->organizer = $request->organizer;
        $model->price = $request->price;
        $model->start_time = $request->start_time;
        $model->end_time = $request->end_time;
        $model->location = $request->location;
        $model->description = $request->description;
        $model->registlink = $request->registlink;
        $model->status = $request->status;
        $model->created_at = Carbon::now();
        $model->save();

        $fileName = $model->id . '-' . time() . '.' . $request->image->extension();
        $request->image->move(public_path('event'), $fileName);
        $model->image = $fileName;
        $model->save();

        $fcm_data['to'] = "/topics/GLOBAL";

        $data['title'] = 'Event Terbaru Famlink';
        $data['body'] = $model->title;
        $fcm_data['data'] = $data;

        $response = Http::withHeaders([
            'Authorization' => 'key='.$this->fcm_key,
            'Content-Type' => 'application/json'
        ])->post('https://fcm.googleapis.com/fcm/send', $fcm_data);

        Alert::success('Berhasil', 'Anda berhasil menginputkan data');
        return redirect()->to('/admin/event');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model['base_url'] = '/admin/event/';
        $model['data'] = EventModel::find($id);
        $model['data']->start_time = Carbon::parse($model['data']->start_time)->format('Y-m-d\TH:i');
        $model['data']->end_time = Carbon::parse($model['data']->end_time)->format('Y-m-d\TH:i');
        return view('admin.event.show', compact('model'));
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
        $request->validate(
            [
                'image' => 'mimes:jpeg,jpg,png,gif|max:1000',
                'title' => 'required',
                'organizer' => 'required',
                'price' => 'required',
                'start_time' => 'required',
                'end_time' => 'required',
                'location' => 'required',
                'description' => 'required',
                'registlink' => 'required',
                'status' => 'required',
            ]
        );

        $user = Auth::user();
        $model = EventModel::find($id);
        $model->title = $request->title;
        $model->id_staff = $user->id;
        $model->organizer = $request->organizer;
        $model->price = $request->price;
        $model->start_time = $request->start_time;
        $model->end_time = $request->end_time;
        $model->location = $request->location;
        $model->description = $request->description;
        $model->registlink = $request->registlink;
        $model->status = $request->status;
        $model->updated_at = Carbon::now();

        if (isset($request->image)) {
            $fileName = $model->id . '-' . time() . '.' . $request->image->extension();
            $request->image->move(public_path('event'), $fileName);
            $model->image = $fileName;
        }

        $model->save();
        Alert::success('Berhasil', 'Anda berhasil update data');
        return redirect()->to('/admin/event');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        EventModel::find($id)->delete();

        return response()->json(
            [
                'state' => true,
                'data' => null,
                'message' => 'Anda berhasil menghapus data!'
            ]
        );
    }
}
