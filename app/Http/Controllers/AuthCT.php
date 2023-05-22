<?php

namespace App\Http\Controllers;

use App\Models\MenuModel;
use App\Models\RoleModel;
use App\Models\UserAdminModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthCT extends Controller
{
    public function loginView()
    {
        $attributes = [
            'data-theme' => 'dark',
            'data-type' => 'audio',
        ];
        $model['attributes'] = $attributes;
        return view('login', compact('model'));
    }

    public function login(Request $request){
        // $validator = Validator::make($request->all(),
        //     ['g-recaptcha-response' => 'required|captcha']
        // );

        // if ($validator->fails()){
        //     Alert::warning('Login Gagal', 'Harap isi capcha!');
        //     return redirect("/login")->with('error','Harap isi capcha!.');
        // }

        if(Auth::attempt(['username' => $request->username, 'password' => $request->password])){
            Alert::success('Sukses login', 'Login Berhasil, Selamat Datang.');
            return redirect('/admin/auth');
        }else{
            Alert::warning('Login Gagal', 'Login tidak berhasil, harap periksa username dan password anda');
            return redirect("/login")->with('error','Username And Password Are Wrong.');
        }
    }

    public function logout(){
        Auth::logout();
        Alert::success('Sukses Logout', 'Logout Berhasil, Sampai Jumpa !');
        return redirect('/login');
    }

    public static function menuNavigation(){
        $user = Auth::user();

        $menu_header = MenuModel::where('parent', 0)->join('m_has_role', 'm_menu.id', '=', 'id_menu')
            ->select('m_menu.*')->where('id_role', $user->role)->orderBy('sort_header', 'asc')->get();
        $menu_header_view = $menu_header;

        for ($i = 0; $i < sizeof($menu_header_view); $i++) {
            $item = $menu_header_view[$i];
            $sub_menu = MenuModel::join('m_has_role', 'm_menu.id', '=', 'id_menu')
                ->where('id_role', $user->role)->where('parent', $item->id)->get();
            $menu_header_view[$i]['data'] = $sub_menu;
        }

        $model['navigation'] = $menu_header_view;
        $model['role'] = RoleModel::find($user->role);
        return $model;
    }

    public function index(){
        return view('admin.auth.index');
    }

    public function show($id)
    {
        $model['base_url'] = '/admin/auth/';
        $model['data'] = Auth::user();
        return view('admin.auth.show', compact('model'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            ]);

            $model = UserAdminModel::find($id);
            $model->name = $request->name;
            $model->email = $request->email;
            if (isset($request->password)) {
                $model->password = bcrypt($request->password);
            }
            $model->updated_at = Carbon::now();
            $model->save();


            return response()->json([ 'success' => true ]);
        }
    }
