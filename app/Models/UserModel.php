<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $table = "m_user";
    protected $primaryKey = "id";
    public $timestamps = false;

    public function getAgeAttribute() {
        return $this->tanggal_lahir->diffInYears(\Carbon\Carbon::now());
    }
}
