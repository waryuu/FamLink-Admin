<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAdminModel extends Model
{
    protected $primaryKey = "id";
    protected $table = 'm_staff';
    public $timestamps = false;

}
