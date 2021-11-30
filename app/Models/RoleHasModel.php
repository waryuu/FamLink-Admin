<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleHasModel extends Model
{
    protected $primaryKey = "id";
    protected $table = 'm_has_role';
    public $timestamps = false;

}
