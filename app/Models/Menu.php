<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table =  "menu";
    protected $fillable = ['module_id','nivel_1_menu_id','nivel_2_menu_id','name', 'link', 'nivel'];
    protected static $logName = "Menu";
    protected static $logAttributes = ['name', 'text'];
}
