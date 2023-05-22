<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnswerModel extends Model
{
    protected $table = "answer";
    protected $primaryKey = "id";
    protected $fillable = ['answer','assignment_model_id', 'correctness'];
    public $timestamps = false;

    public function assignments()
    {
        return $this->belongsTo(AssignmentModel::class);
    }
}

