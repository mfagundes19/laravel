<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\PaymentMethod;
use App\Repositories\PaymentMethodRepository;

class PaymentMethodController extends Controller
{

    /**
     * Display a listing of the resource
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $PaymentMethodRepository = new PaymentMethodRepository();
        $parameters = array();
        $parameters = $request->except('_token');
        $research_parameters = $request->except('_token','refresh_route');
        $request->session()->put('research_parameters', $research_parameters);
        $parameters['research_parameters'] = $research_parameters;
        $parameters['parameters'] = $parameters;
        $parameters['list'] = $PaymentMethodRepository->findBy($parameters, ['id ASC'], 20, 10);
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
     * @param  \Integer $color_id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $payment_method_id)
    {        
        if(Auth::user()->hasPermission($this->route->module,$this->route->action)) {
            $parameters = array();
            $parameters = $request->except('_token');
            $parameters['payment_method_id'] = (isset($parameters['payment_method_id'])) ? ($parameters['payment_method_id']) : $payment_method_id; 
            $parameters['name'] = (isset($parameters['name'])) ? ($parameters['name']) : ""; 
            $parameters['route'] = $this->route;
            if(isset($payment_method_id) && !empty($payment_method_id)) {                               
                $PaymentMethodRepository = new PaymentMethodRepository();
                $PaymentMethod = $PaymentMethodRepository->findById($payment_method_id);
                foreach($PaymentMethod->toArray() as $key => $value) {
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
     * @param  \Integer $color_id 
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $payment_method_id)
    {        
        if(Auth::user()->hasPermission($this->route->module, $this->route->action)) {  
            $PaymentMethodRepository = new PaymentMethodRepository();
            if(isset($payment_method_id) && !empty($payment_method_id)) {
                $PaymentMethod = $PaymentMethodRepository->findById($payment_method_id);
                $PaymentMethod->active = false;
                $PaymentMethodRepository->save($PaymentMethod);
            }
            //Response
            $parameters = array();
            $parameters['message'] = $this->getMessage('deleted');
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
        foreach($post_data as $key => $value) {
            $$key = $value;
        }
        switch($procedure) {
            case 'create':   //Create
                $PaymentMethod = new PaymentMethod();
                $PaymentMethodRepository = new PaymentMethodRepository();
                $PaymentMethod->name = (!empty($name)) ? $name : "";
                $PaymentMethod = $PaymentMethodRepository->save($PaymentMethod);
                //Response
                $parameters = array();
                $parameters['message'] = $this->getMessage('created');
                $parameters['route'] = $this->route;
                $parameters['research_parameters'] = null;
                $View = View::make($this->getView('response'), $parameters)->render();
                break;
            case 'edit':   //Edit
                $PaymentMethod = new PaymentMethod();
                $PaymentMethodRepository = new PaymentMethodRepository();
                $PaymentMethod = $PaymentMethodRepository->findById($payment_method_id);
                $PaymentMethod->name = (!empty($name)) ? $name : "";
                $PaymentMethod = $PaymentMethodRepository->save($PaymentMethod);
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
