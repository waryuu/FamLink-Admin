<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleModel extends Model
{
    protected $table = "m_article";
    protected $primaryKey = "id";
    public $timestamps = false;
}
