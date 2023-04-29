<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\ReceiptPlanStatus;
use App\Repositories\ReceiptPlanStatusRepository;

class ReceiptPlanStatusController extends Controller
{
    /**
     * Display a listing of the resource
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ReceiptPlanStatusRepository = new ReceiptPlanStatusRepository();
        $parameters = array();
        $parameters = $request->except('_token');
        $parameters['parameters'] = $parameters;
        $parameters['list'] = $ReceiptPlanStatusRepository->findBy($parameters, ['id ASC'], 20, 10);
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
        if(Auth::user()->hasPermission($this->route->module, $this->route->action))
        {  
            $parameters = array();
            $parameters = $request->except('_token');
            $parameters['name'] = (isset($parameters['name'])) ? ($parameters['name']) : "";  
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
     * @param  \Integer $receipt_plans_status_id 
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $receipt_plans_status_id)
    {        
        if(Auth::user()->hasPermission($this->route->module,$this->route->action))
        {
            $parameters = array();
            $parameters = $request->except('_token');
            $parameters['receipt_plans_status_id'] = (isset($parameters['receipt_plans_status_id'])) ? ($parameters['receipt_plans_status_id']) : $receipt_plans_status_id; 
            $parameters['name'] = (isset($parameters['name'])) ? ($parameters['name']) : ""; 
            $parameters['route'] = $this->route;
            if(isset($receipt_plans_status_id) && !empty($receipt_plans_status_id)) 
            {                               
                $ReceiptPlanStatusRepository = new ReceiptPlanStatusRepository();
                $ReceiptPlanStatus = $ReceiptPlanStatusRepository->findById($receipt_plans_status_id);
                foreach($ReceiptPlanStatus->toArray() as $key => $value) 
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
     * @param  \Integer $segregator_id 
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $segregator_id)
    {      
        if(Auth::user()->hasPermission($this->route->module, $this->route->action))
        {   
            $SegregatorRepository = new SegregatorRepository();
            if(isset($segregator_id) && !empty($segregator_id)) 
            {
                $Segregator = $SegregatorRepository->findById($segregator_id);
                $SegregatorRepository->delete($Segregator);
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
                $ReceiptPlanStatus = new ReceiptPlanStatus();
                $ReceiptPlanStatusRepository = new ReceiptPlanStatusRepository();
                $ReceiptPlanStatus->name = (!empty($name)) ? $name : "";
                $ReceiptPlanStatus = $ReceiptPlanStatusRepository->save($ReceiptPlanStatus);
                //Response
                $parameters = array();
                $parameters['message'] = $this->getMessage($procedure);
                $parameters['route'] = $this->route;
                $parameters['research_parameters'] = null;
                $View = View::make($this->getView('response'), $parameters)->render();
            break;
            case '2':   //Edit
                $ReceiptPlanStatus = new ReceiptPlanStatus();
                $ReceiptPlanStatusRepository = new ReceiptPlanStatusRepository();
                $ReceiptPlanStatus = $ReceiptPlanStatusRepository->findById($receipt_plans_status_id);
                $ReceiptPlanStatus->name = (!empty($name)) ? $name : "";
                $ReceiptPlanStatus = $ReceiptPlanStatusRepository->save($ReceiptPlanStatus);
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
