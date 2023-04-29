<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Segregator extends Model
{
    use HasFactory;
    protected $table = ("segregator");
    protected $fillable = ['name'];
}
