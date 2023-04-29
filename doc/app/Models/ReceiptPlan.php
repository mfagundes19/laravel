<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class ReceiptPlan extends Model
{
    use HasFactory;

    protected $table = ("receipt_plans");

    public function getNextRA()
    {
        $ra_number = "";
        $list = DB::select('SELECT MAX(number_ra) FROM receipt_plans WHERE id > 0 GROUP BY id ORDER BY id DESC');
        if(count($list)){
            $max =  (intval($list[0]->max)+1);
            $ra_number = str_pad($max,6,"0", STR_PAD_LEFT);
        } 
        else 
        {
            $ra_number = str_pad("1",6,"0", STR_PAD_LEFT);
        }
        return $ra_number;
    }

}
