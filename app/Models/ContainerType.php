<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContainerType extends Model
{
    use HasFactory;
    protected $table = ("container_type");
    protected $fillable = ['name'];
}
