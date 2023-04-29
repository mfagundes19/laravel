<?php
namespace App;

use App\Helpers\ArrayObject;
use App\Helpers\DateFormat;
use Illuminate\Http\Request;

class Application 
{
    
    public $ArrayObject = null;

    public function __construct()
    {
        $this->ArrayObject = new ArrayObject();
        return;        
    }

    public function getStates($value = 'sigla', $name = 'sigla')
    {        
        if(empty($this->states))
        {
            $cookie = @tempnam ("/tmp", "CURLCOOKIE");
            $ch = curl_init();
            curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
            curl_setopt( $ch, CURLOPT_URL, 'https://servicodados.ibge.gov.br/api/v1/localidades/estados');
            curl_setopt( $ch, CURLOPT_COOKIEJAR, $cookie );
            curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
            curl_setopt( $ch, CURLOPT_ENCODING, "" );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
            curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 99999 );
            curl_setopt( $ch, CURLOPT_TIMEOUT, 99999 );
            curl_setopt( $ch, CURLOPT_MAXREDIRS, 10 );
            $content = curl_exec( $ch );
            //$response = curl_getinfo( $ch );
            curl_close ( $ch );
            $this->states = json_decode($content,true);
        }
        
        $States = array();
        foreach($this->states as $state) 
        {
            $States[$state[$value]] = $state[$name];
        }
        return $States;
    }

    public function getCities($value = 'nome', $name = 'nome')
    {        
        if(empty($this->cities))
        {
            $cookie = @tempnam ("/tmp", "CURLCOOKIE");
            $ch = curl_init();
            curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
            curl_setopt( $ch, CURLOPT_URL, 'http://servicodados.ibge.gov.br/api/v1/localidades/municipios');
            curl_setopt( $ch, CURLOPT_COOKIEJAR, $cookie );
            curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
            curl_setopt( $ch, CURLOPT_ENCODING, "" );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
            curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 99999 );
            curl_setopt( $ch, CURLOPT_TIMEOUT, 99999 );
            curl_setopt( $ch, CURLOPT_MAXREDIRS, 10 );
            $content = curl_exec( $ch );
            //$response = curl_getinfo( $ch );
            curl_close ( $ch );
            $this->cities = json_decode($content,true);
        }
        
        $Cities = array();
        foreach($this->cities as $city) 
        {
            $Cities[$city[$value]] = $city[$name];
        }
        return $Cities;
    }

    public function getStateId($field, $value)
    {
        foreach($this->states as $state) 
        {
            if($state[$field] == $value)
            {
                return $state['id'];
            }
        }   
        return null;
    }

    public function getCitiesState($state_id,$name)
    {
        if(empty($this->cities))
        {
            $cookie = @tempnam ("/tmp", "CURLCOOKIE");
            $ch = curl_init();
            curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
            curl_setopt( $ch, CURLOPT_URL, 'http://servicodados.ibge.gov.br/api/v1/localidades/estados/'.$state_id.'/municipios');
            curl_setopt( $ch, CURLOPT_COOKIEJAR, $cookie );
            curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
            curl_setopt( $ch, CURLOPT_ENCODING, "" );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
            curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 99999 );
            curl_setopt( $ch, CURLOPT_TIMEOUT, 99999 );
            curl_setopt( $ch, CURLOPT_MAXREDIRS, 10 );
            $content = curl_exec( $ch );
            curl_close ( $ch );
            $this->cities = json_decode($content, true);
        }
        $Cities = array();
        foreach($this->cities as $city) 
        {
            $Cities[$city[$name]] = $city[$name];
        }
        $this->cities = null;
        return $Cities;
    }

    


}