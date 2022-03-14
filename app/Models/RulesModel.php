<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RulesModel extends Model
{
    use HasFactory;
    protected $table = "rules";
    protected $primaryKey = "id";

    protected $fillable = ['id_menu', 'rule'];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
