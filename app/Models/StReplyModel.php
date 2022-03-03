<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class StReplyModel extends Model
{
    use HasFactory;
    protected $table = "streplies";
    protected $primaryKey = "id";

    protected $fillable = ['id_sthread', 'id_konselor', 'content', 'images'];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
