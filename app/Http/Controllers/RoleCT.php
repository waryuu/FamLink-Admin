<?php

namespace App\Http\Controllers;

use App\Models\MenuModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;

class MenuNavigationCT extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function create()
    {
        // TODO
        return Datatables::of(MenuModel::all())->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:m_pekerjaan|max:255'
        ]);

        $model = new MenuModel();
        $model->name = $request->name;
        $model->created_at = Carbon::now();
        $model->save();

        Alert::success('Berhasil', 'Anda berhasil menginputkan data');
        return redirect()->to('/menu');
    }

    public function show($id)
    {
        // TODO
    }

    public function edit($id)
    {
        $model = MenuModel::find($id);

	    return response()->json([
	      'data' => $model
	    ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255'
        ]);

        $model = MenuModel::find($id);
        $model->name = $request->name;
        $model->save();

        return response()->json([ 'success' => true ]);
    }

    public function destroy($id)
    {
        MenuModel::find($id)->delete();

        return response()->json([
            'state' => true,
            'data' => null,
            'message' => 'Anda berhasil menghapus data!'
        ]);
    }
}
