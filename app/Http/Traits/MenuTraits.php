<?php

namespace App\Http\Traits;

use App\Models\RoleHasModel;
use RealRashid\SweetAlert\Facades\Alert;

/**
 * 
 */
trait MenuTraits
{
    public static function hasAccess($roleID, $menuID)
    {
        $hasRole = RoleHasModel::where('id_role', $roleID)->where('id_menu', $menuID)->get();
        if(count($hasRole)) return true; 
        else {
            redirect('/admin/auth')->send();
            Alert::error('Gagal', 'Anda tidak memiliki akses');
        }
    }
}
