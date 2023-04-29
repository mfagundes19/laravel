<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\ProductQualification;
use App\Repositories\ProductQualificationRepository;

class ProductQualificationController extends Controller
{
    /**
     * Display a listing of the resource
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ProductQualificationRepository = new ProductQualificationRepository();
        $parameters = array();
        $parameters = $request->except('_token');
        $research_parameters = $request->except('_token','refresh_route');
        $request->session()->put('research_parameters', $research_parameters);
        $parameters['parameters'] = $parameters;
        $parameters['list'] = $ProductQualificationRepository->findBy($parameters, ['id ASC'], 20, 10);
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
     * @param  \Integer $product_qualification_id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $product_qualification_id)
    {        
        if(Auth::user()->hasPermission($this->route->module,$this->route->action))
        {
            $parameters = array();
            $parameters = $request->except('_token');
            $parameters['product_qualification_id'] = (isset($parameters['product_qualification_id'])) ? ($parameters['product_qualification_id']) : $product_qualification_id; 
            $parameters['name'] = (isset($parameters['name'])) ? ($parameters['name']) : ""; 
            $parameters['route'] = $this->route;
            if(isset($product_qualification_id) && !empty($product_qualification_id)) 
            {                                               
                $ProductQualificationRepository = new ProductQualificationRepository();
                $ProductQualification = $ProductQualificationRepository->findById($product_qualification_id);
                foreach($ProductQualification->toArray() as $key => $value) 
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
     * @param  \Integer $product_qualification_id 
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $product_qualification_id)
    {        
        $ProductQualificationRepository = new ProductQualificationRepository();
        if(isset($product_qualification_id) && !empty($product_qualification_id)) 
        {
            $ProductQualification = $ProductQualificationRepository->findById($product_qualification_id);
            $ProductQualificationRepository->delete($ProductQualification);
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
                $ProductQualification = new ProductQualification();
                $ProductQualificationRepository = new ProductQualificationRepository();
                $ProductQualification->name = (!empty($name)) ? $name : "";
                $ProductQualification = $ProductQualificationRepository->save($ProductQualification);
                //Response
                $parameters = array();
                $parameters['message'] = $this->getMessage($procedure);
                $parameters['route'] = $this->route;
                $parameters['research_parameters'] = null;
                $View = View::make($this->getView('response'), $parameters)->render();
            break;
            case '2':   //Edit
                $ProductQualification = new ProductQualification();
                $ProductQualificationRepository = new ProductQualificationRepository();
                $ProductQualification = $ProductQualificationRepository->findById($product_qualification_id);
                $ProductQualification->name = (!empty($name)) ? $name : "";
                $ProductQualification = $ProductQualificationRepository->save($ProductQualification);
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
