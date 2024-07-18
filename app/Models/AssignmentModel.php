<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentModel extends Model
{
    use HasFactory;

    protected $table = "assignment";
    protected $primaryKey = "id";

    protected $fillable = ['name', 'status'];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function assignments()
    {
        return $this->hasMany(AssignmentInstrumentModel::class, 'id', 'id_assignment');
    }
}
