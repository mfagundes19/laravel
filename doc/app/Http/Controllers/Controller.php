<?php

namespace App\Http\Controllers;

/*
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
*/

use App\Application;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $application;
    protected $route;
    protected $formData;

    public function __construct(Request $request)
    {
        $this->application = new Application();
        $this->init();
    }

    /**
     * Initialize Application
     *
     * @return void
     */
    public function init()
    {        
        if(!empty(\Route::getCurrentRoute()->getName())) {
            $arrRoute = explode("/", \Route::getCurrentRoute()->getName());
            $module = (isset($arrRoute[0])) ? $arrRoute[0] : "";
            $action = (isset($arrRoute[1])) ? $arrRoute[1] : "index";
            $this->route = ['name' => '','module' => $module,'action' => $action];
            foreach(\App\Models\Module::where([['module','ILIKE', $module]])->get() as $key => $value) {
                $this->route = array('name' => $value['name'],'module' => $module,'action' => $action);          
            }   
            $this->route = (object)($this->route);
        }
    }

    /**
     * Return path of view
     *
     * @param  \String     $view
     * @return \String     $path
     */
    public function getView($view = null)
    {
        return (!empty($view)) ?  ($this->route->module.'/'.$view) : ($this->route->module.'/'.$this->route->action);
    }

    /**
     * Returns an operation return message
     *
     * @param  \Integer     $procedure
     * @return \String      $message
     */
    public function getMessage($procedure = 'created', $message = null)
    {
        if(empty($message)) 
        {
            switch($procedure)
            {
                case 'created':   //Create
                    $message = "Cadastro realizado com sucesso!";
                    break;
                case 'edited':   //Edit
                    $message = "Cadastro alterado com sucesso!";
                    break;
                case 'deleted':   //Delete
                    $message = "Cadastro excluído com sucesso!";
                    break;      
                case 'not_found':
                    $message = "Cadastro não encontrado!";
                    break;
            }
        }
        return $message;
    }

    public function getStates()
    {
        $this->application = new Application();
        $parameters['STATES'] = $this->application->getStates('sigla','nome');
        $State = new \App\Models\State();
        $list = $State->select('*')->from('states')->get();
        $total = 0;
        if(count($list) > 0)
        {
            foreach($list as $element)
            {
                $stateId = $this->application->getStateId('sigla', $element->uf);
                $parameters['CITIES'] = null;
                $parameters['CITIES'] = $this->application->getCitiesState($stateId,'nome');
                foreach($parameters['CITIES'] as $key => $value)
                {
                    $City = new \App\Models\City();
                    $City->uf = $element->uf;
                    $City->name = $value;
                    $City->save();
                }
            }
        }
        else
        {
            foreach($parameters['STATES'] as $key => $value)
            {
                $State = new \App\Models\State();
                $State->uf = $key;
                $State->name = $value;
                $State->save();
            }
        }
    }

}
