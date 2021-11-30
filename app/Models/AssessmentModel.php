<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentModel extends Model
{
    protected $table = "m_assessment";
    protected $primaryKey = "id";
    public $timestamps = false;
}
