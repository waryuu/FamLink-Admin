<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventModel extends Model
{
    use HasFactory;

    protected $table = "events";
    protected $primaryKey = "id";

    protected $fillable = ['id_staff', 'title', 'price', 'organizer', 'time', 'location', 'description', 'registlink', 'status'];
}
