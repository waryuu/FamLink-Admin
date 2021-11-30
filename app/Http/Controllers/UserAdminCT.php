<?php

namespace App\Http\Controllers;

use App\Models\RoleModel;
use App\Models\UserAdminModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;

class UserAdminCT extends Controller
{
    public function index()
    {
        $model['role'] = RoleModel::all();
        $model['base_url'] = '/admin/useradmin/';
        return view('admin.useradmin.index', compact('model'));
    }

    public function create()
    {
        // TODO
        return Datatables::of(UserAdminModel::all())->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:m_staff|max:255',
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required',
            'password' => 'required'
        ]);

        $model = new UserAdminModel();
        $model->username = $request->username;
        $model->name = $request->name;
        $model->email = $request->email;
        $model->password = bcrypt($request->password);
        $model->role = $request->role;
        $model->created_at = Carbon::now();
        $model->save();

        Alert::success('Berhasil', 'Anda berhasil menginputkan data');
        return redirect()->to('/admin/useradmin');
    }

    public function show($id)
    {
        // TODO
    }

    public function edit($id)
    {
        $model = UserAdminModel::find($id);
        $role = RoleModel::find($model->role);

	    return response()->json([
          'data' => $model,
          'role' => $role
	    ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required',
        ]);

        $model = UserAdminModel::find($id);
        $model->username = $request->username;
        $model->name = $request->name;
        $model->email = $request->email;
        if (isset($request->password)) {
            $model->password = bcrypt($request->password);
        }
        $model->role = $request->role;
        $model->updated_at = Carbon::now();
        $model->save();

        return response()->json([ 'success' => true ]);
    }

    public function destroy($id)
    {
        UserAdminModel::find($id)->delete();

        return response()->json([
            'state' => true,
            'data' => null,
            'message' => 'Anda berhasil menghapus data!'
        ]);
    }
}
