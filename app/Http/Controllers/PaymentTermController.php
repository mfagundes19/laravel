<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\PaymentTerm;
use App\Repositories\PaymentTermRepository;

class PaymentTermController extends Controller
{

    /**
     * Display a listing of the resource
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $PaymentTermRepository = new PaymentTermRepository();
        $parameters = array();
        $parameters = $request->except('_token');
        $research_parameters = $request->except('_token','refresh_route');
        $request->session()->put('research_parameters', $research_parameters);
        $parameters['research_parameters'] = $research_parameters;
        $parameters['parameters'] = $parameters;
        $parameters['list'] = $PaymentTermRepository->findBy($parameters, ['id ASC'], 20, 10);
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
     * @param  \Integer $payment_term_id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $payment_term_id)
    {        
        if(Auth::user()->hasPermission($this->route->module,$this->route->action)) {
            $parameters = array();
            $parameters = $request->except('_token');
            $parameters['payment_term_id'] = (isset($parameters['payment_term_id'])) ? ($parameters['payment_term_id']) : $payment_term_id; 
            $parameters['name'] = (isset($parameters['name'])) ? ($parameters['name']) : ""; 
            $parameters['route'] = $this->route;
            if(isset($payment_term_id) && !empty($payment_term_id)) {                               
                $PaymentTermRepository = new PaymentTermRepository();
                $PaymentTerm = $PaymentTermRepository->findById($payment_term_id);
                foreach($PaymentTerm->toArray() as $key => $value) {
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
     * @param  \Integer $payment_term_id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $payment_term_id)
    {        
        if(Auth::user()->hasPermission($this->route->module, $this->route->action)) {  
            $PaymentTermRepository = new PaymentTermRepository();
            if(isset($payment_term_id) && !empty($payment_term_id)) {
                $PaymentTerm = $PaymentTermRepository->findById($payment_term_id);
                $PaymentTerm->active = false;
                $PaymentTermRepository->save($PaymentTerm);
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
                $PaymentTerm = new PaymentTerm();
                $PaymentTermRepository = new PaymentTermRepository();
                $PaymentTerm->name = (!empty($name)) ? $name : "";
                $PaymentTerm = $PaymentTermRepository->save($PaymentTerm);
                //Response
                $parameters = array();
                $parameters['message'] = $this->getMessage('created');
                $parameters['route'] = $this->route;
                $parameters['research_parameters'] = null;
                $View = View::make($this->getView('response'), $parameters)->render();
                break;
            case 'edit':   //Edit
                $PaymentTerm = new PaymentTerm();
                $PaymentTermRepository = new PaymentTermRepository();
                $PaymentTerm = $PaymentTermRepository->findById($payment_term_id);
                $PaymentTerm->name = (!empty($name)) ? $name : "";
                $PaymentTerm = $PaymentTermRepository->save($PaymentTerm);
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
