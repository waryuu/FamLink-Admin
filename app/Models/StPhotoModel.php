<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class StPhotoModel extends Model
{
    use HasFactory;
    protected $table = "stphotos";
    protected $primaryKey = "id";

    protected $fillable = ['id_stakeholder', 'photo'];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
