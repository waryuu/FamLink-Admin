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

    public function assignments()
    {
        return $this->hasMany(AssignmentModel::class, 'id', 'id_category');
    }
}
