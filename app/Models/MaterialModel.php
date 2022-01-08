<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialModel extends Model
{
    use HasFactory;
    
    protected $table = "materials";
    protected $primaryKey = "id";

    protected $fillable = ['id_staff', 'id_category', 'title', 'type', 'description', 'image', 'link_yt', 'is_locked', 'download_pass', 'status'];

    protected $hidden = [
        'download_pass',
    ];
}
