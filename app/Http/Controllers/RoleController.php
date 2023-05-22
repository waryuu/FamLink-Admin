<?php

namespace App\Http\Controllers;

use App\Http\Traits\MenuTraits;
use App\Models\MenuModel;
use App\Models\RoleHasModel;
use App\Models\RoleModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    use MenuTraits;

    private $menuName = "Config Role";

    function __construct() {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            $this->menu = MenuModel::where('title', $this->menuName)->select('id')->first();
            if ($this->hasAccess($this->user->role, $this->menu->id)) {
                return $next($request);
            }
        });
    }

    public function index()
    {
        $model['base_url'] = '/admin/role/';
        $model['post_base_url'] = '/admin/role';
        return view('admin.role.index', compact('model'));
    }

    public function create()
    {
        // TODO
        return Datatables::of(RoleModel::all())->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:m_role|max:255'
            ]
        );

        $model = new RoleModel();
        $model->name = $request->name;
        $model->created_at = Carbon::now();
        $model->save();

        Alert::success('Berhasil', 'Anda berhasil menginputkan data');
        return redirect()->to('/admin/role');
    }

    public function show($id)
    {
        $model['base_url'] = '/admin/role/';

        $detail = RoleModel::find($id);
        $menu_header = MenuModel::where('parent', 0)->orderBy('sort_header', 'asc')->get();
        $data = MenuModel::all();

        $menu_header_view = $menu_header;

        for ($i = 0; $i < sizeof($menu_header_view); $i++) {
            $item = $menu_header_view[$i];
            $sub_menu = MenuModel::where('parent', $item->id)->get();
            $menu_header_view[$i]['data'] = $sub_menu;
        }


        $model['menu_header_view'] = $menu_header_view;
        $model['menu_header'] = $menu_header;
        $model['menu_has_role'] = RoleHasModel::where('id_role', $detail->id)->get();
        $model['detail'] = $detail;

        return view('admin.role.has_role', compact('model'));
    }

    public function edit($id)
    {
        $model = RoleModel::find($id);

        return response()->json([
            'data' => $model
            ]
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255'
            ]
        );

        $model = RoleModel::find($id);
        $model->name = $request->name;
        $model->save();

        return response()->json([ 'success' => true ]);
    }

    public function destroy($id)
    {
        RoleModel::find($id)->delete();

        return response()->json([
            'state' => true,
            'data' => null,
            'message' => 'Anda berhasil menghapus data!'
            ]
        );
    }

    public function saveHasRole(Request $request)
    {
        $menu = $request->menu;

        if (isset($menu) && count($menu) > 0) {
            RoleHasModel::where('id_role', $request->id_role)->delete();
            foreach ($menu as $item) {
                $has_role = new RoleHasModel();
                $has_role->id_role = $request->id_role;
                $has_role->id_menu = $item;
                $has_role->save();
            }
        }

        Alert::success('Berhasil', 'Anda berhasil mengupdate menu');
        return redirect()->to('/admin/role');
    }
}
