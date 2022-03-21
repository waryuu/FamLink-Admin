<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class ConsultationThreadModel extends Model
{
    use HasFactory;
    protected $table = "consultationthreads";
    protected $primaryKey = "id";

    protected $fillable = ['id_user', 'id_konselor', 'type', 'title', 'content', 'state', 'status', 'closed_by', 'role_who_closed', 'closed_at', 'rating'];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
