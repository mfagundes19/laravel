<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\SupplierCategory;
use App\Repositories\SupplierCategoryRepository;

class SupplierCategoryController extends Controller
{
    /**
     * Display a listing of the resource
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::user()->hasPermission($this->route->module, $this->route->action)) {  
            $SupplierCategoryRepository = new SupplierCategoryRepository();
            $parameters = array();
            $parameters = $request->except('_token');
            $research_parameters = $request->except('_token','refresh_route');
            $request->session()->put('research_parameters', $research_parameters);
            $parameters['research_parameters'] = $research_parameters;
            $parameters['parameters'] = $parameters;
            $parameters['list'] = $SupplierCategoryRepository->findBy($parameters, ['id ASC'], 20, 10);
            $parameters['route'] = $this->route;
            $parameters['research_parameters'] = $parameters;
            $View = View::make($this->getView(),$parameters)->render();
        } else {
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
        if(Auth::user()->hasPermission($this->route->module, $this->route->action)) { 
            $parameters = array();
            $parameters = $request->except('_token');
            $parameters['name'] = (isset($parameters['name'])) ? ($parameters['name']) : "";  
            $parameters['route'] = $this->route;
            $View = View::make($this->getView(),$parameters)->render();
        } else {
            $View = View::make('errors/403',[])->render();
        }
        return (isset($parameters['refresh_route'])) ? ($View) : view('layouts/app',array('View' => $View));
    }


    /**
     * Show the form for editing the specified resource
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Integer $supplier_category_id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $supplier_category_id)
    {        
        if(Auth::user()->hasPermission($this->route->module,$this->route->action)) {
            $parameters = array();
            $parameters = $request->except('_token');
            $parameters['supplier_category_id'] = (isset($parameters['supplier_category_id'])) ? ($parameters['supplier_category_id']) : $supplier_category_id; 
            $parameters['name'] = (isset($parameters['name'])) ? ($parameters['name']) : ""; 
            $parameters['route'] = $this->route;
            if(isset($supplier_category_id) && !empty($supplier_category_id)) {                                               
                $SupplierCategoryRepository = new SupplierCategoryRepository();
                $SupplierCategory = $SupplierCategoryRepository->findById($supplier_category_id);
                foreach($SupplierCategory->toArray() as $key => $value) {
                    $parameters[$key] = (!empty($parameters[$key])) ? $parameters[$key] : $value;
                }
            }     
            $parameters['route'] = $this->route;   
            $parameters['research_parameters'] = (!empty($request->session()->get('research_parameters'))) ? \Str::toURL($request->session()->get('research_parameters')) : "";
            $View = View::make($this->getView(), $parameters)->render();
        } else {
            $View = View::make('errors/403',[])->render();
        }
        return (isset($parameters['refresh_route'])) ? ($View) : view('layouts/app',array('View' => $View));
    }


    /**
     * Remove\delete resource of storage
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Integer $supplier_category_id 
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $supplier_category_id)
    {        
        if(Auth::user()->hasPermission($this->route->module, $this->route->action)) { 
            $SupplierCategoryRepository = new SupplierCategoryRepository();
            if(isset($supplier_category_id) && !empty($supplier_category_id)) {
                $SupplierCategory = $SupplierCategoryRepository->findById($supplier_category_id);
                $SupplierCategory->active = false;
                $SupplierCategoryRepository->save($SupplierCategory);
            }
            //Response
            $parameters = array();
            $parameters['message'] = $this->getMessage('deleted');
            $parameters['route'] = $this->route;
            $parameters['research_parameters'] = (!empty($request->session()->get('research_parameters'))) ? \Str::toURL($request->session()->get('research_parameters')) : "";
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

        switch($procedure) {
            case 'create':
                $SupplierCategory = new SupplierCategory();
                $SupplierCategoryRepository = new SupplierCategoryRepository();
                $SupplierCategory->name = (!empty($name)) ? $name : "";
                $SupplierCategory = $SupplierCategoryRepository->save($SupplierCategory);
                //Response
                $parameters = array();
                $parameters['message'] = $this->getMessage('created');
                $parameters['route'] = $this->route;
                $parameters['research_parameters'] = null;
                $View = View::make($this->getView('response'), $parameters)->render();
                break;
            case 'edit':
                $SupplierCategory = new SupplierCategory();
                $SupplierCategoryRepository = new SupplierCategoryRepository();
                $SupplierCategory = $SupplierCategoryRepository->findById($supplier_category_id);
                $SupplierCategory->name = (!empty($name)) ? $name : "";
                $SupplierCategory = $SupplierCategoryRepository->save($SupplierCategory);
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
}
