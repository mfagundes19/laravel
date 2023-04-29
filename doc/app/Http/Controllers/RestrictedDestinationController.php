<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\RestrictedDestination;
use App\Repositories\RestrictedDestinationRepository;

class RestrictedDestinationController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $RestrictedDestinationRepository = new RestrictedDestinationRepository();
        $parameters = array();
        $parameters = $request->except('_token');
        $research_parameters = $request->except('_token','refresh_route');
        $request->session()->put('research_parameters', $research_parameters);
        $parameters['parameters'] = $parameters;
        $parameters['list'] = $RestrictedDestinationRepository->findBy($parameters, ['id ASC'], 20, 10);
        $parameters['route'] = $this->route;
        $View = View::make($this->getView('index'),$parameters)->render();
        return (isset($parameters['refresh_route'])) ? ($View) : view('layouts/app',array('View' => $View));
    }


    /**
     * Show the form for creating a new resource.
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
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Integer $branch_id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $restricted_destination_id)
    {        
        if(Auth::user()->hasPermission($this->route->module,$this->route->action))
        {
            $parameters = array();
            $parameters = $request->except('_token');
            $parameters['restricted_destination_id'] = (isset($parameters['restricted_destination_id'])) ? ($parameters['restricted_destination_id']) : $restricted_destination_id; 
            $parameters['name'] = (isset($parameters['name'])) ? ($parameters['name']) : ""; 
            $parameters['route'] = $this->route;
            if(isset($restricted_destination_id) && !empty($restricted_destination_id)) 
            {                               
                $RestrictedDestinationRepository = new RestrictedDestinationRepository();
                $RestrictedDestination = $RestrictedDestinationRepository->findById($restricted_destination_id);
                foreach($RestrictedDestination->toArray() as $key => $value) 
                {
                    $parameters[$key] = (!empty($parameters[$key])) ? $parameters[$key] : $value;
                }
            }     
            $parameters['route'] = $this->route;   
            $parameters['research_parameters'] = (!empty($request->session()->get('research_parameters'))) ? \Str::toURL($request->session()->get('research_parameters')) : "";
            $View = View::make($this->getView('edit'), $parameters)->render();
        }
        else
        {
            $View = View::make('errors/403',[])->render();
        }
        return (isset($parameters['refresh_route'])) ? ($View) : view('layouts/app',array('View' => $View));
    }

    /**
     * Save operation of resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $restricted_destination_id)
    {        
        if(Auth::user()->hasPermission($this->route->module, $this->route->action))
        { 
            $RestrictedDestinationRepository = new RestrictedDestinationRepository();
            if(isset($restricted_destination_id) && !empty($restricted_destination_id)) 
            {
                $RestrictedDestination = $RestrictedDestinationRepository->findById($restricted_destination_id);
                $RestrictedDestinationRepository->delete($RestrictedDestination);
            }
            //Response
            $parameters = array();
            $parameters['message'] = "Destino Restrito excluído com sucesso!";
            $parameters['route'] = $this->route;
            $parameters['research_parameters'] = (!empty($request->session()->get('research_parameters'))) ? \Str::toURL($request->session()->get('research_parameters')) : "";
            $View = View::make($this->getView('response'), $parameters)->render();
        }
        else
        {
            $View = View::make('errors/403',[])->render();
        }
        return view('layouts/app',array('View' => $View));
    }

    
    /**
     * Store a resource in storage
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
                $RestrictedDestination = new RestrictedDestination();
                $RestrictedDestinationRepository = new RestrictedDestinationRepository();
                $RestrictedDestination->name = (!empty($name)) ? $name : "";
                $RestrictedDestination = $RestrictedDestinationRepository->save($RestrictedDestination);
                //Response
                $parameters = array();
                $parameters['message'] = "Destino Restrito cadastrado com sucesso!";
                $parameters['route'] = $this->route;
                $parameters['research_parameters'] = null;
                $View = View::make($this->getView('response'), $parameters)->render();
            break;
            case '2':   //Edit
                $RestrictedDestination = new RestrictedDestination();
                $RestrictedDestinationRepository = new RestrictedDestinationRepository();
                $RestrictedDestination = $RestrictedDestinationRepository->findById($restricted_destination_id);
                $RestrictedDestination->name = (!empty($name)) ? $name : "";
                $RestrictedDestination = $RestrictedDestinationRepository->save($RestrictedDestination);
                //Response
                $parameters = array();
                $parameters['message'] = "Destino Restrito alterado com sucesso!";
                $parameters['route'] = $this->route;
                $parameters['research_parameters'] = (!empty($request->session()->get('research_parameters'))) ? \Str::toURL($request->session()->get('research_parameters')) : "";
                $View = View::make($this->getView('response'), $parameters)->render();
            break;
        }
        return view('layouts/app',array('View' => $View));
    }
}
