<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class StakeholderMemberModel extends Model
{
    use HasFactory;
    protected $table = "stakeholdermembers";
    protected $primaryKey = "id";

    protected $fillable = ['id_user', 'id_stakeholder', 'position'];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
