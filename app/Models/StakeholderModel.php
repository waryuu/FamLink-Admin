<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class StakeholderModel extends Model
{
    use HasFactory;
    protected $table = "stakeholders";
    protected $primaryKey = "id";

    protected $fillable = ['name', 'established', 'focus', 'email', 'id_province', 'id_regency', 'logo'];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
