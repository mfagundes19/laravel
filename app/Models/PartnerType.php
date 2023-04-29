<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerType extends Model
{
    use HasFactory;
    protected $table = ("partner_type");
    protected $fillable = ['name'];
}
