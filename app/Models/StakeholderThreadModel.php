<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class StakeholderThreadModel extends Model
{
    use HasFactory;
    protected $table = "stakeholderthreads";
    protected $primaryKey = "id";

    protected $fillable = ['id_konselor', 'title', 'content', 'images'];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
