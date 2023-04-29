<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\ReceiptPlan;
use App\Models\Receivement;
use App\Repositories\ReceiptPlanRepository;
use App\Repositories\ReceivementRepository;

class ReceivementController extends Controller
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
            $ReceivementRepository = new ReceivementRepository($request);
            $parameters = array();
            $parameters = $request->except('_token');
            $research_parameters = $request->except('_token','refresh_route');
            $request->session()->put('research_parameters', $research_parameters);
            $parameters['parameters'] = $parameters;
            $parameters['list'] = $ReceivementRepository->findBy($parameters, ['id ASC'], 20, 10);
            $parameters['route'] = $this->route;
            $parameters['research_parameters'] = $research_parameters;
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
    public function create(Request $request, $receipt_plan_id = null)
    {           
        if(Auth::user()->hasPermission($this->route->module, $this->route->action))
        {
            $parameters = array();
            $parameters = $request->except('_token');
            $parameters['receipt_plan_id'] = (isset($parameters['receipt_plan_id'])) ? ($parameters['receipt_plan_id']) : $receipt_plan_id;
            $parameters['financial_status_id'] = (isset($parameters['financial_status_id'])) ? ($parameters['financial_status_id']) : "";
            $parameters['segregation_status_id'] = (isset($parameters['segregation_status_id'])) ? ($parameters['segregation_status_id']) : "";
            $parameters['number_ra'] = (isset($parameters['number_ra'])) ? ($parameters['number_ra']) : "";
            $parameters['nf_number'] = (isset($parameters['nf_number'])) ? ($parameters['nf_number']) : ""; 
            $parameters['branch_id'] = (isset($parameters['branch_id'])) ? ($parameters['branch_id']) : "";             
            $parameters['date_receivement'] =  (isset($parameters['date_receivement'])) ? ($parameters['date_receivement']) : date('d/m/Y'); 
            $parameters['user_id'] = (isset($parameters['user_id'])) ? ($parameters['user_id']) : Auth::user()->id;            
            $parameters['supplier_id'] = (isset($parameters['supplier_id'])) ? ($parameters['supplier_id']) : ""; 
            $parameters['operation_type_id'] = (isset($parameters['operation_type_id'])) ? ($parameters['operation_type_id']) : ""; 
            $parameters['nf_weight'] = (isset($parameters['nf_weight'])) ? ($parameters['nf_weight']) : "";             
            $parameters['nf_checked_weight'] = (isset($parameters['nf_checked_weight'])) ? ($parameters['nf_checked_weight']) : "";  
            $parameters['number_volume_received'] = (isset($parameters['number_volume'])) ? ($parameters['number_volume']) : "";    
            $parameters['container_type_id'] = (isset($parameters['container_type_id'])) ? ($parameters['container_type_id']) : ""; 
            $parameters['cargo_quality_id'] = (isset($parameters['cargo_quality_id'])) ? ($parameters['cargo_quality_id']) : ""; 
            $parameters['cargo_addressing'] = (isset($parameters['cargo_addressing'])) ? ($parameters['cargo_addressing']) : ""; 
            $parameters['number_volume_processed'] = (isset($parameters['number_volume_processed'])) ? ($parameters['number_volume_processed']) : ""; 
            $parameters['segregator_id'] = (isset($parameters['segregator_id'])) ? ($parameters['segregator_id']) : ""; 
            $parameters['date_start'] = (isset($parameters['date_start'])) ? ($parameters['date_start']) : ""; 
            $parameters['date_end'] = (isset($parameters['date_end'])) ? ($parameters['date_end']) : ""; 
            $parameters['time_total_cargo_processing'] = (isset($parameters['time_total_cargo_processing'])) ? ($parameters['number_volume_processed']) : ""; 
            $parameters['route'] = $this->route;    
            $receipt_plan_id = (!empty($parameters['receipt_plan_id'])) ? intval($parameters['receipt_plan_id']) : null;
            if(!empty($receipt_plan_id))    
            {
                $ReceiptPlanRepository = new ReceiptPlanRepository();
                $ReceiptPlan = $ReceiptPlanRepository->findById($receipt_plan_id);
                $parameters['receipt_plan_id'] = $ReceiptPlan->id; 
                $parameters['number_ra'] = $ReceiptPlan->number_ra; 
                $parameters['nf_number'] = $ReceiptPlan->nf_number; 
                $parameters['branch_id'] = $ReceiptPlan->branch_id; 
                $parameters['supplier_id'] = $ReceiptPlan->supplier_id; 
                $parameters['operation_type_id'] = $ReceiptPlan->operation_type_id; 
                $parameters['nf_weight'] = $ReceiptPlan->nf_weight; 
                $parameters['nf_checked_weight'] = $ReceiptPlan->nf_checked_weight; 
                $parameters['number_volume_received'] = $ReceiptPlan->number_volume_received; 
            }
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
     * @param  \Integer $receivement_id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $receivement_id)
    {        
        if(Auth::user()->hasPermission($this->route->module, $this->route->action))
        {
            $parameters = array();
            $parameters = $request->except('_token');
            $parameters['receivement_id'] = (isset($parameters['receivement_id'])) ? ($parameters['receivement_id']) : $receivement_id; 
            $parameters['receipt_plan_id'] = (isset($parameters['receipt_plan_id'])) ? ($parameters['receipt_plan_id']) : "";
            $parameters['financial_status_id'] = (isset($parameters['financial_status_id'])) ? ($parameters['financial_status_id']) : "";
            $parameters['segregation_status_id'] = (isset($parameters['segregation_status_id'])) ? ($parameters['segregation_status_id']) : "";
            $parameters['number_ra'] = (isset($parameters['number_ra'])) ? ($parameters['number_ra']) : "";
            $parameters['nf_number'] = (isset($parameters['nf_number'])) ? ($parameters['nf_number']) : ""; 
            $parameters['branch_id'] = (isset($parameters['branch_id'])) ? ($parameters['branch_id']) : "";             
            $parameters['date_receivement'] =  (isset($parameters['date_receivement'])) ? ($parameters['date_receivement']) : date('d/m/Y'); 
            $parameters['user_id'] = (isset($parameters['user_id'])) ? ($parameters['user_id']) : Auth::user()->id;            
            $parameters['supplier_id'] = (isset($parameters['supplier_id'])) ? ($parameters['supplier_id']) : ""; 
            $parameters['operation_type_id'] = (isset($parameters['operation_type_id'])) ? ($parameters['operation_type_id']) : ""; 
            $parameters['nf_weight'] = (isset($parameters['nf_weight'])) ? ($parameters['nf_weight']) : "";             
            $parameters['nf_checked_weight'] = (isset($parameters['nf_checked_weight'])) ? ($parameters['nf_checked_weight']) : "";  
            $parameters['number_volume_received'] = (isset($parameters['number_volume'])) ? ($parameters['number_volume']) : "";    
            $parameters['container_type_id'] = (isset($parameters['container_type_id'])) ? ($parameters['container_type_id']) : ""; 
            $parameters['cargo_quality_id'] = (isset($parameters['cargo_quality_id'])) ? ($parameters['cargo_quality_id']) : ""; 
            $parameters['cargo_addressing'] = (isset($parameters['cargo_addressing'])) ? ($parameters['cargo_addressing']) : ""; 
            $parameters['number_volume_processed'] = (isset($parameters['number_volume_processed'])) ? ($parameters['number_volume_processed']) : ""; 
            $parameters['segregator_id'] = (isset($parameters['segregator_id'])) ? ($parameters['segregator_id']) : ""; 
            $parameters['date_start'] = (isset($parameters['date_start'])) ? ($parameters['date_start']) : ""; 
            $parameters['date_end'] = (isset($parameters['date_end'])) ? ($parameters['date_end']) : ""; 
            $parameters['time_total_cargo_processing'] = (isset($parameters['time_total_cargo_processing'])) ? ($parameters['number_volume_processed']) : ""; 
            $parameters['route'] = $this->route;
            if(isset($receivement_id) && !empty($receivement_id)) 
            {      
                
                $ReceivementRepository = new ReceivementRepository($request);
                $Receivement = $ReceivementRepository->findById($receivement_id);
                foreach($Receivement->toArray() as $key => $value) 
                {                    
                    $parameters[$key] = (!empty($value)) ? $value : $parameters[$key];
                }                
            }      
            $receipt_plan_id = (!empty($parameters['receipt_plan_id'])) ? intval($parameters['receipt_plan_id']) : null;
            if(!empty($receipt_plan_id))    
            {
                $ReceiptPlanRepository = new ReceiptPlanRepository();
                $ReceiptPlan = $ReceiptPlanRepository->findById($receipt_plan_id);
                $parameters['receipt_plan_id'] = $ReceiptPlan->id; 
                $parameters['number_ra'] = $ReceiptPlan->number_ra; 
                $parameters['nf_number'] = $ReceiptPlan->nf_number; 
                $parameters['branch_id'] = $ReceiptPlan->branch_id; 
                $parameters['supplier_id'] = $ReceiptPlan->supplier_id; 
                $parameters['operation_type_id'] = $ReceiptPlan->operation_type_id; 
                $parameters['nf_weight'] = $ReceiptPlan->nf_weight; 
                $parameters['nf_checked_weight'] = $ReceiptPlan->nf_checked_weight; 
                $parameters['number_volume_received'] = $ReceiptPlan->number_volume_received; 
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
     * @param  \Integer $receivement_id 
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $receivement_id)
    {        
        if(Auth::user()->hasPermission($this->route->module, $this->route->action))
        {  
            $ReceivementRepository = new ReceivementRepository($request);
            if(isset($receivement_id) && !empty($receivement_id)) 
            {
                $Receivement = $ReceivementRepository->findById($receivement_id);
                $ReceivementRepository->delete($Receivement);
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

    public function packpage(Request $request, $receivement_id)
    {
        if(Auth::user()->hasPermission($this->route->module, 'extra'))
        {
            $parameters = array();
            $parameters = $request->except('_token');
            if(isset($receivement_id) && !empty($receivement_id)) 
            {    

            }
            return $View = View::make($this->getView('packpage'), $parameters)->render();
        }    
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
                $Receivement = new Receivement();
                $ReceivementRepository = new ReceivementRepository();
                $Receivement->receipt_plan_id = (!empty($receipt_plan_id)) ? $receipt_plan_id : "";
                $Receivement->fiscal_status_id = (!empty($fiscal_status_id)) ? $fiscal_status_id : "";
                $Receivement->segregation_status_id = (!empty($segregation_status_id)) ? $segregation_status_id : "";
                $Receivement->date_receivement = (!empty($date_receivement)) ? \Carbon\Carbon::createFromFormat('d/m/Y', $date_receivement)->format('Y-m-d') : "";
                $Receivement->user_id = (!empty($user_id)) ? $user_id : "";
                $Receivement->container_type_id = (!empty($container_type_id)) ? $container_type_id : "";
                $Receivement->cargo_quality_id = (!empty($cargo_quality_id)) ? $cargo_quality_id : "";
                $Receivement->cargo_addressing = (!empty($cargo_addressing)) ? $cargo_addressing : "";
                $Receivement->number_volume_processed = (!empty($number_volume_processed)) ? $number_volume_processed : "";    
                $Receivement->segregator_id = (!empty($segregator_id)) ? $segregator_id : "";
                $Receivement->date_start = (!empty($date_start)) ? \Carbon\Carbon::createFromFormat('d/m/Y', $date_start)->format('Y-m-d') : "";
                $Receivement->date_end = (!empty($date_end)) ? \Carbon\Carbon::createFromFormat('d/m/Y', $date_end)->format('Y-m-d') : "";
                $Receivement->time_total_cargo_processing = (!empty($time_total_cargo_processing)) ? $time_total_cargo_processing : "";                               
                $Receivement = $ReceivementRepository->save($Receivement);
                //Response
                $parameters = array();
                $parameters['message'] = $this->getMessage($procedure);
                $parameters['route'] = $this->route;
                $parameters['research_parameters'] = null;
                $View = View::make($this->getView('response'), $parameters)->render();
            break;
            case '2':   //Edit
                $Receivement = new Receivement();
                $ReceivementRepository = new ReceivementRepository();
                $Receivement = $ReceivementRepository->findById($receivement_id);
                $Receivement->fiscal_status_id = (!empty($fiscal_status_id)) ? $fiscal_status_id : "";
                $Receivement->segregation_status_id = (!empty($segregation_status_id)) ? $segregation_status_id : "";
                $Receivement->date_receivement = (!empty($date_receivement)) ? \Carbon\Carbon::createFromFormat('d/m/Y', $date_receivement)->format('Y-m-d') : "";
                $Receivement->user_id = (!empty($user_id)) ? $user_id : "";
                $Receivement->container_type_id = (!empty($container_type_id)) ? $container_type_id : "";
                $Receivement->cargo_quality_id = (!empty($cargo_quality_id)) ? $cargo_quality_id : "";
                $Receivement->cargo_addressing = (!empty($cargo_addressing)) ? $cargo_addressing : "";
                $Receivement->number_volume_processed = (!empty($number_volume_processed)) ? $number_volume_processed : "";    
                $Receivement->segregator_id = (!empty($segregator_id)) ? $segregator_id : "";
                $Receivement->date_start = (!empty($date_start)) ? \Carbon\Carbon::createFromFormat('d/m/Y', $date_start)->format('Y-m-d') : "";
                $Receivement->date_end = (!empty($date_end)) ? \Carbon\Carbon::createFromFormat('d/m/Y', $date_end)->format('Y-m-d') : "";
                $Receivement->time_total_cargo_processing = (!empty($time_total_cargo_processing)) ? $time_total_cargo_processing : "";                               
                $Receivement = $ReceivementRepository->save($Receivement);
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
