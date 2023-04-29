<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\Density;
use App\Repositories\DensityRepository;

class DensityController extends Controller
{
    /**
     * Display a listing of the resource
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $DensityRepository = new DensityRepository();
        $parameters = array();
        $parameters = $request->except('_token');
        $research_parameters = $request->except('_token','refresh_route');
        $request->session()->put('research_parameters', $research_parameters);
        $parameters['parameters'] = $parameters;
        $parameters['list'] = $DensityRepository->findBy($parameters, ['id ASC'], 20, 10);
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
     * @param  \Integer $density_id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $density_id)
    {        
        if(Auth::user()->hasPermission($this->route->module,$this->route->action))
        {
            $parameters = array();
            $parameters = $request->except('_token');
            $parameters['density_id'] = (isset($parameters['density_id'])) ? ($parameters['density_id']) : $density_id; 
            $parameters['name'] = (isset($parameters['name'])) ? ($parameters['name']) : ""; 
            $parameters['route'] = $this->route;
            if(isset($density_id) && !empty($density_id)) 
            {                                               
                $DensityRepository = new DensityRepository();
                $Density = $DensityRepository->findById($density_id);
                foreach($Density->toArray() as $key => $value) 
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
     * @param  \Integer $density_id 
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $density_id)
    {        
        $DensityRepository = new DensityRepository();
        if(isset($density_id) && !empty($density_id)) 
        {
            $Density = $DensityRepository->findById($density_id);
            $Density->delete($Density);
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
                $Density = new Density();
                $DensityRepository = new DensityRepository();
                $Density->name = (!empty($name)) ? $name : "";
                $Density = $DensityRepository->save($Density);
                //Response
                $parameters = array();
                $parameters['message'] = $this->getMessage($procedure);
                $parameters['route'] = $this->route;
                $parameters['research_parameters'] = null;
                $View = View::make($this->getView('response'), $parameters)->render();
            break;
            case '2':   //Edit
                $Density = new Density();
                $DensityRepository = new DensityRepository();
                $Density = $DensityRepository->findById($density_id);
                $Density->name = (!empty($name)) ? $name : "";
                $Density = $DensityRepository->save($Density);
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
