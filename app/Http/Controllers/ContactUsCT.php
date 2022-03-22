<?php

namespace App\Http\Controllers;

use App\Http\Traits\MenuTraits;
use App\Models\ContactModel;
use App\Models\MenuModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ContactUsCT extends Controller
{
    use MenuTraits;

    private $menuName = "Config Contact";

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
        $model['data'] = ContactModel::latest()->first();
        if (isset($model['data'])) $model['data']['phone'] = substr($model['data']['phone'], 2);
        $model['base_url'] = '/admin/contactus/';
        $model['post_base_url'] = '/admin/contactus';
        return view('admin.contactus.index', compact('model'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'email' => 'required',
                'phone' => 'required',
            ]
        );

        $model = new ContactModel();
        $model->email = $request->email;
        $model->phone = '62'.$request->phone;
        $model->created_at = Carbon::now('Asia/Jakarta');
        $model->updated_at = Carbon::now('Asia/Jakarta');
        $model->save();

        Alert::success('Berhasil', 'Anda berhasil menambahkan data');
        return redirect()->to('/admin/contactus');
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'email' => 'required',
                'phone' => 'required',
            ]
        );

        $model = ContactModel::find($id);
        $model->email = $request->email;
        $model->phone = '62'.$request->phone;
        $model->updated_at = Carbon::now('Asia/Jakarta');
        $model->save();
        
        Alert::success('Berhasil', 'Anda berhasil update data');
        return redirect()->to('/admin/contactus');
    }
}
