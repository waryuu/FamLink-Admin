<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RulesModel extends Model
{
    use HasFactory;
    protected $table = "rules";
    protected $primaryKey = "id";

    protected $fillable = ['id_menu', 'rule'];
}
