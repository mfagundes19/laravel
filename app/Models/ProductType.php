<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{    
    use HasFactory;
    protected $table = ("product_type");
    protected $fillable = ['name'];

    /**
     * Reference for User 
     *
     * @return Model
     */
    public function category()
    {
        return $this->belongsTo('App\Models\ProductCategory', 'foreign_key');
    }
}
