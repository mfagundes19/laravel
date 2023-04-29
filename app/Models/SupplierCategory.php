<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierCategory extends Model
{
    use HasFactory;
    protected $table = ("supplier_category");
    protected $fillable = ['name'];
}
