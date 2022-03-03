<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class KonselorModel extends Model
{
    use HasFactory;
    protected $table = "konselors";
    protected $primaryKey = "id";

    protected $fillable = ['id_user', 'id_stakeholder'];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
