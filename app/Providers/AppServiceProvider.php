<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultstringLength(191);
        \Carbon\Carbon::setLocale('pt_BR');
        
        Str::macro('currency', function ($price,$format)
        {
            switch($format)
            {
                case 'us':
                    $price = str_replace(".","", $price);
                    $price = str_replace(",",".", $price);
                    break;
                case 'br':
                    //$price = str_replace(".",",", $price);
                    $price = number_format($price, 2, ',', '.');
                    break;
                    
            }
            return $price;
        });

        Str::macro('toURL', function ($array) {
            $string = null;
            if(is_array($array) && count($array) > 0) {
                foreach($array as $key => $value) {
                    $string.= $key."=".$value."&";
                }
            }
            return $string;
        });

        Str::macro('debug', function ($array) {
            echo "<div style='display: block; border: 1px solid; text-align: left; background-color: white'><pre>";
            print_r($array);
            echo "</pre></div>";
        });

    }
}
