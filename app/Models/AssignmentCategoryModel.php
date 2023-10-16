<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentCategoryModel extends Model
{
    use HasFactory;

    protected $table = "assignment_categorys";
    protected $primaryKey = "id";

    protected $fillable = ['name', 'status'];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
