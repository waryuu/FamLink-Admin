<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrAssessmentModel extends Model
{
    protected $table = "t_assessment_master";
    protected $primaryKey = "id";
    public $timestamps = false;

    public function assessment()
    {
        return $this->hasOne(AssessmentModel::class, 'id', 'id_assessment');
    }

    public function user()
    {
        return $this->hasOne(UserModel::class, 'id', 'id_user');
    }

    public function assessment_result()
    {
        return $this->hasOne(AssessmentResultModel::class, 'id', 'id_result');
    }

}
