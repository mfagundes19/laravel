<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\ReceiptPlan;
use App\Models\ReceiptPlanPrevision;
use App\Repositories\ReceiptPlanRepository;

class ReceiptPlanController extends Controller
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
            $ReceiptPlanRepository = new ReceiptPlanRepository($request);
            $parameters = array();
            $parameters = $request->except('_token');
            $research_parameters = $request->except('_token','refresh_route');
            $request->session()->put('research_parameters', $research_parameters);
            $parameters['parameters'] = $parameters;            
            $parameters['list'] = $ReceiptPlanRepository->findBy($parameters, ['id ASC'], 20, 10);
            $parameters['route'] = $this->route;
            $parameters['research_parameters'] = $research_parameters;
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
            $ReceiptPlan = new ReceiptPlan();
            $parameters['user_id'] = (isset($parameters['user_id'])) ? ($parameters['user_id']) : Auth::user()->id;
            $parameters['date_start'] =  (isset($parameters['date_start'])) ? ($parameters['date_start']) : date('d/m/Y'); 
            $parameters['date_expected'] =  (isset($parameters['date_expected'])) ? ($parameters['date_expected']) : "30/04/2022"; 
            $parameters['nf_number'] = (isset($parameters['nf_number'])) ? ($parameters['nf_number']) : "N/C"; 
            $parameters['number_oc'] = (isset($parameters['number_oc'])) ? ($parameters['number_oc']) : "N/C"; 
            $parameters['supplier_id'] = (isset($parameters['supplier_id'])) ? ($parameters['supplier_id']) : "1"; 
            $parameters['operation_type_id'] = (isset($parameters['operation_type_id'])) ? ($parameters['operation_type_id']) : "1";   
            $parameters['prev_product_category_id'] = (isset($parameters['prev_product_category_id'])) ? ($parameters['prev_product_category_id']) : ""; 
            $parameters['prev_product_type_id'] = (isset($parameters['prev_product_type_id'])) ? ($parameters['prev_product_type_id']) : ""; 
            $parameters['prev_percent'] = (isset($parameters['prev_percent'])) ? ($parameters['prev_percent']) : ""; 
            $parameters['number_prevision'] = (isset($parameters['number_prevision'])) ? $parameters['number_prevision'] : 5;
            if(intval($parameters['number_prevision']) > 0) {
                for($i=0; $i < intval($parameters['number_prevision']); $i++) {
                    $parameters['prev_product_category_id'][$i] = (!empty($parameters['prev_product_category_id'][$i])) ? $parameters['prev_product_category_id'][$i] : "0";
                    $parameters['prev_product_type_id'][$i] = (!empty($parameters['prev_product_type_id'][$i])) ? $parameters['prev_product_type_id'][$i] : "0";
                    $parameters['prev_percentual'][$i] = (!empty($parameters['prev_percentual'][$i])) ? $parameters['prev_percentual'][$i] : "";
                }            
            }
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
     * @param  \Integer $receipt_plan_id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $receipt_plan_id)
    {        
        if(Auth::user()->hasPermission($this->route->module, $this->route->action)) {
            $parameters = array();
            $parameters = $request->except('_token');
            $parameters['receipt_plan_id'] = (isset($parameters['receipt_plan_id'])) ? ($parameters['receipt_plan_id']) : $receipt_plan_id; 
            $parameters['user_id'] = (isset($parameters['user_id'])) ? ($parameters['user_id']) : Auth::user()->id;
            $parameters['date_start'] =  (isset($parameters['date_start'])) ? ($parameters['date_start']) : date('d/m/Y'); 
            $parameters['date_expected'] =  (isset($parameters['date_expected'])) ? ($parameters['date_expected']) : "30/04/2022"; 
            $parameters['nf_number'] = (isset($parameters['nf_number'])) ? ($parameters['nf_number']) : "N/C"; 
            $parameters['number_oc'] = (isset($parameters['number_oc'])) ? ($parameters['number_oc']) : "N/C"; 
            $parameters['supplier_id'] = (isset($parameters['supplier_id'])) ? ($parameters['supplier_id']) : "1"; 
            $parameters['operation_type_id'] = (isset($parameters['operation_type_id'])) ? ($parameters['operation_type_id']) : "1";   
            $parameters['prev_product_category_id'] = (isset($parameters['prev_product_category_id'])) ? ($parameters['prev_product_category_id']) : ""; 
            $parameters['prev_product_type_id'] = (isset($parameters['prev_product_type_id'])) ? ($parameters['prev_product_type_id']) : ""; 
            $parameters['prev_percent'] = (isset($parameters['prev_percent'])) ? ($parameters['prev_percent']) : ""; 
            $parameters['number_prevision'] = (isset($parameters['number_prevision'])) ? $parameters['number_prevision'] : 1;
            $parameters['route'] = $this->route;
            if(isset($receipt_plan_id) && !empty($receipt_plan_id)) {      
                $ReceiptPlanRepository = new ReceiptPlanRepository();
                $ReceiptPlan = $ReceiptPlanRepository->findById($receipt_plan_id);
                foreach($ReceiptPlan->toArray() as $key => $value)  {                    
                    $parameters[$key] = (!empty($value)) ? $value : $parameters[$key];
                }
                $parameters['date_start'] =  (!empty($parameters['date_start'])) ? \Carbon\Carbon::parse($parameters['date_start'])->format('d/m/Y')  : "";
                $parameters['date_expected'] =  (!empty($parameters['date_expected'])) ? \Carbon\Carbon::parse($parameters['date_expected'])->format('d/m/Y') : "";
                
                $ReceiptPlanPrevision = new \App\Models\ReceiptPlanPrevision(); 
                $list = $ReceiptPlanPrevision->select('*')->where([['receipt_plan_id','=',$receipt_plan_id]])->get();
                $parameters['number_prevision'] = count($list);
                if(intval($parameters['number_prevision']) > 0) {
                    $parameters['prev_product_category_id'] = array();
                    $parameters['prev_product_type_id'] = array();
                    $parameters['prev_percent'] = array();
                    foreach($list as $i => $vv) {
                        $parameters['prev_product_category_id'][$i] = (!empty($vv->product_category_id)) ? $vv->product_category_id : "0";
                        $parameters['prev_product_type_id'][$i] = (!empty($vv->product_type_id)) ? $vv->product_type_id : "0";
                        $parameters['prev_percent'][$i] = (!empty($vv->percent)) ? $vv->percent : "";
                    }
                }   
            }     
            if(intval($parameters['number_prevision']) > 0) {
                for($i=0; $i < intval($parameters['number_prevision']); $i++) {
                    $parameters['prev_product_category_id'][$i] = (!empty($parameters['prev_product_category_id'][$i])) ? $parameters['prev_product_category_id'][$i] : "";
                    $parameters['prev_product_type_id'][$i] = (!empty($parameters['prev_product_type_id'][$i])) ? $parameters['prev_product_type_id'][$i] : "";
                    $parameters['prev_percent'][$i] = (!empty($parameters['prev_percent'][$i])) ? $parameters['prev_percent'][$i] : "";
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
     * @param  \Integer $receipt_plan_id 
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $receipt_plan_id)
    {        
        if(Auth::user()->hasPermission($this->route->module, $this->route->action)) { 
            $ReceiptPlanRepository = new ReceiptPlanRepository();
            if(isset($receipt_plan_id) && !empty($receipt_plan_id)) {
                $ReceiptPlan = $ReceiptPlanRepository->findById($receipt_plan_id);
                $ReceiptPlanRepository->delete($ReceiptPlan);
            }
            //Response
            $parameters = array();
            $parameters['message'] = $this->getMessage(3);
            $parameters['route'] = $this->route;
            $parameters['research_parameters'] = (!empty($request->session()->get('research_parameters'))) ? $request->session()->get('research_parameters') : "";
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
            case '1':   //Create
                $ReceiptPlan = new ReceiptPlan();
                $ReceiptPlanRepository = new ReceiptPlanRepository();
                $ReceiptPlan->user_id = (!empty($user_id)) ? $user_id : "";
                $ReceiptPlan->date_start = (!empty($date_start)) ? \Carbon\Carbon::createFromFormat('d/m/Y', $date_start)->format('Y-m-d') : "";
                $ReceiptPlan->date_expected = (!empty($date_expected)) ? \Carbon\Carbon::createFromFormat('d/m/Y', $date_expected)->format('Y-m-d') : "";
                $ReceiptPlan->number_oc = (!empty($number_oc)) ? $number_oc : "";
                $ReceiptPlan->nf_number = (!empty($nf_number)) ? $nf_number : "";                                
                $ReceiptPlan->supplier_id = (!empty($supplier_id)) ? $supplier_id : "";
                $ReceiptPlan->operation_type_id = (!empty($operation_type_id)) ? $operation_type_id : "";
                $ReceiptPlan = $ReceiptPlanRepository->save($ReceiptPlan);
                if(intval($number_prevision) > 0) {                    
                    for($i=0; $i < intval($number_prevision); $i++) {
                        $product_category_id = (!empty($prev_product_category_id[$i])) ? $prev_product_category_id[$i] : "";
                        $product_type_id = (!empty($prev_product_type_id[$i])) ? $prev_product_type_id[$i] : "";
                        $percentual = (!empty($prev_percentual[$i])) ? $prev_percentual[$i] : "";
                        $ReceiptPlanPrevision->receipt_plan_id = $receipt_plan_id;
                        $ReceiptPlanPrevision->product_category_id = $product_category_id;
                        $ReceiptPlanPrevision->product_type_id = $product_type_id;
                        $ReceiptPlanPrevision->percent = $percentual;
                        $ReceiptPlan = $ReceiptPlanRepository->save($ReceiptPlanPrevision);
                    }            
                }
                //Response
                $parameters = array();
                $parameters['message'] = $this->getMessage($procedure);
                $parameters['route'] = $this->route;
                $parameters['research_parameters'] = null;
                $View = View::make($this->getView('response'), $parameters)->render();
                break;
            case '2':   //Edit
                $ReceiptPlan = new ReceiptPlan();
                $ReceiptPlanRepository = new ReceiptPlanRepository();
                $ReceiptPlan = $ReceiptPlanRepository->findById($receipt_plan_id);
                $ReceiptPlan->user_id = (!empty($user_id)) ? $user_id : "";
                $ReceiptPlan->date_start = (!empty($date_start)) ? \Carbon\Carbon::createFromFormat('d/m/Y', $date_start)->format('Y-m-d') : "";
                $ReceiptPlan->date_expected = (!empty($date_expected)) ? \Carbon\Carbon::createFromFormat('d/m/Y', $date_expected)->format('Y-m-d') : "";
                $ReceiptPlan->number_oc = (!empty($number_oc)) ? $number_oc : "";
                $ReceiptPlan->nf_number = (!empty($nf_number)) ? $nf_number : "";                                
                $ReceiptPlan->supplier_id = (!empty($supplier_id)) ? $supplier_id : "";
                $ReceiptPlan->operation_type_id = (!empty($operation_type_id)) ? $operation_type_id : "";
                $ReceiptPlan = $ReceiptPlanRepository->save($ReceiptPlan);
                if(intval($number_prevision) > 0) {
                    $ReceiptPlanPrevision = new ReceiptPlanPrevision();
                    $ReceiptPlanRepository->deleteBy($ReceiptPlanPrevision,array('field' => 'receipt_plan_id', 'id' => $receipt_plan_id));
                    for($i=0; $i < intval($number_prevision); $i++) {
                        $product_category_id = (!empty($prev_product_category_id[$i])) ? $prev_product_category_id[$i] : "";
                        $product_type_id = (!empty($prev_product_type_id[$i])) ? $prev_product_type_id[$i] : "";
                        $percentual = (!empty($prev_percentual[$i])) ? $prev_percentual[$i] : "";
                        $ReceiptPlanPrevision = new ReceiptPlanPrevision();
                        $ReceiptPlanPrevision->receipt_plan_id = $receipt_plan_id;
                        $ReceiptPlanPrevision->product_category_id = $product_category_id;
                        $ReceiptPlanPrevision->product_type_id = $product_type_id;
                        $ReceiptPlanPrevision->percent = $percentual;
                        $ReceiptPlan = $ReceiptPlanRepository->save($ReceiptPlanPrevision);
                    }            
                }
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
