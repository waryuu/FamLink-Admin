<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannerModel extends Model
{
    protected $table = "m_banner";
    protected $primaryKey = "id";
    public $timestamps = false;
}
