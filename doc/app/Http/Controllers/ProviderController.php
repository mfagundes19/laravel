<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\Provider;
use App\Repositories\ProviderRepository;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ProviderRepository = new ProviderRepository();
        $parameters = array();
        $parameters = $request->except('_token');
        $parameters['parameters'] = $parameters;
        $parameters['list'] = $ProviderRepository->findBy($parameters, ['id ASC'], 20, 10);
        $parameters['route'] = $this->route;
        $parameters['research_parameters'] = $parameters;
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
     * @param  \Integer $provider_id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $provider_id)
    {        
        if(Auth::user()->hasPermission($this->route->module,$this->route->action))
        {
            $parameters = array();
            $parameters = $request->except('_token');
            $parameters['provider_id'] = (isset($parameters['provider_id'])) ? ($parameters['provider_id']) : $provider_id; 
            $parameters['name'] = (isset($parameters['name'])) ? ($parameters['name']) : ""; 
            $parameters['route'] = $this->route;
            if(isset($provider_id) && !empty($provider_id)) 
            {                                               
                $ProviderRepository = new ProviderRepository();
                $Provider = $ProviderRepository->findById($provider_id);
                foreach($Provider->toArray() as $key => $value) 
                {
                    $parameters[$key] = (!empty($parameters[$key])) ? $parameters[$key] : $value;
                }
            }     
            $parameters['route'] = $this->route;   
            $parameters['research_parameters'] = (!empty($request->session()->get('research_parameters'))) ? $Request->session()->get('research_parameters') : "";
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
     * @param  \Integer $provider_category_id 
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $provider_category_id)
    {        
        $ProviderCategoryRepository = new ProviderCategoryRepository();
        if(isset($provider_category_id) && !empty($provider_category_id)) 
        {
            $ProviderCategory = $ProviderCategoryRepository->findById($provider_category_id);
            $ProviderCategoryRepository->delete($ProviderCategory);
        }
        //Response
        $parameters = array();
        $parameters['message'] = $this->getMessage(3);
        $parameters['route'] = $this->route;
        $parameters['research_parameters'] = (!empty($request->session()->get('research_parameters'))) ? $request->session()->get('research_parameters') : "";
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
                $ProviderCategory = new ProviderCategory();
                $ProviderCategoryRepository = new ProviderCategoryRepository();
                $ProviderCategory->name = (!empty($name)) ? $name : "";
                $ProviderCategory = $ProviderCategoryRepository->save($ProviderCategory);
                //Response
                $parameters = array();
                $parameters['message'] = $this->getMessage($procedure);
                $parameters['route'] = $this->route;
                $parameters['research_parameters'] = null;
                $View = View::make($this->getView('response'), $parameters)->render();
            break;
            case '2':   //Edit
                $ProviderCategory = new ProviderCategory();
                $ProviderCategoryRepository = new ProviderCategoryRepository();
                $ProviderCategory = $ProviderCategoryRepository->findById($provider_category_id);
                $ProviderCategory->name = (!empty($name)) ? $name : "";
                $ProviderCategory = $ProviderCategoryRepository->save($ProviderCategory);
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
