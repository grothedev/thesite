<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Podcast extends Model
{
    protected $fillable = ['filename', 'people', 'description'];
}
