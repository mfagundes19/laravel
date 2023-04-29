<?php
namespace App\Helpers;

class ArrayObject 
{

    public static function empty($array)
    {
        $empty = true;
        if(is_array($array) && (count($array) > 0))
        {
            foreach($array as $key => $value)
            {
                if(!empty($value))
                {
                    $empty = false;
                }
            }
        }
        return $empty;
    } 

    public static function toURL($array)
    {
        $string = null;
        if(!ArrayObject::empty($array))
        {
            foreach($array as $key => $value)
            {
                $string.= $key."=".$value."&";
            }
        }
        return $string;
    }
}