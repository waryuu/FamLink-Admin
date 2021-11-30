<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentInstrumentModel extends Model
{
    protected $table = "m_assessment_instrument";
    protected $primaryKey = "id";
    public $timestamps = false;

    public function detail()
    {
        return $this->hasOne(AssessmentDetailModel::class, 'id', 'id_assessment_detail');

    }

}
