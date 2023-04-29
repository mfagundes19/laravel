<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\Module;
use App\Repositories\ModuleRepository;

class ModuleController extends Controller
{
    
    /**
     * Display a listing of the resource
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(request $request)
    {
        if(Auth::user()->hasPermission($this->route->module,$this->route->action))
        {
            $ModuleRepository = new ModuleRepository();
            $parameters = array();
            $parameters = $request->except('_token');
            $research_parameters = $request->except('_token','refresh_route');
            $request->session()->put('research_parameters', $research_parameters);
            $parameters['research_parameters'] = $research_parameters;
            $parameters['parameters'] = $parameters;
            $parameters['list'] = $ModuleRepository->findBy($parameters, ['id ASC'], 10, 10);
            $parameters['route'] = $this->route;
            $View = View::make($this->getView(), $parameters)->render();
        }
        else
        {
            $View = View::make('errors/403',[])->render();
        }
        return view('layouts/app',array('View' => $View));
    }


    /**
     * Show the form for creating a new resource
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(request $request)
    {
        if(Auth::user()->hasPermission($this->route->module, $this->route->action))
        {
            $parameters = array();
            $parameters = $request->except('_token');
            $parameters['module_id'] = (isset($parameters['module_id'])) ? ($parameters['module_id']) : ""; 
            $parameters['name'] = (isset($parameters['name'])) ? ($parameters['name']) : ""; 
            $parameters['link'] = (isset($parameters['link'])) ? ($parameters['link']) : ""; 
            $parameters['route'] = $this->route;
            if(isset($parameters['module_id']) && !empty($parameters['module_id']))
            {
                $ModuleRepository = new ModuleRepository();
                $Module = $ModuleRepository->find($parameters['module_id']);
                if(!empty($Module))
                {
                    $parameters['name'] = $Module->name;
                    $parameters['link'] = $Module->module;
                }
            }
            $View = View::make($this->getView(), $parameters)->render();
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
     * @param  \Integer $module_id
     * @return \Illuminate\Http\Response
     */
    public function edit(request $request, $module_id)
    {
        if(Auth::user()->hasPermission($this->route->module, $this->route->action))
        {
            $parameters = array();
            $parameters = $request->except('_token');
            $parameters['module_id'] = (isset($parameters['module_id'])) ? ($parameters['module_id']) : $module_id; 
            $parameters['name'] = (isset($parameters['name'])) ? ($parameters['name']) : ""; 
            $parameters['link'] = (isset($parameters['link'])) ? ($parameters['link']) : "";  
            if(isset($parameters['module_id']) && !empty($parameters['module_id'])) 
            {                            
                $ModuleRepository = new ModuleRepository();
                $Module = $ModuleRepository->findById($module_id);
                foreach($Module->toArray() as $key => $value) 
                {
                    $parameters[$key] = (!empty($parameters[$key])) ? $parameters[$key] : $value;
                }
            }            
            $parameters['research_parameters'] = (!empty($request->session()->get('research_parameters'))) ? \Str::toURL($request->session()->get('research_parameters')) : "";
            $parameters['route'] = $this->route;
            $View = View::make($this->getView(), $parameters)->render();
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
     * @param  \Integer $module_id
     * @return \Illuminate\Http\Response
     */
    public function delete(request $request, $module_id)
    {
        if(Auth::user()->hasPermission($this->route->module, $this->route->action)) {
            if(isset($module_id) && !empty($module_id)) {
                $ModuleRepository = new ModuleRepository();
                $Module = $ModuleRepository->findById($module_id);
                $Module->active = false;
                $ModuleRepository->save($Module);
            }
            $parameters = array();
            $parameters['message'] = $this->getMessage('deleted');
            $parameters['research_parameters'] = (!empty($request->session()->get('research_parameters'))) ? \Str::toURL($request->session()->get('research_parameters')) : "";
            $parameters['route'] = $this->route;
            $View = View::make($this->getView('response'), $parameters)->render();
        } else {
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
        foreach($post_data as $key => $value) {
            $$key = $value;
        }   
        switch($procedure)
        {
            case 'create':
                $ModuleRepository = new ModuleRepository();
                $Module = new Module();
                $Module->name = (!empty($name)) ? $name : "";
                $Module->module = (!empty($module)) ? $module : "";
                $ModuleRepository->save($Module);
                //Response
                $parameters = array();
                $parameters['message'] = $this->getMessage('created');
                $parameters['route'] = $this->route;
                $parameters['research_parameters'] = null;
                $View = View::make($this->getView('response'), $parameters)->render();            
                break;
            case 'edit':
                $ModuleRepository = new ModuleRepository();
                $Module = new Module();
                $Module = $ModuleRepository->findById($module_id);
                $Module->id = (!empty($module_id)) ? $module_id : null;
                $Module->name = (!empty($name)) ? $name : "";
                $Module->module = (!empty($module)) ? $module : "";
                $ModuleRepository->save($Module);
                //Response
                $parameters = array();
                $parameters['message'] = $this->getMessage('edited');
                $parameters['route'] = $this->route;
                $parameters['research_parameters'] = (!empty($request->session()->get('research_parameters'))) ? \Str::toURL($request->session()->get('research_parameters')) : "";
                $View = View::make($this->getView('response'), $parameters)->render();     
                break;
        }
        return view('layouts/app',array('View' => $View));
    }

}//end class
