<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\ReceiptPlan;
use App\Models\ReceiptPlanPrevision;
use App\Models\ReceiptPlanUpload;
use App\Models\ReceiptPlanNotifyReceipt;
use App\Repositories\ReceiptPlanRepository;
use App\Models\Supplier;
use App\Repositories\SupplierRepository;

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
            $parameters['research_parameters'] = $research_parameters;
            $parameters['parameters'] = $parameters;   
            //Status
            foreach ($parameters as $campo => $valor) {
                if(preg_match('/^receipt_status_([0-9])+$/', $campo)) {
                    $explode = explode("_", $campo);
                    $receipt_plan_id = $explode[2];
                    $receipt_status = $explode[0];
                    $ReceiptPlan = $ReceiptPlanRepository->findById($receipt_plan_id);
                    $ReceiptPlan->receipt_status = $valor;
                    $ReceiptPlanRepository->save($ReceiptPlan);
                }
            }
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
    public function create(Request $request, $operation_id = null)
    {           
        if(Auth::user()->hasPermission($this->route->module, $this->route->action)) {
            $parameters = array();
            $parameters = $request->except('_token');
            $ReceiptPlan = new ReceiptPlan();
            ///\Str::debug($parameters);
            $parameters['user_id'] = (isset($parameters['user_id'])) ? ($parameters['user_id']) : Auth::user()->id;
            $parameters['date_start'] =  (isset($parameters['date_start'])) ? ($parameters['date_start']) : date('d/m/Y'); 
            $parameters['date_expected'] =  (isset($parameters['date_expected'])) ? ($parameters['date_expected']) : ""; 
            $parameters['nf_number'] = (isset($parameters['nf_number'])) ? ($parameters['nf_number']) : "N/C"; 
            $parameters['oc_number'] = (isset($parameters['oc_number'])) ? ($parameters['oc_number']) : "N/C"; 
            $parameters['supplier_id'] = (isset($parameters['supplier_id'])) ? ($parameters['supplier_id']) : ""; 
            $parameters['operation_id'] = (isset($parameters['operation_id'])) ? ($parameters['operation_id']) : ""; 
            $parameters['operation_type_id'] = (isset($parameters['operation_type_id'])) ? ($parameters['operation_type_id']) : $operation_id;   
            $parameters['shipping_company_id'] = (isset($parameters['shipping_company_id'])) ? ($parameters['shipping_company_id']) : "";   
            $parameters['shipping'] = (isset($parameters['shipping'])) ? ($parameters['shipping']) : "";   
            $parameters['shipping_amount'] = (isset($parameters['shipping_amount'])) ? ($parameters['shipping_amount']) : "";   
            $parameters['place_discharge'] = (isset($parameters['place_discharge'])) ? ($parameters['place_discharge']) : "";   
            $parameters['branch_id'] = (isset($parameters['branch_id'])) ? ($parameters['branch_id']) : "";   
            $parameters['payment_method_id'] = (isset($parameters['payment_method_id'])) ? ($parameters['payment_method_id']) : "";   
            $parameters['payment_term_id'] = (isset($parameters['payment_term_id'])) ? ($parameters['payment_term_id']) : "";
            $parameters['payment_base_date'] = (isset($parameters['payment_base_date'])) ? ($parameters['payment_base_date']) : "";   
            $parameters['total_traded'] = (isset($parameters['total_traded'])) ? ($parameters['total_traded']) : "";   
            $parameters['payment_comment'] = (isset($parameters['payment_comment'])) ? ($parameters['payment_comment']) : "";
            $parameters['json_receipt_plan_rate'] = (isset($parameters['json_receipt_plan_rate'])) ? ($parameters['json_receipt_plan_rate']) : "";
            $parameters['total_quantity'] = (isset($parameters['total_quantity'])) ? ($parameters['total_quantity']) : "";  
            $parameters['prev_product_category_id'] = (isset($parameters['prev_product_category_id'])) ? ($parameters['prev_product_category_id']) : "";
            $parameters['prev_product_type_id'] = (isset($parameters['prev_product_type_id'])) ? ($parameters['prev_product_type_id']) : "";
            $parameters['prev_percent'] = (isset($parameters['prev_percent'])) ? ($parameters['prev_percent']) : array();
            $parameters['prev_quantity'] = (isset($parameters['prev_quantity'])) ? ($parameters['prev_quantity']) : array();
            $parameters['prev_amount'] = (isset($parameters['prev_amount'])) ? ($parameters['prev_amount']) : array();
            $parameters['number_prevision'] = (isset($parameters['number_prevision'])) ? $parameters['number_prevision'] : 3;
            $parameters['upload_file'] = (isset($parameters['upload_file'])) ? ($parameters['upload_file']) : array();
            $parameters['upload_name'] = (isset($parameters['upload_name'])) ? ($parameters['upload_name']) : array();
            $parameters['number_upload'] = (isset($parameters['number_upload'])) ? $parameters['number_upload'] : 3;
            $parameters['json_receipt_plan_rate'] = (isset($parameters['json_receipt_plan_rate'])) ? ($parameters['json_receipt_plan_rate']) : '';
            $parameters['receipt_status'] = (isset($parameters['receipt_status'])) ? $parameters['receipt_status'] : "";
            $parameters['proceeding'] = (isset($parameters['proceeding'])) ? $parameters['proceeding'] : "";
            if(intval($parameters['number_prevision']) > 0) {
                for($i=0; $i < intval($parameters['number_prevision']); $i++) {
                    $parameters['prev_product_category_id'][$i] = (!empty($parameters['prev_product_category_id'][$i])) ? $parameters['prev_product_category_id'][$i] : "0";
                    $parameters['prev_product_type_id'][$i] = (!empty($parameters['prev_product_type_id'][$i])) ? $parameters['prev_product_type_id'][$i] : "0";
                    $parameters['prev_shaving_type_id'][$i] = (!empty($parameters['prev_shaving_type_id'][$i])) ? $parameters['prev_shaving_type_id'][$i] : "0";
                    $parameters['prev_percent'][$i] = (!empty($parameters['prev_percent'][$i])) ? $parameters['prev_percent'][$i] : "";
                    $parameters['prev_quantity'][$i] = (!empty($parameters['prev_quantity'][$i])) ? $parameters['prev_quantity'][$i] : "";
                    $parameters['prev_amount'][$i] = (!empty($parameters['prev_amount'][$i])) ? $parameters['prev_amount'][$i] : "";
                    $parameters['prev_total'][$i] = (!empty($parameters['prev_total'][$i])) ? $parameters['prev_total'][$i] : "";
                }            
            }
            if(intval($parameters['number_upload']) > 0) {
                for($i=0; $i < intval($parameters['number_upload']); $i++) {
                    $parameters['upload_name'][$i] = (!empty($parameters['upload_name'][$i])) ? $parameters['upload_name'][$i] : "";
                }            
            }
            $parameters['receipt_plan_rate'] = array();
            if(strlen($parameters['json_receipt_plan_rate']) > 0) {
                $parameters['receipt_plan_rate'] = json_decode($parameters['json_receipt_plan_rate'], true);
            }
            $parameters['route'] = $this->route;
            $View = View::make($this->getView(),$parameters)->render();
        } else {
            $View = View::make('errors/403',[])->render();
        }
        return (isset($parameters['refresh_route'])) ? ($View) : view('layouts/app',array('View' => $View));
    }


    /**
     * Show the form for view the specified resource
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Integer $receipt_plan_id
     * @return \Illuminate\Http\Response
     */
    public function preview(Request $request, $receipt_plan_id)
    {
        if(Auth::user()->hasPermission($this->route->module, 'view')) {
            $parameters = array();
            $parameters = $request->except('_token');
            $parameters['route'] = $this->route;
            $parameters['receipt_plan_id'] = (isset($parameters['receipt_plan_id'])) ? ($parameters['receipt_plan_id']) : $receipt_plan_id; 
            if(isset($receipt_plan_id) && !empty($receipt_plan_id)) {      
                $ReceiptPlanRepository = new ReceiptPlanRepository();
                $ReceiptPlan = $ReceiptPlanRepository->findById($receipt_plan_id);
                foreach($ReceiptPlan->toArray() as $key => $value)  {                    
                    $parameters[$key] = (!empty($value)) ? $value : "";
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
                    $parameters['prev_quantity'] = array();
                    $parameters['prev_amount'] = array();
                    $parameters['prev_total'] = array();
                    foreach($list as $i => $vv) {
                        $parameters['prev_product_category_id'][$i] = (!empty($vv->product_category_id)) ? $vv->product_category_id : "0";
                        $parameters['prev_product_type_id'][$i] = (!empty($vv->product_type_id)) ? $vv->product_type_id : "0";
                        $parameters['prev_shaving_type_id'][$i] = (!empty($vv->shaving_type_id)) ? $vv->shaving_type_id : "0";
                        $parameters['prev_percent'][$i] = (!empty($vv->prevision_percent)) ? $vv->prevision_percent : "";
                        $parameters['prev_quantity'][$i] = (!empty($vv->prevision_quantity)) ? $vv->prevision_quantity : "";
                        $parameters['prev_amount'][$i] = (!empty($vv->prevision_amount)) ? $vv->prevision_amount : "";
                        $parameters['prev_total'][$i] = (!empty($vv->prevision_total)) ? $vv->prevision_total : "";
                    }
                }  
                $ReceiptPlanUpload = new \App\Models\ReceiptPlanUpload(); 
                $list = $ReceiptPlanUpload->select()->where([['receipt_plan_id','=', $receipt_plan_id]])->get();
                if(intval(count($list)) > 0) {
                    $parameters['upload_file'] = array();
                    foreach($list as $i => $vv) {
                        $parameters['upload_file'][$i]['id_receipt_plan_upload'] = $vv['id'];
                        $parameters['upload_file'][$i]['filename'] = $vv['filename'];
                        $parameters['upload_file'][$i]['name'] = $vv['filename'];
                    }
                } 
            }  
            $View = View::make($this->getView(), $parameters)->render();
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
    public function edit(Request $request, $receipt_plan_id = null)
    {        
        if(Auth::user()->hasPermission($this->route->module, $this->route->action)) {
            $parameters = array();
            $parameters = $request->except('_token');
            $parameters['receipt_plan_id'] = (isset($parameters['receipt_plan_id'])) ? ($parameters['receipt_plan_id']) : $receipt_plan_id; 
            $parameters['user_id'] = (isset($parameters['user_id'])) ? ($parameters['user_id']) : Auth::user()->id;
            $parameters['date_start'] =  (isset($parameters['date_start'])) ? ($parameters['date_start']) : date('d/m/Y'); 
            $parameters['date_expected'] =  (isset($parameters['date_expected'])) ? ($parameters['date_expected']) : ""; 
            $parameters['nf_number'] = (isset($parameters['nf_number'])) ? ($parameters['nf_number']) : "N/C"; 
            $parameters['oc_number'] = (isset($parameters['oc_number'])) ? ($parameters['oc_number']) : "N/C"; 
            $parameters['supplier_id'] = (isset($parameters['supplier_id'])) ? ($parameters['supplier_id']) : ""; 
            $parameters['operation_type_id'] = (isset($parameters['operation_type_id'])) ? ($parameters['operation_type_id']) : "";   
            $parameters['shipping_company_id'] = (isset($parameters['shipping_company_id'])) ? ($parameters['shipping_company_id']) : "";   
            $parameters['shipping'] = (isset($parameters['shipping'])) ? ($parameters['shipping']) : "";   
            $parameters['shipping_amount'] = (isset($parameters['shipping_amount'])) ? ($parameters['shipping_amount']) : "";   
            $parameters['place_discharge'] = (isset($parameters['place_discharge'])) ? ($parameters['place_discharge']) : "";   
            $parameters['branch_id'] = (isset($parameters['branch_id'])) ? ($parameters['branch_id']) : "";   
            $parameters['payment_method_id'] = (isset($parameters['payment_method_id'])) ? ($parameters['payment_method_id']) : "";   
            $parameters['payment_term_id'] = (isset($parameters['payment_term_id'])) ? ($parameters['payment_term_id']) : "";
            $parameters['payment_base_date'] = (isset($parameters['payment_base_date'])) ? ($parameters['payment_base_date']) : "";   
            $parameters['total_traded'] = (isset($parameters['total_traded'])) ? ($parameters['total_traded']) : "";   
            $parameters['payment_comment'] = (isset($parameters['payment_comment'])) ? ($parameters['payment_comment']) : "";
            $parameters['json_receipt_plan_rate'] = (isset($parameters['json_receipt_plan_rate'])) ? ($parameters['json_receipt_plan_rate']) : "";
            $parameters['total_quantity'] = (isset($parameters['total_quantity'])) ? ($parameters['total_quantity']) : "";   
            $parameters['prev_product_category_id'] = (isset($parameters['prev_product_category_id'])) ? ($parameters['prev_product_category_id']) : ""; 
            $parameters['prev_product_type_id'] = (isset($parameters['prev_product_type_id'])) ? ($parameters['prev_product_type_id']) : ""; 
            $parameters['prev_percent'] = (isset($parameters['prev_percent'])) ? ($parameters['prev_percent']) : array(); 
            $parameters['prev_quantity'] = (isset($parameters['prev_quantity'])) ? ($parameters['prev_quantity']) : array(); 
            $parameters['prev_amount'] = (isset($parameters['prev_amount'])) ? ($parameters['prev_amount']) : array(); 
            $parameters['number_prevision'] = (isset($parameters['number_prevision'])) ? $parameters['number_prevision'] : 5;
            $parameters['number_upload'] = (isset($parameters['number_upload'])) ? $parameters['number_upload'] : 3;
            $parameters['receipt_status'] = (isset($parameters['receipt_status'])) ? $parameters['receipt_status'] : "";
            $parameters['proceeding'] = (isset($parameters['proceeding'])) ? $parameters['proceeding'] : "";
            if(intval($parameters['number_prevision']) > 0) {
                for($i=0; $i < intval($parameters['number_prevision']); $i++) {
                    $parameters['prev_product_category_id'][$i] = (!empty($parameters['prev_product_category_id'][$i])) ? $parameters['prev_product_category_id'][$i] : "1";
                    $parameters['prev_product_type_id'][$i] = (!empty($parameters['prev_product_type_id'][$i])) ? $parameters['prev_product_type_id'][$i] : "1";
                    $parameters['prev_percent'][$i] = (!empty($parameters['prev_percent'][$i])) ? $parameters['prev_percent'][$i] : "";
                    $parameters['prev_quantity'][$i] = (!empty($parameters['prev_quantity'][$i])) ? $parameters['prev_quantity'][$i] : "";
                    $parameters['prev_amount'][$i] = (!empty($parameters['prev_amount'][$i])) ? $parameters['prev_amount'][$i] : "";
                    $parameters['prev_total'][$i] = (!empty($parameters['prev_total'][$i])) ? $parameters['prev_total'][$i] : "";
                }            
            }
            if(intval($parameters['number_upload']) > 0) {
                for($i=0; $i < intval($parameters['number_upload']); $i++) {
                    $parameters['upload_name'][$i] = (!empty($parameters['upload_name'][$i])) ? $parameters['upload_name'][$i] : "";
                }            
            }
            if(strlen($parameters['json_receipt_plan_rate']) > 0) {
                $parameters['receipt_plan_rate'] = json_decode($parameters['json_receipt_plan_rate'], true);
            } else {
                $parameters['receipt_plan_rate'] = array();
            }
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
                $list = $ReceiptPlanPrevision
                                ->select(array('product_category_id','product_type_id','shaving_type_id','prevision_percent','prevision_quantity','prevision_amount','prevision_total','product_type.name as product_type','product_category.name as product_category','shaving_type.name as shaving_type'))
                                ->join('product_type', 'receipt_plan_prevision.product_type_id', '=', 'product_type.id')
                                ->join('product_category', 'receipt_plan_prevision.product_category_id', '=', 'product_category.id')
                                ->join('shaving_type', 'receipt_plan_prevision.shaving_type_id', '=', 'shaving_type.id')
                                ->where([['receipt_plan_id','=',$receipt_plan_id]])
                                ->get();
                $parameters['number_prevision'] = count($list);
                if(intval($parameters['number_prevision']) > 0) {
                    $parameters['json_receipt_plan_rate'] = array();
                    foreach($list as $i => $vv) {
                        $jsonRate = array();
                        $jsonRate['prev_product_category_id'] =  (!empty($vv->product_category_id)) ? $vv->product_category_id : "0";
                        $jsonRate['prev_product_category_text'] = (!empty($vv->product_category)) ? $vv->product_category : "";
                        $jsonRate['prev_product_type_id'] = (!empty($vv->product_type_id)) ? $vv->product_type_id : "0";
                        $jsonRate['prev_product_type_text'] = (!empty($vv->product_type)) ? $vv->product_type : "0";
                        $jsonRate['prev_shaving_type_id'] = (!empty($vv->shaving_type_id)) ? $vv->shaving_type_id : "0";
                        $jsonRate['prev_shaving_type_text'] = (!empty($vv->shaving_type)) ? $vv->shaving_type : "0";
                        $jsonRate['prev_percent'] = (!empty($vv->prevision_percent)) ? $vv->prevision_percent : "";
                        $jsonRate['prev_quantity'] = (!empty($vv->prevision_quantity)) ? $vv->prevision_quantity : "";
                        $jsonRate['prev_amount'] = (!empty($vv->prevision_amount)) ? $vv->prevision_amount : "";
                        $jsonRate['prev_total'] = (!empty($vv->prevision_total)) ? ($vv->prevision_total) : "";
                        $jsonRate['prev_percent'] = (!empty($jsonRate['prev_percent'])) ? \Str::currency($jsonRate['prev_percent'],'point') : "";
                        $jsonRate['prev_quantity'] = (!empty($jsonRate['prev_quantity'])) ? \Str::currency($jsonRate['prev_quantity'],'point') : "";
                        $jsonRate['prev_amount'] = (!empty($jsonRate['prev_amount'])) ? \Str::currency($jsonRate['prev_amount'],'br') : "";
                        $jsonRate['prev_total'] = (!empty($jsonRate['prev_total'])) ? \Str::currency($jsonRate['prev_total'],'br') : "";
                        $parameters['json_receipt_plan_rate'][] = $jsonRate;
                    }
                    $parameters['receipt_plan_rate'] = $parameters['json_receipt_plan_rate'];
                    $parameters['json_receipt_plan_rate'] = json_encode($parameters['json_receipt_plan_rate'], JSON_UNESCAPED_UNICODE);
                }
                $ReceiptPlanUpload = new \App\Models\ReceiptPlanUpload(); 
                $list = $ReceiptPlanUpload->select()->where([['receipt_plan_id','=',$receipt_plan_id]])->get();
                if(intval(count($list)) > 0) {
                    foreach($list as $i => $vv) {
                        $parameters['upload_file'][$i]['id_receipt_plan_upload'] = $vv['id'];
                        $parameters['upload_file'][$i]['filename'] = $vv['filename'];
                        $parameters['upload_file'][$i]['name'] = $vv['filename'];
                    }
                } else {
                    $parameters['number_upload'] = 3;
                }
            }   
            if(intval($parameters['number_upload']) > 0) {
                for($i=0; $i < intval($parameters['number_prevision']); $i++) {
                    $parameters['prev_product_category_id'][$i] = (!empty($parameters['prev_product_category_id'][$i])) ? $parameters['prev_product_category_id'][$i] : "";
                    $parameters['prev_product_type_id'][$i] = (!empty($parameters['prev_product_type_id'][$i])) ? $parameters['prev_product_type_id'][$i] : "";
                    $parameters['prev_percent'][$i] = (!empty($parameters['prev_percent'][$i])) ? $parameters['prev_percent'][$i] : "";
                    $parameters['prev_quantity'][$i] = (!empty($parameters['prev_quantity'][$i])) ? $parameters['prev_quantity'][$i] : "";
                    $parameters['prev_amount'][$i] = (!empty($parameters['prev_amount'][$i])) ? $parameters['prev_amount'][$i] : "";
                }            
            }
            $ReceiptPlanUpload = new \App\Models\ReceiptPlanUpload(); 
            $list = $ReceiptPlanUpload->select()->where([['receipt_plan_id','=',$parameters['receipt_plan_id']]])->get();
            if(intval(count($list)) > 0) {
                $parameters['upload_file'] = array();
                foreach($list as $i => $vv) {
                    $parameters['upload_file'][$i]['upload_id'] = $vv['id'];
                    $parameters['upload_file'][$i]['filename'] = $vv['filename'];
                    $parameters['upload_file'][$i]['name'] = $vv['filename'];
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
                $ReceiptPlan->active = false;
                $ReceiptPlanRepository->save($ReceiptPlan);
            }
            //Response
            $parameters = array();
            $parameters['message'] = "Plano de Recebimento excluído com sucesso";
            $parameters['route'] = $this->route;
            $parameters['research_parameters'] = (!empty($request->session()->get('research_parameters'))) ? $request->session()->get('research_parameters') : "";
            $View = View::make($this->getView('response'), $parameters)->render();
        } else {
            $View = View::make('errors/403',[])->render();
        }
        return view('layouts/app',array('View' => $View));
    }

    
    /**
     * Show the form for create a rate
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Integer $receipt_plan_id  
     * @return \Illuminate\Http\Response
     */
    public function rate(Request $request, $receipt_plan_id = null)
    {        
        if(Auth::user()->hasPermission($this->route->module, 'create')) { 
            $parameters = array();
            $parameters = $request->except('_token');
            $parameters['type_rate'] = (isset($parameters['type_rate'])) ? $parameters['type_rate'] : "";
            $parameters['modal_json_receipt_plan_rate'] = (isset($parameters['modal_json_receipt_plan_rate'])) ? $parameters['modal_json_receipt_plan_rate'] : "";
            $parameters['page_number_prevision'] = (isset($parameters['page_number_prevision'])) ? $parameters['page_number_prevision'] : 3;
            if(intval($parameters['page_number_prevision']) > 0) {
                for($i=0; $i < intval($parameters['page_number_prevision']); $i++) {
                    $parameters['prev_product_category_id'][$i] = (!empty($parameters['prev_product_category_id'][$i])) ? $parameters['prev_product_category_id'][$i] : "0";
                    $parameters['prev_product_type_id'][$i] = (!empty($parameters['prev_product_type_id'][$i])) ? $parameters['prev_product_type_id'][$i] : "0";
                    $parameters['prev_shaving_type_id'][$i] = (!empty($parameters['prev_shaving_type_id'][$i])) ? $parameters['prev_shaving_type_id'][$i] : "0";
                    $parameters['prev_percent'][$i] = (!empty($parameters['prev_percent'][$i])) ? $parameters['prev_percent'][$i] : "";
                    $parameters['prev_quantity'][$i] = (!empty($parameters['prev_quantity'][$i])) ? $parameters['prev_quantity'][$i] : "";
                    $parameters['prev_amount'][$i] = (!empty($parameters['prev_amount'][$i])) ? $parameters['prev_amount'][$i] : "";
                    $parameters['prev_total'][$i] = (!empty($parameters['prev_total'][$i])) ? $parameters['prev_total'][$i] : "";
                }            
            }
            if(strlen($parameters['modal_json_receipt_plan_rate']) > 0) {
                $parameters['receipt_plan_rate'] = json_decode($parameters['modal_json_receipt_plan_rate'], true);
                if(count($parameters['receipt_plan_rate']) > 0) {
                    foreach($parameters['receipt_plan_rate'] as $k => $v) {
                        $parameters['prev_product_category_id'][$k] = (isset($v['prev_product_category_id'])) ? $v['prev_product_category_id'] : "";
                        $parameters['prev_product_type_id'][$k] = (isset($v['prev_product_type_id'])) ? $v['prev_product_type_id'] : ""; 
                        $parameters['prev_shaving_type_id'][$k] = (isset($v['prev_shaving_type_id'])) ? $v['prev_shaving_type_id'] : "";
                        $parameters['prev_percent'][$k] = (isset($v['prev_percent'])) ? $v['prev_percent'] : "";
                        $parameters['prev_quantity'][$k] = (isset($v['prev_quantity'])) ? $v['prev_quantity'] : "";
                        $parameters['prev_amount'][$k] = (isset($v['prev_amount'])) ? $v['prev_amount'] : "";
                        $parameters['prev_total'][$k] = (isset($v['prev_total'])) ? $v['prev_total'] : "";
                    }
                }
                $parameters['modal_json_receipt_plan_rate'] = "";
            } else {
                $parameters['receipt_plan_rate'] = array();
            }
            $parameters['route'] = $this->route;
            return View::make($this->getView(), $parameters)->render();
        } else {
            return View::make('errors/403',[])->render();
        }        
    }

    /**
     * Show the form for create a notify resource
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Integer $receipt_plan_id  
     * @return \Illuminate\Http\Response
     */
    public function notify(Request $request, $receipt_plan_id = null)
    {        
        if(Auth::user()->hasPermission($this->route->module, 'create')) { 
            $ReceiptPlanRepository = new ReceiptPlanRepository();
            $parameters = array();
            $parameters = $request->except('_token');
            $parameters['receipt_plan_id'] = (isset($parameters['receipt_plan_id'])) ? ($parameters['receipt_plan_id']) : $receipt_plan_id; 
            $parameters['date'] = date('d/m/Y');
            $parameters['hour'] = date('h:i:s');
            $parameters['datetime'] = date('dmYhis');
            $parameters['notify_hash'] = (isset($parameters['notify_hash'])) ? ($parameters['notify_hash']) : false; 
            if(!empty($parameters['notify_hash']) && !empty($parameters['receipt_plan_id'])) {
                $ReceiptPlanNotifyReceipt = new ReceiptPlanNotifyReceipt();
                $ReceiptPlanNotifyReceipt->receipt_plan_id = ($parameters['receipt_plan_id']);
                $ReceiptPlanNotifyReceipt->user_id = Auth::user()->id;
                $ReceiptPlanNotifyReceipt->date =  date('Y-m-d');
                $ReceiptPlanNotifyReceipt->hour =  date('h:i:s');
                $ReceiptPlanNotifyReceipt->observations = (!empty($parameters['observations'])) ? $parameters['observations'] : "";
                $ReceiptPlanNotifyReceipt = $ReceiptPlanRepository->save($ReceiptPlanNotifyReceipt);
            }
            $ReceiptPlanNotifyReceipt = new ReceiptPlanNotifyReceipt();
            $parameters['list'] = $ReceiptPlanRepository->findNotify($parameters);
            $parameters['route'] = $this->route;
            return View::make($this->getView(), $parameters)->render();
        } else {
            return View::make('errors/403',[])->render();
        }        
    }


    /**
     * Delete Notify
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Integer $receipt_plan_id  
     * @return \Illuminate\Http\Response
     */
    public function notifyDelete(Request $request, $receipt_plan_id = null)
    {        
        if(Auth::user()->hasPermission($this->route->module, 'create')) { 
            $ReceiptPlanRepository = new ReceiptPlanRepository();
            $parameters = array();
            $parameters = $request->except('_token');
            $parameters['receipt_plan_id'] = (isset($parameters['receipt_plan_id'])) ? ($parameters['receipt_plan_id']) : $receipt_plan_id; 
            $parameters['registration_id'] = (isset($parameters['registration_id'])) ? ($parameters['registration_id']) : null;
            if(!empty($parameters['registration_id'])) {
                $ReceiptPlanNotifyReceipt = new ReceiptPlanNotifyReceipt();
                $ReceiptPlanNotifyReceipt = $ReceiptPlanNotifyReceipt->find($parameters['registration_id']);
                $ReceiptPlanNotifyReceipt = $ReceiptPlanRepository->delete($ReceiptPlanNotifyReceipt);
            }
            $parameters['list'] = $ReceiptPlanRepository->findNotify($parameters);
            $parameters['route'] = $this->route;
            return View::make('receipt-plan/notify-receipt', $parameters)->render();
        } else {
            return View::make('errors/403',[])->render();
        }        
    }


    /**
     * Delete Upload
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Integer $receipt_plan_id  
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request, $receipt_plan_id = null)
    {        
        if(Auth::user()->hasPermission($this->route->module, 'create')) { 
            $ReceiptPlanRepository = new ReceiptPlanRepository();
            $parameters = array();
            $parameters = $request->except('_token');
            $ReceiptPlanUpload = new ReceiptPlanUpload();
            $ReceiptPlanUpload = $ReceiptPlanUpload->find($parameters['upload_id']);
            $ReceiptPlanRepository->delete($ReceiptPlanUpload);
            // $parameters['receipt_plan_id'] = (isset($parameters['receipt_plan_id'])) ? ($parameters['receipt_plan_id']) : $receipt_plan_id; 
            // $parameters['registration_id'] = (isset($parameters['registration_id'])) ? ($parameters['registration_id']) : null;
            // if(!empty($parameters['registration_id'])) {
            //     $ReceiptPlanNotifyReceipt = new ReceiptPlanNotifyReceipt();
            //     $ReceiptPlanNotifyReceipt = $ReceiptPlanNotifyReceipt->find($parameters['registration_id']);
            //     $ReceiptPlanNotifyReceipt = $ReceiptPlanRepository->delete($ReceiptPlanNotifyReceipt);
            // }
            // $parameters['list'] = $ReceiptPlanRepository->findNotify($parameters);
            // $parameters['route'] = $this->route;
            return json_encode(array('result' => 'success'));
        } else {
            return json_encode(array('result' => 'error'));
        }      
    }

    
    /**
     * Create a Supplier
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function supplier(Request $request)
    {        
        if(Auth::user()->hasPermission($this->route->module, 'create')) { 
            $parameters = array();
            $parameters = $request->except('_token');
            if(!empty($parameters['document'])) {
                $SupplierRepository = new SupplierRepository();
                $Supplier = new Supplier();
                $Supplier->document = $parameters['document'];
                $Supplier->company = $parameters['company'];
                $Supplier->name = $parameters['name'];
                $Supplier = $SupplierRepository->save($Supplier);
                $parameters['supplier_id'] = $Supplier->id; 
                echo('<script>alertify.success("Fornecedor Cadastrado com Sucesso!"); setTimeout(() => { window.location.reload(); },500); </script>');
            }            
            $parameters['route'] = $this->route;
            return View::make('receipt-plan/supplier', $parameters)->render();
        } else {
            return View::make('errors/403',[])->render();
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
        foreach($post_data as $key => $value) {
            $$key = $value;
        }
        switch($procedure) {
            case 'create':
                $ReceiptPlan = new ReceiptPlan();
                $ReceiptPlanRepository = new ReceiptPlanRepository();
                $ReceiptPlan->user_id = (!empty($user_id)) ? $user_id : "";
                $ReceiptPlan->date_start = (!empty($date_start)) ? \Carbon\Carbon::createFromFormat('d/m/Y', $date_start)->format('Y-m-d') : "";
                $ReceiptPlan->date_expected = (!empty($date_expected)) ? \Carbon\Carbon::createFromFormat('d/m/Y', $date_expected)->format('Y-m-d') : "";
                $ReceiptPlan->supplier_id = (!empty($supplier_id)) ? $supplier_id : "";
                $ReceiptPlan->operation_type_id = (!empty($operation_type_id)) ? $operation_type_id : "";
                $ReceiptPlan->nf_number = (!empty($nf_number)) ? $nf_number : "";
                $ReceiptPlan->shipping_company_id = (!empty($shipping_company_id)) ? $shipping_company_id : "";
                $ReceiptPlan->shipping = (!empty($shipping)) ? $shipping : "";
                $ReceiptPlan->shipping_amount = (!empty($shipping_amount)) ? \Str::currency($shipping_amount,'us') : "";
                $ReceiptPlan->branch_id = (!empty($branch_id)) ? $branch_id : "";
                $ReceiptPlan->payment_method_id = (!empty($payment_method_id)) ? $payment_method_id : "";
                $ReceiptPlan->payment_term_id = (!empty($payment_term_id)) ? $payment_term_id : "";
                $ReceiptPlan->place_discharge = (!empty($place_discharge)) ? $place_discharge : "";
                $ReceiptPlan->payment_base_date = (!empty($payment_base_date)) ? $payment_base_date : "";
                $ReceiptPlan->total_traded = (!empty($total_traded)) ? \Str::currency($total_traded,'us') : "0.00";
                $ReceiptPlan->payment_comment = (!empty($payment_comment)) ? $payment_comment : "";
                $ReceiptPlan->total_quantity = (!empty($total_quantity)) ? \Str::currency($total_quantity,'us') : "0.00";
                $ReceiptPlan->proceeding = (!empty($proceeding)) ? $proceeding : "";
                $ReceiptPlan = $ReceiptPlanRepository->save($ReceiptPlan);
                //Prevision
                $json_receipt_plan_rate = json_decode($json_receipt_plan_rate,true);
                if(intval(count($json_receipt_plan_rate)) > 0) {          
                    $ReceiptPlanPrevision = new ReceiptPlanPrevision(); 
                    $list = $ReceiptPlanPrevision->select('*')->where([['receipt_plan_id','=',$ReceiptPlan->id]])->get();
                    foreach($list as $i => $v) {
                        $element = $ReceiptPlanPrevision->find($v->id);
                        $ReceiptPlanRepository->delete($element);
                    }          
                    foreach($json_receipt_plan_rate as $k => $v) {
                        $product_category_id = (!empty($v['prev_product_category_id'])) ? $v['prev_product_category_id'] : "";
                        $product_type_id = (!empty($v['prev_product_type_id'])) ? $v['prev_product_type_id'] : "";
                        $shaving_type_id = (!empty($v['prev_shaving_type_id'])) ? $v['prev_shaving_type_id'] : "";
                        $prevision_percent = (!empty($v['prev_percent'])) ? $v['prev_percent'] : "";
                        $prevision_quantity = (!empty($v['prev_quantity'])) ? $v['prev_quantity'] : "";
                        $prevision_amount = (!empty($v['prev_amount'])) ? $v['prev_amount'] : "";
                        $prevision_total = (!empty($v['prev_total'])) ? $v['prev_total'] : "";
                        if(!empty($product_category_id) && !empty($product_type_id) && !empty($prevision_total) ) {
                            $ReceiptPlanPrevision = new ReceiptPlanPrevision();
                            $ReceiptPlanPrevision->receipt_plan_id = $ReceiptPlan->id;
                            $ReceiptPlanPrevision->product_category_id = $product_category_id;
                            $ReceiptPlanPrevision->product_type_id = $product_type_id;
                            $ReceiptPlanPrevision->shaving_type_id = $shaving_type_id;
                            $ReceiptPlanPrevision->prevision_percent = \Str::currency($prevision_percent,'us');
                            $ReceiptPlanPrevision->prevision_quantity = \Str::currency($prevision_quantity,'us');
                            $ReceiptPlanPrevision->prevision_amount = \Str::currency($prevision_amount,'us');
                            $ReceiptPlanPrevision->prevision_total = \Str::currency($prevision_total,'us');
                            $ReceiptPlanRepository->save($ReceiptPlanPrevision);
                        }
                    }
                }   
                //Upload        
                if($request->hasFile('upload_file')) {
                    $files = $request->file('upload_file');
                    foreach($files as $k => $file) {
                        $name = $file->getClientOriginalName();
                        $extension = $file->getClientOriginalExtension();
                        $filename = "upload_".date("YmdHis")."_".$k.'.'.$extension;
                        $allowedfileExtension = ['pdf','jpg','png','docx','gif','jpeg'];
                        if(in_array($extension,$allowedfileExtension)) {
                            $file->storeAs('public/receipt-plan', $filename);
                            $ReceiptPlanUpload = new ReceiptPlanUpload();
                            $ReceiptPlanUpload->receipt_plan_id = $ReceiptPlan->id;
                            $ReceiptPlanUpload->filename = $filename;
                            $ReceiptPlanUpload->name = $name;
                            $ReceiptPlanRepository->save($ReceiptPlanUpload);
                        }
                    }
                }      
                //Response
                $parameters = array();
                $parameters['message'] = "Plano de Recebimento adicionado com sucesso";
                $parameters['route'] = $this->route;
                $parameters['research_parameters'] = null;
                $View = View::make($this->getView('response'), $parameters)->render();
                break;
            case 'edit':
                $ReceiptPlan = new ReceiptPlan();
                $ReceiptPlanRepository = new ReceiptPlanRepository();
                $ReceiptPlan = $ReceiptPlanRepository->findById($receipt_plan_id);
                $ReceiptPlan->user_id = (!empty($user_id)) ? $user_id : "";
                $ReceiptPlan->date_start = (!empty($date_start)) ? \Carbon\Carbon::createFromFormat('d/m/Y', $date_start)->format('Y-m-d') : "";
                $ReceiptPlan->date_expected = (!empty($date_expected)) ? \Carbon\Carbon::createFromFormat('d/m/Y', $date_expected)->format('Y-m-d') : "";
                $ReceiptPlan->supplier_id = (!empty($supplier_id)) ? $supplier_id : "";
                $ReceiptPlan->operation_type_id = (!empty($operation_type_id)) ? $operation_type_id : "";
                $ReceiptPlan->nf_number = (!empty($nf_number)) ? $nf_number : "";
                $ReceiptPlan->shipping_company_id = (!empty($shipping_company_id)) ? $shipping_company_id : "";
                $ReceiptPlan->shipping = (!empty($shipping)) ? $shipping : "";
                $ReceiptPlan->shipping_amount = (!empty($shipping_amount)) ? \Str::currency($shipping_amount,'us') : "";
                $ReceiptPlan->branch_id = (!empty($branch_id)) ? $branch_id : "";
                $ReceiptPlan->payment_method_id = (!empty($payment_method_id)) ? $payment_method_id : "";
                $ReceiptPlan->payment_term_id = (!empty($payment_term_id)) ? $payment_term_id : "";
                $ReceiptPlan->place_discharge = (!empty($place_discharge)) ? $place_discharge : "";
                $ReceiptPlan->payment_base_date = (!empty($payment_base_date)) ? $payment_base_date : "";
                $ReceiptPlan->total_traded = (!empty($total_traded)) ? \Str::currency($total_traded,'us') : "0.00";
                $ReceiptPlan->payment_comment = (!empty($payment_comment)) ? $payment_comment : "";
                $ReceiptPlan->total_quantity = (!empty($total_quantity)) ? \Str::currency($total_quantity,'us') : "0.00";
                $ReceiptPlan->proceeding = (!empty($proceeding)) ? $proceeding : "";
                $ReceiptPlan = $ReceiptPlanRepository->save($ReceiptPlan);
                //Prevision
                $json_receipt_plan_rate = json_decode($json_receipt_plan_rate,true);
                if(intval(count($json_receipt_plan_rate)) > 0) {          
                    $ReceiptPlanPrevision = new ReceiptPlanPrevision(); 
                    $list = $ReceiptPlanPrevision->select('*')->where([['receipt_plan_id','=',$ReceiptPlan->id]])->get();
                    foreach($list as $i => $v) {
                        $element = $ReceiptPlanPrevision->find($v->id);
                        $ReceiptPlanRepository->delete($element);
                    }          
                    foreach($json_receipt_plan_rate as $k => $v) {
                        $product_category_id = (!empty($v['prev_product_category_id'])) ? $v['prev_product_category_id'] : "";
                        $product_type_id = (!empty($v['prev_product_type_id'])) ? $v['prev_product_type_id'] : "";
                        $shaving_type_id = (!empty($v['prev_shaving_type_id'])) ? $v['prev_shaving_type_id'] : "";
                        $prevision_percent = (!empty($v['prev_percent'])) ? $v['prev_percent'] : "";
                        $prevision_quantity = (!empty($v['prev_quantity'])) ? $v['prev_quantity'] : "";
                        $prevision_amount = (!empty($v['prev_amount'])) ? $v['prev_amount'] : "";
                        $prevision_total = (!empty($v['prev_total'])) ? $v['prev_total'] : "";
                        if(!empty($product_category_id) && !empty($product_type_id) && !empty($prevision_total) ) {
                            $ReceiptPlanPrevision = new ReceiptPlanPrevision();
                            $ReceiptPlanPrevision->receipt_plan_id = $ReceiptPlan->id;
                            $ReceiptPlanPrevision->product_category_id = $product_category_id;
                            $ReceiptPlanPrevision->product_type_id = $product_type_id;
                            $ReceiptPlanPrevision->shaving_type_id = $shaving_type_id;
                            $ReceiptPlanPrevision->prevision_percent = \Str::currency($prevision_percent,'us');
                            $ReceiptPlanPrevision->prevision_quantity = \Str::currency($prevision_quantity,'us');
                            $ReceiptPlanPrevision->prevision_amount = \Str::currency($prevision_amount,'us');
                            $ReceiptPlanPrevision->prevision_total = \Str::currency($prevision_total,'us');
                            $ReceiptPlanRepository->save($ReceiptPlanPrevision);
                        }
                    }
                }  

                //Upload
                if($request->hasFile('upload_file')) {
                    $files = $request->file('upload_file');
                    foreach($files as $k => $file) {
                        $name = $file->getClientOriginalName();
                        $extension = $file->getClientOriginalExtension();
                        $filename = "upload_".date("YmdHis")."_".$k.'.'.$extension;
                        $allowedfileExtension = ['pdf','jpg','png','docx','gif','jpeg'];
                        if(in_array($extension,$allowedfileExtension)) {
                            $file->storeAs('public/receipt-plan', $filename);
                            $ReceiptPlanUpload = new ReceiptPlanUpload();
                            $ReceiptPlanUpload->receipt_plan_id = $ReceiptPlan->id;
                            $ReceiptPlanUpload->filename = $filename;
                            $ReceiptPlanUpload->name = $name;
                            $ReceiptPlanRepository->save($ReceiptPlanUpload);
                        }
                    }
                }
                
                //Response
                $parameters = array();
                $parameters['message'] = "Plano de Recebimento alterado com sucesso";
                $parameters['route'] = $this->route;
                $parameters['research_parameters'] = (!empty($request->session()->get('research_parameters'))) ? $request->session()->get('research_parameters') : "";
                $View = View::make($this->getView('response'), $parameters)->render();
                break;
        }
        return view('layouts/app',array('View' => $View));
    }
}