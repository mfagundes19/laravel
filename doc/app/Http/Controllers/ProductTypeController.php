<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\ProductType;
use App\Repositories\ProductTypeRepository;

class ProductTypeController extends Controller
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
            $ProductTypeRepository = new ProductTypeRepository();
            $parameters = array();
            $parameters = $request->except('_token');
            $research_parameters = $request->except('_token','refresh_route');
            $request->session()->put('research_parameters', $research_parameters);
            $parameters['parameters'] = $parameters;
            $parameters['list'] = $ProductTypeRepository->findBy($parameters, ['id ASC'], 20, 10);
            $parameters['route'] = $this->route;
            $parameters['research_parameters'] = $parameters;
            $View = View::make($this->getView(),$parameters)->render();
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
            $parameters['category_id'] = (isset($parameters['category_id'])) ? ($parameters['category_id']) : "";  
            $parameters['route'] = $this->route;
            $View = View::make($this->getView(),$parameters)->render();
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
     * @param  \Integer $product_type_id
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $product_type_id)
    {        
        if(Auth::user()->hasPermission($this->route->module,$this->route->action))
        {
            $parameters = array();
            $parameters = $request->except('_token');
            $parameters['product_type_id'] = (isset($parameters['product_type_id'])) ? ($parameters['product_type_id']) : $product_type_id; 
            $parameters['name'] = (isset($parameters['name'])) ? ($parameters['name']) : ""; 
            $parameters['category_id'] = (isset($parameters['category_id'])) ? ($parameters['category_id']) : "";
            $parameters['route'] = $this->route;
            if(isset($product_type_id) && !empty($product_type_id)) 
            {                                               
                $ProductTypeRepository = new ProductTypeRepository();
                $ProductType = $ProductTypeRepository->findById($product_type_id);
                foreach($ProductType->toArray() as $key => $value) 
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
     * @param  \Integer $product_type_id 
     * 
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $product_type_id)
    {      
        if(Auth::user()->hasPermission($this->route->module, $this->route->action))
        {  
            $ProductTypeRepository = new ProductTypeRepository();
            if(isset($product_type_id) && !empty($product_type_id)) 
            {
                $ProductType = $ProductTypeRepository->findById($product_type_id);
                $ProductTypeRepository->delete($ProductType);
            }
            //Response
            $parameters = array();
            $parameters['message'] = $this->getMessage(3);
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
                $ProductType = new ProductType();
                $ProductTypeRepository = new ProductTypeRepository();
                $ProductType->name = (!empty($name)) ? $name : "";
                $ProductType->category_id = (!empty($category_id)) ? $category_id : null;
                $ProductType = $ProductTypeRepository->save($ProductType);
                //Response
                $parameters = array();
                $parameters['message'] = $this->getMessage($procedure);
                $parameters['route'] = $this->route;
                $parameters['research_parameters'] = null;
                $View = View::make($this->getView('response'), $parameters)->render();
            break;
            case '2':   //Edit
                $ProductType = new ProductType();
                $ProductTypeRepository = new ProductTypeRepository();
                $ProductType = $ProductTypeRepository->findById($product_type_id);
                $ProductTypeRepository = new ProductTypeRepository();
                $ProductType->name = (!empty($name)) ? $name : "";
                $ProductType->category_id = (!empty($category_id)) ? $category_id : null;
                $ProductType = $ProductTypeRepository->save($ProductType);
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
