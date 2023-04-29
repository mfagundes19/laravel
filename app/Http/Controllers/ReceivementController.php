<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\ReceiptPlan;
use App\Models\Receivement;
use App\Models\ReceivementUpload;
use App\Models\ReceivementChecklist;
use App\Models\ReceivementStatus;
use App\Models\ReceivementPackpage;
use App\Models\ShavingType;
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
        if(Auth::user()->hasPermission($this->route->module, $this->route->action)) { 
            $ReceivementRepository = new ReceivementRepository($request);
            $parameters = array();
            $parameters = $request->except('_token');
            $research_parameters = $request->except('_token','refresh_route');
            $request->session()->put('research_parameters', $research_parameters);
            $parameters['research_parameters'] = $research_parameters;
            $parameters['parameters'] = $parameters;
            $parameters['list'] = $ReceivementRepository->findBy($parameters, ['id ASC'], 20, 10);
            $parameters['route'] = $this->route;
            $View = View::make($this->getView(),$parameters)->render();
        } else {
            $View = View::make('errors/403',[])->render();
        }
        return (isset($parameters['refresh_route'])) ? ($View) : view('layouts/app',array('View' => $View));
    }

    /**
     * Display a listing of the resource
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function alternative(Request $request)
    {
        if(Auth::user()->hasPermission($this->route->module, $this->route->action)) { 
            $ReceivementRepository = new ReceivementRepository($request);
            $parameters = array();
            $parameters = $request->except('_token');
            $research_parameters = $request->except('_token','refresh_route');
            $request->session()->put('research_parameters', $research_parameters);
            $parameters['research_parameters'] = $research_parameters;
            $parameters['parameters'] = $parameters;
            $parameters['list'] = $ReceivementRepository->findBy($parameters, ['id ASC'], 20, 10);
            $parameters['route'] = $this->route;
            $View = View::make($this->getView('alternative'),$parameters)->render();
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
    public function create(Request $request, $receipt_plan_id = null)
    {           
        if(Auth::user()->hasPermission($this->route->module, $this->route->action))
        {
            $parameters = array();
            $parameters = $request->except('_token');
            $parameters['receipt_plan_id'] = (isset($parameters['receipt_plan_id'])) ? ($parameters['receipt_plan_id']) : $receipt_plan_id;
            $parameters['supplier_id'] = (isset($parameters['supplier_id'])) ? ($parameters['supplier_id']) : ""; 
            $parameters['supplier_code'] = (isset($parameters['supplier_id'])) ? str_pad($parameters['supplier_id'],6,'0',STR_PAD_LEFT) : ""; 
            $parameters['date_receivement'] =  (isset($parameters['date_receivement'])) ? ($parameters['date_receivement']) : date('d/m/Y'); 
            $parameters['ra_number'] = (isset($parameters['ra_number'])) ? ($parameters['ra_number']) : "";
            $parameters['branch_id'] = (isset($parameters['branch_id'])) ? ($parameters['branch_id']) : "";             
            $parameters['operation_type_id'] = (isset($parameters['operation_type_id'])) ? ($parameters['operation_type_id']) : ""; 
            $parameters['container_type_id'] = (isset($parameters['container_type_id'])) ? ($parameters['container_type_id']) : ""; 
            $parameters['nf_number'] = (isset($parameters['nf_number'])) ? ($parameters['nf_number']) : "";             
            $parameters['receiver'] = (isset($parameters['receiver'])) ? ($parameters['receiver']) : ""; 
            $parameters['massiness'] = (isset($parameters['massiness'])) ? ($parameters['massiness']) : ""; 
            $parameters['massiness_received'] = (isset($parameters['massiness_received'])) ? ($parameters['massiness_received']) : ""; 
            $parameters['time_discharge'] = (isset($parameters['time_discharge'])) ? ($parameters['time_discharge']) : ""; 
            $parameters['status_id'] = (isset($parameters['status_id'])) ? ($parameters['status_id']) : ""; 
            $parameters['weight'] = (isset($parameters['weight'])) ? ($parameters['weight']) : ""; 
            $parameters['weight_reference'] = (isset($parameters['weight_reference'])) ? ($parameters['weight_reference']) : ""; 
            $parameters['weight_difference'] = (isset($parameters['weight_difference'])) ? ($parameters['weight_difference']) : "0.00"; 
            $parameters['weight_received'] = (isset($parameters['weight_received'])) ? ($parameters['weight_received']) : "0.00"; 
            $parameters['weight_negotiated'] = (isset($parameters['weight_negotiated'])) ? ($parameters['weight_negotiated']) : "0.00"; 
            $parameters['weight_nf'] = (isset($parameters['weight_nf'])) ? ($parameters['weight_nf']) : ""; 
            $parameters['checklist'] = (isset($parameters['checklist'])) ? ($parameters['checklist']) : "";
            $parameters['observations'] = (isset($parameters['observations'])) ? ($parameters['observations']) : "";             
            $parameters['number_upload'] = (isset($parameters['number_upload'])) ? $parameters['number_upload'] : 3;
            $parameters['start_time_receivement'] = (isset($parameters['start_time_receivement'])) ? $parameters['start_time_receivement'] : date('Y-m-d H:i:s'); 
            $parameters['final_time_receivement'] = (isset($parameters['final_time_receivement'])) ? $parameters['final_time_receivement'] : "";  
            $parameters['route'] = $this->route;  
            if(!empty($receipt_plan_id)) {
                $ReceiptPlanRepository = new ReceiptPlanRepository();
                $ReceiptPlan = $ReceiptPlanRepository->findById($receipt_plan_id);
                $parameters['receipt_plan_id'] = $ReceiptPlan->id; 
                $parameters['nf_number'] = $ReceiptPlan->nf_number; 
                $parameters['branch_id'] = $ReceiptPlan->branch_id; 
                $parameters['supplier_id'] = $ReceiptPlan->supplier_id; 
                $parameters['supplier_code'] = (isset($parameters['supplier_id'])) ? str_pad($parameters['supplier_id'],6,'0',STR_PAD_LEFT) : "";            
                $parameters['operation_type_id'] = $ReceiptPlan->operation_type_id; 
                $parameters['weight_negotiated'] = $ReceiptPlan->total_quantity; 
                $parameters['start_time_receivement'] = date('Y-m-d H:i:s'); 
                $parameters['final_time_receivement'] = ""; 
            }
            $parameters['label_weight_negotiated'] = (!empty($parameters['weight_negotiated'])) ? \Str::currency($parameters['weight_negotiated'],'br')  : "";
            $parameters['label_weight_nf'] = (!empty($parameters['weight_nf'])) ? \Str::currency($parameters['weight_nf'],'br')  : "";
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
            $parameters['supplier_id'] = (isset($parameters['supplier_id'])) ? ($parameters['supplier_id']) : ""; 
            $parameters['supplier_code'] = (isset($parameters['supplier_id'])) ? str_pad($parameters['supplier_id'],6,'0',STR_PAD_LEFT) : ""; 
            $parameters['date_receivement'] =  (isset($parameters['date_receivement'])) ? ($parameters['date_receivement']) : ""; 
            $parameters['ra_number'] = (isset($parameters['ra_number'])) ? ($parameters['ra_number']) : "";
            $parameters['branch_id'] = (isset($parameters['branch_id'])) ? ($parameters['branch_id']) : "";             
            $parameters['operation_type_id'] = (isset($parameters['operation_type_id'])) ? ($parameters['operation_type_id']) : ""; 
            $parameters['container_type_id'] = (isset($parameters['container_type_id'])) ? ($parameters['container_type_id']) : ""; 
            $parameters['nf_number'] = (isset($parameters['nf_number'])) ? ($parameters['nf_number']) : "";             
            $parameters['receiver'] = (isset($parameters['receiver'])) ? ($parameters['receiver']) : ""; 
            $parameters['massiness'] = (isset($parameters['massiness'])) ? ($parameters['massiness']) : ""; 
            $parameters['massiness_received'] = (isset($parameters['massiness_received'])) ? ($parameters['massiness_received']) : ""; 
            $parameters['time_discharge'] = (isset($parameters['time_discharge'])) ? ($parameters['time_discharge']) : ""; 
            $parameters['status_id'] = (isset($parameters['status_id'])) ? ($parameters['status_id']) : ""; 
            $parameters['weight'] = (isset($parameters['weight'])) ? ($parameters['weight']) : ""; 
            $parameters['weight_reference'] = (isset($parameters['weight_reference'])) ? ($parameters['weight_reference']) : ""; 
            $parameters['weight_difference'] = (isset($parameters['weight_difference'])) ? ($parameters['weight_difference']) : ""; 
            $parameters['weight_received'] = (isset($parameters['weight_received'])) ? ($parameters['weight_received']) : ""; 
            $parameters['weight_negotiated'] = (isset($parameters['weight_negotiated'])) ? ($parameters['weight_negotiated']) : ""; 
            $parameters['weight_nf'] = (isset($parameters['weight_nf'])) ? ($parameters['weight_nf']) : ""; 
            $parameters['checklist'] = (isset($parameters['checklist'])) ? ($parameters['checklist']) : "";
            $parameters['observations'] = (isset($parameters['observations'])) ? ($parameters['observations']) : "";             
            $parameters['number_upload'] = (isset($parameters['number_upload'])) ? $parameters['number_upload'] : 3;
            $parameters['route'] = $this->route;
            if(isset($receivement_id) && !empty($receivement_id)) {      
                $ReceivementRepository = new ReceivementRepository($request);
                $Receivement = $ReceivementRepository->findById($receivement_id);
                foreach($Receivement->toArray() as $key => $value) {                    
                    $parameters[$key] = (!empty($value)) ? $value : $parameters[$key];
                }    
                $parameters['supplier_code'] = (isset($parameters['supplier_id'])) ? str_pad($parameters['supplier_id'],6,'0',STR_PAD_LEFT) : "";            
                $parameters['json_checklist'] = $parameters['checklist'];
                //Packpage
                $list = $ReceivementRepository->getReceivementPackpage($parameters['receivement_id']);
                if(intval(count($list)) > 0) {
                    $parameters['packpage'] = array();
                    $parameters['weight_received'] = 0.00;
                    foreach($list as $i => $vv) {
                        $parameters['packpage'][$i]['number_card'] = $vv['number_card'];
                        $parameters['packpage'][$i]['weight'] = $vv['weight'];
                        $parameters['packpage'][$i]['shaving_type'] = $vv['shaving_type'];
                        $parameters['packpage'][$i]['shaving_type_id'] = $vv['shaving_type_id'];
                        $parameters['packpage'][$i]['container_type'] = $vv['container_type'];
                        $parameters['packpage'][$i]['container_type_id'] = $vv['container_type_id'];
                        $parameters['packpage'][$i]['observations'] = $vv['observations'];
                        $vv['weight'] = str_replace(".", "", $vv['weight']);
                        $vv['weight'] = str_replace(",", ".", $vv['weight']);
                        $vv['weight'] = floatval($vv['weight']);
                        $parameters['weight_received']+= $vv['weight'];
                    }
                } 
                $parameters['json_packpage'] = json_encode($parameters['packpage'], JSON_UNESCAPED_UNICODE);
                //Upload
                $list = $ReceivementRepository->getReceivementUpload($parameters['receivement_id']);
                if(intval(count($list)) > 0) {
                    $parameters['upload_file'] = array();
                    foreach($list as $i => $vv) {
                        $parameters['upload_file'][$i]['upload_id'] = $vv['id'];
                        $parameters['upload_file'][$i]['filename'] = $vv['filename'];
                        $parameters['upload_file'][$i]['name'] = $vv['filename'];
                    }
                } 
            }      
            if(intval($parameters['number_upload']) > 0) {
                for($i=0; $i < intval($parameters['number_upload']); $i++) {
                    $parameters['upload_name'][$i] = (!empty($parameters['upload_name'][$i])) ? $parameters['upload_name'][$i] : "";
                }            
            }
            $parameters['route'] = $this->route;   
            $parameters['research_parameters'] = (!empty($request->session()->get('research_parameters'))) ? \Str::toURL($request->session()->get('research_parameters')) : "";
            $View = View::make($this->getView(), $parameters)->render();
        }
        else {
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
            if(isset($receivement_id) && !empty($receivement_id)) {
                $Receivement = $ReceivementRepository->findById($receivement_id);
                $Receivement->active = false;
                $ReceivementRepository->save($Receivement);
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
     * Show the form for advanced options
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Integer $receivement_id  
     * @return \Illuminate\Http\Response
     */
    public function advanced(Request $request, $receivement_id = null)
    {        
        if(Auth::user()->hasPermission($this->route->module, 'create')) { 
            $parameters = array();
            $parameters = $request->except('_token');
            $parameters['route'] = $this->route;
            $advanced_option_list = null;
            $json_advanced_option = $parameters['modal_json_checklist'];
            if(!empty($json_advanced_option)) {
                $advanced_option = json_decode($json_advanced_option, true);
                $advanced_option_list = array();
                if(count($advanced_option) > 0) {
                    foreach($advanced_option as $k => $v) {
                        foreach($v as $kk => $vv) {
                            if(in_array($kk,array('option-cargo-quality','option-restriction'))) {
                                $advanced_option_list[$kk] = ($vv);
                            } else {
                                $advanced_option_list[$kk] = ($vv == 1) ? true : false;
                            }
                        }
                    }
                }
            }
            $parameters['advanced_option_list'] = $advanced_option_list;
            return View::make($this->getView('advanced'), $parameters)->render();
        } else {
            return View::make('errors/403',[])->render();
        }        
    }


    /**
     * Show the form for packpage
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Integer $receivement_id  
     * @return \Illuminate\Http\Response
     */
    public function packpage(Request $request)
    {
        if(Auth::user()->hasPermission($this->route->module, 'extra')) {
            $parameters = array();
            $parameters = $request->except('_token');
            $parameters['user_id'] = Auth::user()->id;
            $parameters['packpage_number_card'] = (isset($parameters['packpage_number_card'])) ? $parameters['packpage_number_card'] : "";
            $parameters['packpage_weight'] = (isset($parameters['packpage_weight'])) ? $parameters['packpage_weight'] : "";            
            $parameters['packpage_product_type_id'] = (isset($parameters['packpage_product_type_id'])) ? $parameters['packpage_product_type_id'] : "";
            $parameters['packpage_shaving_type_id'] = (isset($parameters['packpage_shaving_type_id'])) ? $parameters['packpage_shaving_type_id'] : "";
            $parameters['packpage_container_type_id'] = (isset($parameters['packpage_container_type_id'])) ? $parameters['packpage_container_type_id'] : "";
            $parameters['packpage_observations'] = (isset($parameters['packpage_observations'])) ? $parameters['packpage_observations'] : "";
            $parameters['packpage_json_packpage'] = (isset($parameters['packpage_json_packpage'])) ? $parameters['packpage_json_packpage'] : $parameters['modal_json_packpage'];
            $parameters['packpage_json_packpage'] = '[{"number_card":"10125","weight":"1.500,00","product_type_id":"2","product_type":"ABS GF","shaving_type_id":"2","shaving_type":"AMOSTRA P/ LABORATÓRIO","container_type_id":"1","container_type":"SACARIA PALETIZADA","observations":"dasdadasdsdas","elapsed_time":"00:00","status":"Iniciado"}]';
            if(!empty($parameters['packpage_json_packpage'])) {
                $arrPackpageList = (json_decode($parameters['packpage_json_packpage'], true));
                $parameters['list_packpage'] = $arrPackpageList;
            } else {
                $parameters['list_packpage'] = array();
            }
            $parameters['route'] = $this->route;
            return $View = View::make($this->getView('packpage'), $parameters)->render();
        }    
    }


    /**
     * Show the form for packpage of verification
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Integer $receivement_id  
     * @return \Illuminate\Http\Response
     */
    public function verification(Request $request, $receivement_id)
    {
        if(Auth::user()->hasPermission($this->route->module, 'create')) {
            $parameters = array();
            $parameters = $request->except('_token');
            $parameters['receivement_id'] = (isset($parameters['receivement_id'])) ? ($parameters['receivement_id']) : $receivement_id; 
            if(isset($receivement_id) && !empty($receivement_id)) {      
                $ReceivementRepository = new ReceivementRepository();
                //Packpage
                $list = $ReceivementRepository->getReceivementPackpage($parameters['receivement_id']);
                if(intval(count($list)) > 0) {
                    $parameters['packpage'] = array();
                    foreach($list as $i => $vv) {
                        $parameters['packpage'][$i]['receivement_packpage_id'] = $vv['id'];
                        $parameters['packpage'][$i]['number_card'] = $vv['number_card'];
                        $parameters['packpage'][$i]['weight'] = $vv['weight'];
                        $parameters['packpage'][$i]['shaving_type'] = $vv['shaving_type'];
                        $parameters['packpage'][$i]['shaving_type_id'] = $vv['shaving_type_id'];
                        $parameters['packpage'][$i]['container_type'] = $vv['container_type'];
                        $parameters['packpage'][$i]['container_type_id'] = $vv['container_type_id'];
                        $parameters['packpage'][$i]['observations'] = $vv['observations'];
                        $parameters['packpage'][$i]['status'] = $vv['status'];
                        $parameters['packpage'][$i]['comment'] = $vv['comment'];
                    }
                } 
                $parameters['json_packpage'] = json_encode($parameters['packpage'], JSON_UNESCAPED_UNICODE);
            }
            $parameters['route'] = $this->route;
            return $View = View::make($this->getView('packpage-verification'), $parameters)->render();
        }    
    }
    

    /**
     * Save a Inspection of Packpage
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function inspection(Request $request) 
    {
        if(Auth::user()->hasPermission($this->route->module, 'create')) {
            $parameters = array();
            $parameters = $request->except('_token');
            $arrResponse = array();
            if(!empty($parameters['receivement_packpage_id']) && !empty($parameters['status'])) {
                $ReceivementRepository = new ReceivementRepository();
                $ReceivementPackpage = new ReceivementPackpage();
                $ReceivementPackpage = $ReceivementPackpage->find($parameters['receivement_packpage_id']);
                $ReceivementPackpage->status = $parameters['status'];
                $ReceivementRepository->save($ReceivementPackpage);
                $arrResponse['result'] = 'success';
            }
        }
        return json_encode($arrResponse,\JSON_UNESCAPED_UNICODE);
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
                //Calculate a difference for time of time_discharge
                $start_time_receivement = $post_data['start_time_receivement'];
                $final_time_receivement = date('Y-m-d H:i:s');
                $DateTimeStart = new \DateTime($start_time_receivement);
                $DateTimeFinal = new \DateTime($final_time_receivement);
                $DatetimeInterval = $DateTimeStart->diff($DateTimeFinal);
                $hour_time_receivement = (intval($DatetimeInterval->h) < 10) ? "0".(intval($DatetimeInterval->h)) : $DatetimeInterval->h;
                $minute_time_receivement = (intval($DatetimeInterval->i) < 10) ? "0".(intval($DatetimeInterval->i)) : $DatetimeInterval->i;
                $second_time_receivement = (intval($DatetimeInterval->s) < 10) ? "0".(intval($DatetimeInterval->s)) : $DatetimeInterval->s;
                $difference_time_receivement = $hour_time_receivement.":".$minute_time_receivement.":".$second_time_receivement;
                $receivement_status_id = 1;
                //Receivement
                $Receivement = new Receivement();
                $ReceivementRepository = new ReceivementRepository();
                $Receivement->receipt_plan_id = (!empty($receipt_plan_id)) ? $receipt_plan_id : null;
                $Receivement->supplier_id = (!empty($supplier_id)) ? $supplier_id : "";
                $Receivement->date_receivement = (!empty($date_receivement)) ? \Carbon\Carbon::createFromFormat('d/m/Y', $date_receivement)->format('Y-m-d') : "";
                $Receivement->ra_number = (!empty($ra_number)) ? $ra_number : "";
                $Receivement->branch_id = (!empty($branch_id)) ? $branch_id : "";
                $Receivement->operation_type_id = (!empty($operation_type_id)) ? $operation_type_id : "";
                $Receivement->container_type_id = (!empty($container_type_id)) ? $container_type_id : "";
                $Receivement->nf_number = (!empty($nf_number)) ? $nf_number : "";    
                $Receivement->receiver = (!empty($receiver)) ? $receiver : "";        
                $Receivement->weight_nf = (!empty($weight_nf)) ? $weight_nf : "";
                $Receivement->weight_received = (!empty($weight_received)) ? $weight_received : "";        
                $Receivement->weight_reference = (!empty($weight_reference)) ? $weight_reference : "";
                $Receivement->weight_difference = (!empty($weight_difference)) ? $weight_difference : "";        
                $Receivement->start_time_receivement = (!empty($start_time_receivement)) ? $start_time_receivement : "";        
                $Receivement->final_time_receivement = (!empty($final_time_receivement)) ? $final_time_receivement : "";        
                $Receivement->massiness = (!empty($massiness)) ? $massiness : "";        
                $Receivement->massiness_received = (!empty($massiness_received)) ? $massiness_received : "";        
                $Receivement->time_discharge = (!empty($difference_time_receivement)) ? $difference_time_receivement : "";                               
                $Receivement->observations = (!empty($observations)) ? $observations : "";    
                $Receivement = $ReceivementRepository->save($Receivement);
                //Packpage
                if(!empty($json_packpage)) {
                    $arrPackpage = json_decode($json_packpage, true);
                    if(count($arrPackpage) > 0) {
                        foreach($arrPackpage as $k => $v) {
                            $ReceivementPackpage = new ReceivementPackpage();
                            $ReceivementPackpage->receivement_id = $Receivement->id;
                            $ReceivementPackpage->user_id = Auth::user()->id;
                            $ReceivementPackpage->shaving_type_id = $v['shaving_type_id'];
                            $ReceivementPackpage->container_type_id = $v['container_type_id'];
                            $ReceivementPackpage->number_card = $v['number_card'];
                            $ReceivementPackpage->weight = $v['weight'];
                            $ReceivementPackpage->observations = $v['observations'];
                            $ReceivementRepository->save($ReceivementPackpage);
                        }
                    }
                } else {
                    $receivement_status_id = 6;
                }
                //Checklist
                $arrChecklist = json_decode($json_checklist, true);
                $checklist = $json_checklist;
                $Receivement->checklist = (!empty($checklist)) ? $checklist : "";
                $ReceivementRepository->save($Receivement);
                //Upload
                if($request->hasFile('upload_file')) {
                    $files = $request->file('upload_file');
                    foreach($files as $k => $file) {
                        $name = $file->getClientOriginalName();
                        $extension = $file->getClientOriginalExtension();
                        $filename = "upload_".date("YmdHis")."_".$k.'.'.$extension;
                        $allowedfileExtension = ['pdf','jpg','png','docx','gif','jpeg'];
                        if(in_array($extension,$allowedfileExtension)) {
                            $file->storeAs('public/receivement', $filename);
                            $ReceivementUpload = new ReceivementUpload();
                            $ReceivementUpload->receivement_id = $Receivement->id;
                            $ReceivementUpload->filename = $filename;
                            $ReceivementUpload->name = $name;
                            $ReceivementRepository->save($ReceivementUpload);
                        }
                    }
                }
                $Receivement->receivement_status_id = $receivement_status_id;
                $Receivement = $ReceivementRepository->save($Receivement);
                //Response
                $parameters = array();
                $parameters['message'] = $this->getMessage('created');
                $parameters['route'] = $this->route;
                $parameters['research_parameters'] = null;
                $View = View::make($this->getView('response'), $parameters)->render();
            break;
            case 'edit':
                //Receivement
                $Receivement = new Receivement();
                $ReceivementRepository = new ReceivementRepository();
                $Receivement = $ReceivementRepository->findById($receivement_id);
                $Receivement->receipt_plan_id = (!empty($receipt_plan_id)) ? $receipt_plan_id : null;
                $Receivement->supplier_id = (!empty($supplier_id)) ? $supplier_id : "";
                $Receivement->date_receivement = (!empty($date_receivement)) ? \Carbon\Carbon::createFromFormat('d/m/Y', $date_receivement)->format('Y-m-d') : "";
                $Receivement->ra_number = (!empty($ra_number)) ? $ra_number : "";
                $Receivement->branch_id = (!empty($branch_id)) ? $branch_id : "";
                $Receivement->operation_type_id = (!empty($operation_type_id)) ? $operation_type_id : "";
                $Receivement->container_type_id = (!empty($container_type_id)) ? $container_type_id : "";
                $Receivement->nf_number = (!empty($nf_number)) ? $nf_number : "";    
                $Receivement->receiver = (!empty($receiver)) ? $receiver : "";        
                $Receivement->weight_nf = (!empty($weight_nf)) ? $weight_nf : "";
                $Receivement->weight_received = (!empty($weight_received)) ? $weight_received : "";        
                $Receivement->weight_reference = (!empty($weight_reference)) ? $weight_reference : "";
                $Receivement->weight_difference = (!empty($weight_difference)) ? $weight_difference : "";             
                $Receivement->massiness = (!empty($massiness)) ? $massiness : "";        
                $Receivement->massiness_received = (!empty($massiness_received)) ? $massiness_received : "";        
                $Receivement->time_discharge = (!empty($time_discharge)) ? $time_discharge : "";
                $Receivement->observations = (!empty($observations)) ? $observations : "";
                $Receivement = $ReceivementRepository->save($Receivement);
                //Packpage - Clear All Records
                $ReceivementPackpage = new ReceivementPackpage(); 
                $list = $ReceivementPackpage->select('*')->where([['receivement_id','=',$Receivement->id]])->get();
                foreach($list as $i => $v) {
                    $element = $ReceivementPackpage->find($v->id);
                    $ReceivementRepository->delete($element);
                } 
                //Packpage
                if(!empty($json_packpage)) {
                    $arrPackpage = json_decode($json_packpage, true);
                    if(count($arrPackpage) > 0) {
                        foreach($arrPackpage as $k => $v) {
                            $ReceivementPackpage = new ReceivementPackpage();
                            $ReceivementPackpage->receivement_id = $Receivement->id;
                            $ReceivementPackpage->user_id = Auth::user()->id;
                            $ReceivementPackpage->shaving_type_id = $v['shaving_type_id'];
                            $ReceivementPackpage->container_type_id = $v['container_type_id'];
                            $ReceivementPackpage->number_card = $v['number_card'];
                            $ReceivementPackpage->weight = $v['weight'];
                            $ReceivementPackpage->observations = $v['observations'];
                            $ReceivementRepository->save($ReceivementPackpage);
                        }
                    }
                }
                //Checklist
                $arrChecklist = json_decode($json_checklist, true);
                $checklist = $json_checklist;
                $Receivement->checklist = (!empty($checklist)) ? $checklist : "";
                $ReceivementRepository->save($Receivement);
                //Upload
                if($request->hasFile('upload_file')) {
                    $files = $request->file('upload_file');
                    foreach($files as $k => $file) {
                        $name = $file->getClientOriginalName();
                        $extension = $file->getClientOriginalExtension();
                        $filename = "upload_".date("YmdHis")."_".$k.'.'.$extension;
                        $allowedfileExtension = ['pdf','jpg','png','docx','gif','jpeg'];
                        if(in_array($extension,$allowedfileExtension)) {
                            $file->storeAs('public/receivement', $filename);
                            $ReceivementUpload = new ReceivementUpload();
                            $ReceivementUpload->receivement_id = $Receivement->id;
                            $ReceivementUpload->filename = $filename;
                            $ReceivementUpload->name = $name;
                            $ReceivementRepository->save($ReceivementUpload);
                        }
                    }
                }
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
