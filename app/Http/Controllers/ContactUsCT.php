<?php

namespace App\Http\Controllers;

use App\Http\Traits\MenuTraits;
use App\Models\ContactModel;
use App\Models\MenuModel;
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
        $model['data']['phone'] = substr($model['data']['phone'], 2);
        $model['base_url'] = '/admin/contactus/';
        return view('admin.contactus.index', compact('model'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'email' => 'required',
                'phone' => 'required',
            ]
        );

        // return $request;

        $model = ContactModel::find($id);
        $model->email = $request->email;
        $model->phone = '62'.$request->phone;

        $model->save();
        Alert::success('Berhasil', 'Anda berhasil update data');
        return redirect()->to('/admin/contactus');
    }
}
