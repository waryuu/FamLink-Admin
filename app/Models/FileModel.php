<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class FileModel extends Model
{
    use HasFactory;
    protected $table = "files";
    protected $primaryKey = "id";

    protected $fillable = ['id_materials', 'title', 'file', 'status'];
    protected $hidden = ['id_materials', 'created_at', 'updated_at'];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
