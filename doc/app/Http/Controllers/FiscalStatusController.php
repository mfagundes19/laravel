<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\FiscalStatus;
use App\Repositories\FiscalStatusRepository;

class FiscalStatusController extends Controller
{
    /**
     * Display a listing of the resource
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $FiscalStatusRepository = new FiscalStatusRepository();
        $parameters = array();
        $parameters = $request->except('_token');
        $parameters['parameters'] = $parameters;
        $research_parameters = $request->except('_token','refresh_route');
        $request->session()->put('research_parameters', $research_parameters);
        $parameters['list'] = $FiscalStatusRepository->findBy($parameters, ['id ASC'], 20, 10);
        $parameters['route'] = $this->route;
        $View = View::make($this->getView(),$parameters)->render();
        return (isset($parameters['refresh_route'])) ? ($View) : view('layouts/app',array('View' => $View));
    }

    /**
     * Show the form for creating a new resource
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {           
        $parameters = array();
        $parameters = $request->except('_token');
        $parameters['name'] = (isset($parameters['name'])) ? ($parameters['name']) : "";  
        $parameters['route'] = $this->route;
        $View = View::make($this->getView(),$parameters)->render();
        return (isset($parameters['refresh_route'])) ? ($View) : view('layouts/app',array('View' => $View));
    }


    /**
     * Show the form for editing the specified resource
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Integer $fiscal_status_id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $fiscal_status_id)
    {        
        if(Auth::user()->hasPermission($this->route->module,$this->route->action))
        {
            $parameters = array();
            $parameters = $request->except('_token');
            $parameters['fiscal_status_id'] = (isset($parameters['fiscal_status_id'])) ? ($parameters['fiscal_status_id']) : $fiscal_status_id; 
            $parameters['name'] = (isset($parameters['name'])) ? ($parameters['name']) : ""; 
            $parameters['route'] = $this->route;
            if(!empty($fiscal_status_id)) 
            {                                                               
                $FiscalStatusRepository = new FiscalStatusRepository();
                $FiscalStatus = $FiscalStatusRepository->findById($fiscal_status_id);
                foreach($FiscalStatus->toArray() as $key => $value) 
                {
                    $parameters[$key] = (!empty($parameters[$key])) ? $parameters[$key] : $value;
                }
            }     
            $parameters['route'] = $this->route;               
            $parameters['research_parameters'] = (!empty($request->session()->get('research_parameters'))) ? \Str::toURL($request->session()->get('research_parameters')) : "";
            $View = View::make($this->getView(), $parameters)->render();
        }
        else
        {
            $View = View::make('errors/403',[])->render();
        }
        return (isset($parameters['refresh_route'])) ? ($View) : view('layouts/app',array('View' => $View));
    }

    /**
     * Remove\delete resource of storage
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Integer $fiscal_status_id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $fiscal_status_id)
    {        
        $FiscalStatusRepository = new FiscalStatusRepository();
        if(!empty($fiscal_status_id)) 
        {
            $FiscalStatus = $FiscalStatusRepository->findById($fiscal_status_id);
            $FiscalStatusRepository->delete($FiscalStatus);
        }
        //Response
        $parameters = array();
        $parameters['message'] = $this->getMessage(3);
        $parameters['route'] = $this->route;
        $parameters['research_parameters'] = (!empty($request->session()->get('research_parameters'))) ? \Str::toURL($request->session()->get('research_parameters')) : "";
        $View = View::make($this->getView('response'), $parameters)->render();
        return view('layouts/app',array('View' => $View));
    }

    
    /**
     * Save a resource in storage
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        $parameters = array();
        $post_data = $request->except('_token');
        foreach($post_data as $key => $value)
        {
            $$key = $value;
        }
        switch($procedure)
        {
            case '1':   //Create
                $FiscalStatus = new FiscalStatus();
                $FiscalStatusRepository = new FiscalStatusRepository();
                $FiscalStatus->name = (!empty($name)) ? $name : "";
                $FiscalStatus = $FiscalStatusRepository->save($FiscalStatus);
                //Response
                $parameters = array();
                $parameters['message'] = $this->getMessage($procedure);
                $parameters['route'] = $this->route;
                $parameters['research_parameters'] = null;
                $View = View::make($this->getView('response'), $parameters)->render();
            break;
            case '2':   //Edit
                $FiscalStatus = new FiscalStatus();
                $FiscalStatusRepository = new FiscalStatusRepository();
                $FiscalStatus = $FiscalStatusRepository->findById($fiscal_status_id);
                $FiscalStatus->name = (!empty($name)) ? $name : "";
                $FiscalStatus = $FiscalStatusRepository->save($FiscalStatus);
                //Response
                $parameters = array();
                $parameters['message'] = $this->getMessage($procedure);
                $parameters['route'] = $this->route;
                $parameters['research_parameters'] = (!empty($request->session()->get('research_parameters'))) ? \Str::toURL($request->session()->get('research_parameters')) : "";
                $View = View::make($this->getView('response'), $parameters)->render();
            break;
        }
        return view('layouts/app',array('View' => $View));
    }
}
