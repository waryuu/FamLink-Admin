<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrAssignmentModel extends Model
{
    protected $table = "t_assignment_master";
    protected $primaryKey = "id";
    public $timestamps = false;

    public function assignment()
    {
        return $this->hasOne(AssignmentModel::class, 'id', 'id_assignment');
    }

    public function user()
    {
        return $this->hasOne(UserModel::class, 'id', 'id_user');
    }

}
