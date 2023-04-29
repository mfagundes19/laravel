<?php
namespace App\Helpers;

class DataFormat 
{
    
    public static function convertDate($date, $format)
    {
        switch($format)
        {
            case 'BR':


                $DateTime = \DateTime::createFromFormat('Y-m-d', $date);
                $return = $DateTime->format('d/m/Y');
            break;
            case 'US':
                $DateTime = \DateTime::createFromFormat('d/m/Y', $date);
                $return = $DateTime->format('Y-m-d');
            break;
        }
        return $return;
    }

    public static function convertMoney($amount,$format)
    {
        switch($format)
        {
            case 'BR':
                $amount = number_format($amount,2,",",".");
                break;
            case 'US':
                $amount = str_replace(".","", $amount);
                $amount = str_replace(",",".", $amount);
                break;
        }
        return $amount;
    }


}