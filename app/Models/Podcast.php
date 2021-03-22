<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Podcast extends Model
{
    protected $fillable = ['filename', 'people', 'description'];
    use HasFactory;
}
