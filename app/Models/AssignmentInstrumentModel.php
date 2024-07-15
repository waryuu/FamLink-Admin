<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignmentInstrumentModel extends Model
{
    protected $table = "assignment_instrument";
    protected $primaryKey = "id";
    public $incrementing = false;
    public $timestamps = false; 

    public function category()
    {
        return $this->hasOne(AssignmentModel::class, 'id', 'id_assignment');
    }
}

    
