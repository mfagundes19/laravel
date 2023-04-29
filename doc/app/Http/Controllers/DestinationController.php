<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\Destination;
use App\Repositories\DestinationRepository;

class DestinationController extends Controller
{

    /**
     * Display a listing of the resource
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::user()->hasPermission($this->route->module, $this->route->action))
        {
            $DestinationRepository = new DestinationRepository();
            $parameters = array();
            $parameters = $request->except('_token');
            $research_parameters = $request->except('_token','refresh_route');
            $request->session()->put('research_parameters', $research_parameters);
            $parameters['parameters'] = $parameters;
            $parameters['list'] = $DestinationRepository->findBy($parameters, ['id ASC'], 20, 10);
            $parameters['route'] = $this->route;
            $View = View::make($this->getView('index'),$parameters)->render();
        }
        else
        {
            $View = View::make('errors/403',[])->render();
        }
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
        if(Auth::user()->hasPermission($this->route->module, $this->route->action))
        {
            $parameters = array();
            $parameters = $request->except('_token');
            $parameters['name'] = (isset($parameters['name'])) ? ($parameters['name']) : "";  
            $parameters['route'] = $this->route;
            $View = View::make($this->getView('create'),$parameters)->render();
        }
        else
        {
            $View = View::make('errors/403',[])->render();
        }
        return (isset($parameters['refresh_route'])) ? ($View) : view('layouts/app',array('View' => $View));
    }


    /**
     * Show the form for editing the specified resource
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Integer $destination_id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $destination_id)
    {        
        if(Auth::user()->hasPermission($this->route->module,$this->route->action))
        {
            $parameters = array();
            $parameters = $request->except('_token');
            $parameters['destination_id'] = (isset($parameters['destination_id'])) ? ($parameters['destination_id']) : $destination_id; 
            $parameters['name'] = (isset($parameters['name'])) ? ($parameters['name']) : ""; 
            $parameters['route'] = $this->route;
            if(isset($destination_id) && !empty($destination_id)) 
            {                               
                $DestinationRepository = new DestinationRepository();
                $Destination = $DestinationRepository->findById($destination_id);
                foreach($Destination->toArray() as $key => $value) 
                {
                    $parameters[$key] = (!empty($parameters[$key])) ? $parameters[$key] : $value;
                }
            }     
            $parameters['route'] = $this->route;   
            $parameters['research_parameters'] = (!empty($request->session()->get('research_parameters'))) ? $this->application->ArrayObject::toURL($request->session()->get('research_parameters')) : "";            
            $View = View::make($this->getView('edit'), $parameters)->render();
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
     * @param  \Integer $destination_id 
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $destination_id)
    {        
        if(Auth::user()->hasPermission($this->route->module, $this->route->action))
        { 
            $DestinationRepository = new DestinationRepository();
            if(isset($destination_id) && !empty($destination_id)) 
            {
                $Destination = $DestinationRepository->findById($destination_id);
                $DestinationRepository->delete($Destination);
            }
            //Response
            $parameters = array();
            $parameters['message'] = $this->getMessage(3);
            $parameters['route'] = $this->route;
            $parameters['research_parameters'] = (!empty($request->session()->get('research_parameters'))) ? $request->session()->get('research_parameters') : "";
            $View = View::make($this->getView('response'), $parameters)->render();
        }
        else
        {
            $View = View::make('errors/403',[])->render();
        }
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
                $Destination = new Destination();
                $DestinationRepository = new DestinationRepository();
                $Destination->name = (!empty($name)) ? $name : "";
                $Destination = $DestinationRepository->save($Destination);
                //Response
                $parameters = array();
                $parameters['message'] = $this->getMessage($procedure);
                $parameters['route'] = $this->route;
                $parameters['research_parameters'] = null;
                $View = View::make($this->getView('response'), $parameters)->render();
            break;
            case '2':   //Edit
                $Destination = new Destination();
                $DestinationRepository = new DestinationRepository();
                $Destination = $DestinationRepository->findById($destination_id);
                $Destination->name = (!empty($name)) ? $name : "";
                $Destination = $DestinationRepository->save($Destination);
                //Response
                $parameters = array();
                $parameters['message'] = $this->getMessage($procedure);
                $parameters['route'] = $this->route;
                $parameters['research_parameters'] = (!empty($request->session()->get('research_parameters'))) ? $request->session()->get('research_parameters') : "";
                $View = View::make($this->getView('response'), $parameters)->render();
            break;
        }
        return view('layouts/app',array('View' => $View));
    }
}
