<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignmentModel extends Model
{
    protected $table = "assignment";
    protected $primaryKey = "id";
    public $incrementing = false;
    public $timestamps = false; 

    public function category()
    {
        return $this->hasOne(AssignmentCategoryModel::class, 'id', 'id_category');
    }
}

    
