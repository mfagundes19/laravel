<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FiscalStatus extends Model
{
    use HasFactory;
    protected $table = ("fiscal_status");
    protected $fillable = ['name'];
}
