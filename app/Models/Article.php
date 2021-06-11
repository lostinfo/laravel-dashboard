<?php

namespace App\Models;


use App\Support\SerializeDateTrait;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use SerializeDateTrait;

    protected $fillable = [
        'title', 'markdown', 'content',
    ];
}
