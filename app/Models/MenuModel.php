<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuModel extends Model
{
    protected $primaryKey = "id";
    protected $table = 'm_menu';
    public $timestamps = false;

    public function menu()
    {
        return $this->hasOne(RoleHasModel::class, 'id_role', 'id');
    }
}
