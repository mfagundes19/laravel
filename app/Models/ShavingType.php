<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShavingType extends Model
{
    use HasFactory;
    protected $table = ("shaving_type");
    protected $fillable = ['name'];
}
