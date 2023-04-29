<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\Negotiation;
use App\Models\NegotiationPrevision;
use App\Models\Supplier;
use App\Repositories\NegotiationRepository;
use App\Repositories\SupplierRepository;

class NegotiationController extends Controller
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
            $NegotiationRepository = new NegotiationRepository($request);
            $parameters = array();
            $parameters = $request->except('_token');
            $research_parameters = $request->except('_token','refresh_route');
            $request->session()->put('research_parameters', $research_parameters);
            $parameters['research_parameters'] = $research_parameters;
            $parameters['parameters'] = $parameters;          
            $parameters['list'] = $NegotiationRepository->findBy($parameters, ['id ASC'], 20, 10);
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
            $parameters['supplier_id'] = (isset($parameters['supplier_id'])) ? ($parameters['supplier_id']) : "1";
            $parameters['supplier_name'] = (isset($parameters['supplier_name'])) ? ($parameters['supplier_name']) : "";
            $parameters['supplier_contact'] = (isset($parameters['supplier_contact'])) ? ($parameters['supplier_contact']) : "";
            $parameters['supplier_telephone'] = (isset($parameters['supplier_telephone'])) ? ($parameters['supplier_telephone']) : "";
            $parameters['supplier_email'] = (isset($parameters['supplier_email'])) ? ($parameters['supplier_email']) : "";
            $parameters['shipping_amount'] = (isset($parameters['shipping_amount'])) ? ($parameters['shipping_amount']) : "";
            $parameters['supplier_city'] = (isset($parameters['supplier_city'])) ? ($parameters['supplier_city']) : "";
            $parameters['supplier_state'] = (isset($parameters['supplier_state'])) ? ($parameters['supplier_state']) : "";
            $parameters['negotiation_upload'] = (isset($parameters['negotiation_upload'])) ? ($parameters['negotiation_upload']) : "";
            $parameters['date_expiration'] = (isset($parameters['date_expiration'])) ? ($parameters['date_expiration']) : "";
            $parameters['number_prevision'] = (isset($parameters['number_prevision'])) ? $parameters['number_prevision'] : 3;
            if(intval($parameters['number_prevision']) > 0) {
                for($i=0; $i < intval($parameters['number_prevision']); $i++) {
                    $parameters['prev_description'][$i] = (!empty($parameters['prev_description'][$i])) ? $parameters['prev_description'][$i] : "";
                    $parameters['prev_quantity'][$i] = (!empty($parameters['prev_quantity'][$i])) ? $parameters['prev_quantity'][$i] : "";
                    $parameters['prev_amount'][$i] = (!empty($parameters['prev_amount'][$i])) ? $parameters['prev_amount'][$i] : "";
                }            
            }
            $parameters['route'] = $this->route;
            if(!empty($parameters['supplier_id']) && empty($parameters['supplier_name'])) {
                if(intval($parameters['supplier_id']) > 0) {                                               
                    $SupplierRepository = new SupplierRepository();
                    $Supplier = $SupplierRepository->findById($parameters['supplier_id']);
                    if(!empty($Supplier)) {
                        $parameters['supplier_name'] = $Supplier->name;
                        $parameters['supplier_telephone'] = $Supplier->telephone;
                        $parameters['supplier_email'] = $Supplier->email;
                        $parameters['supplier_city'] = $Supplier->city;
                        $parameters['supplier_state'] = $Supplier->state;
                    }
                } 
            }
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
    public function edit(Request $request, $negotiation_id)
    {        
        if(Auth::user()->hasPermission($this->route->module, $this->route->action)) {
            $parameters = array();
            $parameters = $request->except('_token');
            $parameters['negotiation_id'] = (isset($parameters['negotiation_id'])) ? ($parameters['negotiation_id']) : $negotiation_id; 
            $parameters['supplier_id'] = (isset($parameters['supplier_id'])) ? ($parameters['supplier_id']) : "1";
            $parameters['supplier_name'] = (isset($parameters['supplier_name'])) ? ($parameters['supplier_name']) : "";
            $parameters['supplier_contact'] = (isset($parameters['supplier_contact'])) ? ($parameters['supplier_contact']) : "";
            $parameters['supplier_telephone'] = (isset($parameters['supplier_telephone'])) ? ($parameters['supplier_telephone']) : "";
            $parameters['supplier_email'] = (isset($parameters['supplier_email'])) ? ($parameters['supplier_email']) : "";
            $parameters['shipping_amount'] = (isset($parameters['shipping_amount'])) ? ($parameters['shipping_amount']) : "";
            $parameters['supplier_city'] = (isset($parameters['supplier_city'])) ? ($parameters['supplier_city']) : "";
            $parameters['supplier_state'] = (isset($parameters['supplier_state'])) ? ($parameters['supplier_state']) : "";
            $parameters['observations'] = (isset($parameters['observations'])) ? ($parameters['observations']) : "";
            $parameters['negotiation_upload'] = (isset($parameters['negotiation_upload'])) ? ($parameters['negotiation_upload']) : "";
            $parameters['date_expiration'] = (isset($parameters['date_expiration'])) ? ($parameters['date_expiration']) : "";
            $parameters['number_prevision'] = (isset($parameters['number_prevision'])) ? $parameters['number_prevision'] : 5;
            $parameters['route'] = $this->route;
            if(isset($negotiation_id) && !empty($negotiation_id)) {      
                $NegotiationRepository = new NegotiationRepository();
                $Negotiation = $NegotiationRepository->findById($negotiation_id);
                foreach($Negotiation->toArray() as $key => $value)  {                    
                    $parameters[$key] = (!empty($value)) ? $value : $parameters[$key];
                }
                $parameters['date_expiration'] =  (!empty($parameters['date_expiration'])) ? \Carbon\Carbon::parse($parameters['date_expiration'])->format('d/m/Y')  : "";

                $NegotiationPrevision = new NegotiationPrevision(); 
                $list = $NegotiationPrevision->select('*')->where([['negotiation_id','=',$negotiation_id]])->get();
                $parameters['number_prevision'] = count($list);
                if(intval($parameters['number_prevision']) > 0) {
                    $parameters['prev_description'] = array();
                    $parameters['prev_quantity'] = array();
                    $parameters['prev_amount'] = array();
                    foreach($list as $i => $vv) {
                        $parameters['prev_description'][$i] = (!empty($vv->description)) ? $vv->description : "";
                        $parameters['prev_quantity'][$i] = (!empty($vv->quantity)) ? $vv->quantity : "";
                        $parameters['prev_amount'][$i] = (!empty($vv->amount)) ? $vv->amount : "";
                    }
                }   
            }  
            if(intval($parameters['number_prevision']) > 0) {
                for($i=0; $i < intval($parameters['number_prevision']); $i++) {
                    $parameters['prev_description'][$i] = (!empty($parameters['prev_description'][$i])) ? $parameters['prev_description'][$i] : "";                
                    $parameters['prev_quantity'][$i] = (!empty($parameters['prev_quantity'][$i])) ? $parameters['prev_quantity'][$i] : "";
                    $parameters['prev_amount'][$i] = (!empty($parameters['prev_amount'][$i])) ? $parameters['prev_amount'][$i] : "";
                }            
            }   
            if(!empty($parameters['supplier_id']) && empty($parameters['supplier_name'])) {
                if(intval($parameters['supplier_id']) > 0) {                                               
                    $SupplierRepository = new SupplierRepository();
                    $Supplier = $SupplierRepository->findById($parameters['supplier_id']);
                    if(!empty($Supplier)) {
                        $parameters['supplier_name'] = $Supplier->name;
                        $parameters['supplier_telephone'] = $Supplier->telephone;
                        $parameters['supplier_email'] = $Supplier->email;
                        $parameters['supplier_city'] = $Supplier->city;
                        $parameters['supplier_state'] = $Supplier->state;
                    }
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
     * @param  \Integer $negotiation_id 
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $negotiation_id)
    {        
        if(Auth::user()->hasPermission($this->route->module, $this->route->action)) { 
            $NegotiationRepository = new NegotiationRepository();
            if(isset($negotiation_id) && !empty($negotiation_id)) {
                $Negotiation = $NegotiationRepository->findById($negotiation_id);
                $Negotiation->active = false;
                $NegotiationRepository->save($Negotiation);
            }
            //Response
            $parameters = array();
            $parameters['message'] = $this->getMessage('deleted');
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
            case 'create':
                $Negotiation = new Negotiation();
                $NegotiationRepository = new NegotiationRepository();
                $Negotiation->supplier_id = (!empty($supplier_id)) ? $supplier_id : "";
                $Negotiation->supplier_name = (!empty($supplier_name)) ? $supplier_name : "";
                $Negotiation->supplier_contact = (!empty($supplier_contact)) ? $supplier_contact : "";
                $Negotiation->supplier_telephone = (!empty($supplier_telephone)) ? $supplier_telephone : "";
                $Negotiation->supplier_email = (!empty($supplier_email)) ? $supplier_email : "";
                $Negotiation->supplier_city = (!empty($supplier_city)) ? $supplier_city : "";
                $Negotiation->supplier_state = (!empty($supplier_state)) ? $supplier_state : "";
                $Negotiation->shipping_amount = (!empty($shipping_amount)) ? \Str::currency($shipping_amount,'us') : "0.00";
                $Negotiation->date_expiration = (!empty($date_expiration)) ? \Carbon\Carbon::createFromFormat('d/m/Y', $date_expiration)->format('Y-m-d') : "";
                $Negotiation->total_quantity = "0.00";
                $Negotiation->total_amount = "0.00";
                $Negotiation->observations = (!empty($observations)) ? $observations : "";
                $Negotiation = $NegotiationRepository->save($Negotiation); 
                //Upload
                if($request->hasFile('negotiation_upload')) {
                    $extension = $request->file('negotiation_upload')->getClientOriginalExtension();
                    $fileNameToStore = "negotiation_upload_".$Negotiation->id.'.'.$extension;
                    $pathToFile = $request->file('negotiation_upload')->storeAs('public/negotiation', $fileNameToStore);
                    if(!empty($fileNameToStore) && !empty($pathToFile)) {
                        $Negotiation->negotiation_upload = $fileNameToStore;
                        $Negotiation = $NegotiationRepository->save($Negotiation);
                    }          
                }
                //Prevision
                if(intval($number_prevision) > 0) {                    
                    $total_quantity = 0;
                    $total_amount = 0;
                    for($i=0; $i < intval($number_prevision); $i++) {
                        $prevision_description = (!empty($prev_description[$i])) ? $prev_description[$i] : "";
                        $prevision_quantity = (!empty($prev_quantity[$i])) ? $prev_quantity[$i] : "";
                        $prevision_amount = (!empty($prev_amount[$i])) ? $prev_amount[$i] : "";
                        $prevision_quantity = \Str::currency($prevision_quantity,'us');
                        $prevision_amount = \Str::currency($prevision_amount,'us');
                        if(!empty($prevision_description)) {
                            $NegotiationPrevision = new NegotiationPrevision();
                            $NegotiationPrevision->negotiation_id = $Negotiation->id;
                            $NegotiationPrevision->description = $prevision_description;
                            $NegotiationPrevision->quantity = $prevision_quantity;
                            $NegotiationPrevision->amount = $prevision_amount;
                            $NegotiationRepository->save($NegotiationPrevision);
                            $total_quantity+= $prevision_quantity;
                            $total_amount+= ($prevision_quantity * $prevision_amount);
                        }
                    }     
                    //Total
                    $Negotiation->total_quantity = (!empty($total_quantity)) ? $total_quantity : "0.00";
                    $Negotiation->total_amount = (!empty($total_amount)) ? $total_amount : "0.00";
                    $Negotiation = $NegotiationRepository->save($Negotiation);        
                }     
                //Response
                $parameters = array();
                $parameters['message'] = $this->getMessage('created');
                $parameters['route'] = $this->route;
                $parameters['research_parameters'] = null;
                $View = View::make($this->getView('response'), $parameters)->render();
                break;
            case 'edit':
                $Negotiation = new Negotiation();
                $NegotiationRepository = new NegotiationRepository();
                $Negotiation = $NegotiationRepository->findById($negotiation_id);
                $Negotiation->supplier_id = (!empty($supplier_id)) ? $supplier_id : "";
                $Negotiation->supplier_name = (!empty($supplier_name)) ? $supplier_name : "";
                $Negotiation->supplier_contact = (!empty($supplier_contact)) ? $supplier_contact : "";
                $Negotiation->supplier_telephone = (!empty($supplier_telephone)) ? $supplier_telephone : "";
                $Negotiation->supplier_email = (!empty($supplier_email)) ? $supplier_email : "";
                $Negotiation->supplier_city = (!empty($supplier_city)) ? $supplier_city : "";
                $Negotiation->supplier_state = (!empty($supplier_state)) ? $supplier_state : "";
                $Negotiation->date_expiration = (!empty($date_expiration)) ? \Carbon\Carbon::createFromFormat('d/m/Y', $date_expiration)->format('Y-m-d') : "";
                $Negotiation->shipping_amount = (!empty($shipping_amount)) ? \Str::currency($shipping_amount,'us') : "0.00";
                $Negotiation->observations = (!empty($observations)) ? $observations : "";
                $Negotiation = $NegotiationRepository->save($Negotiation);  
                //Upload
                if($request->hasFile('negotiation_upload')) {
                    $extension = $request->file('negotiation_upload')->getClientOriginalExtension();
                    $fileNameToStore = "negotiation_upload_".$Negotiation->id.'.'.$extension;
                    $pathToFile = $request->file('negotiation_upload')->storeAs('public/negotiation', $fileNameToStore);
                    if(!empty($fileNameToStore) && !empty($pathToFile)) {
                        $Negotiation->negotiation_upload = $fileNameToStore;
                        $Negotiation = $NegotiationRepository->save($Negotiation);
                    }          
                } 
                //Prevision
                if(intval($number_prevision) > 0) {                    
                    $NegotiationPrevision = new NegotiationPrevision(); 
                    $list = $NegotiationPrevision->select('*')->where([['negotiation_id','=',$Negotiation->id]])->get();
                    foreach($list as $i => $v) {
                        $element = $NegotiationPrevision->find($v->id);
                        $NegotiationRepository->delete($element);
                    }
                    $total_quantity = 0;
                    $total_amount = 0;
                    for($i=0; $i < intval($number_prevision); $i++) {
                        $prevision_description = (!empty($prev_description[$i])) ? $prev_description[$i] : "";
                        $prevision_quantity = (!empty($prev_quantity[$i])) ? $prev_quantity[$i] : "";
                        $prevision_amount = (!empty($prev_amount[$i])) ? $prev_amount[$i] : "";
                        $prevision_quantity = \Str::currency($prevision_quantity,'us');
                        $prevision_amount = \Str::currency($prevision_amount,'us');
                        if(!empty($prevision_description)) {
                            $NegotiationPrevision = new NegotiationPrevision();
                            $NegotiationPrevision->negotiation_id = $Negotiation->id;
                            $NegotiationPrevision->description = $prevision_description;
                            $NegotiationPrevision->quantity = $prevision_quantity;
                            $NegotiationPrevision->amount = $prevision_amount;
                            $NegotiationRepository->save($NegotiationPrevision);
                            $total_quantity+= $prevision_quantity;
                            $total_amount+= ($prevision_quantity * $prevision_amount);
                        }
                    }    
                    //Total
                    $Negotiation->total_quantity = (!empty($total_quantity)) ? $total_quantity : "0.00";
                    $Negotiation->total_amount = (!empty($total_amount)) ? $total_amount : "0.00";
                    $Negotiation = $NegotiationRepository->save($Negotiation);     
                }    
                //Response
                $parameters = array();
                $parameters['message'] = $this->getMessage('edited');
                $parameters['route'] = $this->route;
                $parameters['research_parameters'] = (!empty($request->session()->get('research_parameters'))) ? $request->session()->get('research_parameters') : "";
                $View = View::make($this->getView('response'), $parameters)->render();
                break;
        }
        return view('layouts/app',array('View' => $View));
    }
}