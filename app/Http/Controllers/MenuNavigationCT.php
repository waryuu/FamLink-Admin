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
        $model['base_url'] = '/admin/menu/';
        $model['base_url_post'] = '/admin/menu';

        $data = MenuModel::all();
        $menu_header = MenuModel::where('parent', 0)->orderBy('sort_header', 'asc')->get();
        $menu_header_view = $menu_header;

        for ($i = 0; $i < sizeof($menu_header_view); $i++) {
            $item = $menu_header_view[$i];
            $sub_menu = MenuModel::where('parent', $item->id)->get();
            $menu_header_view[$i]['data'] = $sub_menu;
        }


        $model['menu_header_view'] = $menu_header_view;
        $model['menu_header'] = $menu_header;

        session(['menu_navigation' => $menu_header_view]);
        return view('admin.menu.index', compact('model'));
    }

    public function create()
    {
        // TODO
        return Datatables::of(MenuModel::all())->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'url' => 'required',
            'icon' => 'required',
            'menu_type' => 'required'
            ]
        );

        $model = new MenuModel();
        $model->title = $request->title;
        $model->url = $request->url;
        $model->icon = $request->icon;

        if ($request->menu_type == 'sub_header'){
            $model->parent = $request->parent_header;
        } else {
            $model->parent == 0;
        }
        $model->created_at = Carbon::now();
        $model->updated_at = Carbon::now();
        $model->save();

        Alert::success('Berhasil', 'Anda berhasil menginputkan data');
        return redirect()->to('/admin/menu');
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
            ]
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'url' => 'required',
            'icon' => 'required'
            ]
        );

        $model = MenuModel::find($id);
        $model->title = $request->title;
        $model->url = $request->url;
        $model->icon = $request->icon;
        $model->updated_at = Carbon::now();
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
            ]
        );
    }

    public function up($id){
        $model = MenuModel::findOrFail($id);

        $id = $model->sort_header;

        if ($model != null) {


            $trying = 1;
            while ($trying <= 30) {
                $id_new = $model->sort_header- $trying;

                $model_asign = MenuModel::where('sort_header', $id_new)->first();
                if ($model_asign != null && $model->parent == 0) {
                    $model->sort_header= 0;
                    $model->save();

                    $model_asign->sort_header = $id;
                    $model_asign->save();

                    $model->sort_header= $id_new;
                    $model->save();

                    Alert::success('Berhasil', 'Berhasil merubah posisi');
                    return redirect()->to('/admin/menu');
                }

                $trying++;
            }

            Alert::success('Berhasil', 'Sudah paling atas');
            return redirect()->to('/admin/menu');

        }

        Alert::success('Berhasil', 'Berhasil merubah posisi');
        return redirect()->to('/admin/menu');
    }

    public function down($id){
        $model = MenuModel::findOrFail($id);

        $id = $model->sort_header;
        if ($model != null) {


            $trying = 1;
            while ($trying <= 30) {
                $id_new = $model->sort_header + $trying;

                $model_asign = MenuModel::where('sort_header', $id_new)->first();
                if ($model_asign != null && $model->parent == 0) {
                    $model->sort_header = 0;
                    $model->save();

                    $model_asign->sort_header = $id;
                    $model_asign->save();

                    $model->sort_header = $id_new;
                    $model->save();
                    Alert::success('Berhasil', 'Berhasil merubah posisi');
                    return redirect()->to('/admin/menu');
                }

                $trying++;
            }

            Alert::success('Berhasil', 'Sudah paling bawah');
            return redirect()->to('/admin/menu');

        }
    }

    public function upSub($id){
        $model = MenuModel::findOrFail($id);

        $id = $model->sort;

        if ($model != null) {


            $trying = 1;
            while ($trying <= 30) {
                $id_new = $model->sort- $trying;

                $model_asign = MenuModel::where('sort', $id_new)->first();
                if ($model_asign != null && $model->parent == 0) {
                    $model->sort= 0;
                    $model->save();

                    $model_asign->sort = $id;
                    $model_asign->save();

                    $model->sort= $id_new;
                    $model->save();

                    Alert::success('Berhasil', 'Berhasil merubah posisi');
                    return redirect()->to('/admin/menu');
                }

                $trying++;
            }

            Alert::success('Berhasil', 'Sudah paling atas');
            return redirect()->to('/admin/menu');

        }

        Alert::success('Berhasil', 'Berhasil merubah posisi');
        return redirect()->to('/admin/menu');
    }

    public function downSub($id){
        $model = MenuModel::findOrFail($id);

        $id = $model->sort;
        if ($model != null) {


            $trying = 1;
            while ($trying <= 30) {
                $id_new = $model->sort + $trying;

                $model_asign = MenuModel::where('sort', $id_new)->first();
                if ($model_asign != null && $model->parent == 0) {
                    $model->sort = 0;
                    $model->save();

                    $model_asign->sort = $id;
                    $model_asign->save();

                    $model->sort = $id_new;
                    $model->save();
                    Alert::success('Berhasil', 'Berhasil merubah posisi');
                    return redirect()->to('/admin/menu');
                }

                $trying++;
            }

            Alert::success('Berhasil', 'Sudah paling bawah');
            return redirect()->to('/admin/menu');

        }
    }
}
