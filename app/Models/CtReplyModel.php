<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class CtReplyModel extends Model
{
    use HasFactory;
    protected $table = "ctreplies";
    protected $primaryKey = "id";

    protected $fillable = ['id_cthread', 'id_konselor', 'content'];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
