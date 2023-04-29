<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\ShippingCompany;
use App\Repositories\ShippingCompanyRepository;

class ShippingCompanyController extends Controller
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
            $ShippingCompanyRepository = new ShippingCompanyRepository();
            $parameters = array();
            $parameters = $request->except('_token');
            $research_parameters = $request->except('_token','refresh_route');
            $request->session()->put('research_parameters', $research_parameters);
            $parameters['research_parameters'] = $research_parameters;
            $parameters['parameters'] = $parameters;
            $parameters['list'] = $ShippingCompanyRepository->findBy($parameters, ['id ASC'], 20, 10);
            $parameters['route'] = $this->route;
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
            $parameters['registration_type_id'] = (isset($parameters['registration_type_id'])) ? ($parameters['registration_type_id']) : "2"; 
            $parameters['name'] = (isset($parameters['name'])) ? ($parameters['name']) : ""; 
            $parameters['cpf'] = (isset($parameters['cpf'])) ? ($parameters['cpf']) : ""; 
            $parameters['email'] = (isset($parameters['email'])) ? ($parameters['email']) : ""; 
            $parameters['email_secundary'] = (isset($parameters['email_secundary'])) ? ($parameters['email_secundary']) : ""; 
            $parameters['telephone'] = (isset($parameters['telephone'])) ? ($parameters['telephone']) : ""; 
            $parameters['telephone_secundary'] = (isset($parameters['telephone_secundary'])) ? ($parameters['telephone_secundary']) : "";
            $parameters['zipcode'] = (isset($parameters['zipcode'])) ? ($parameters['zipcode']) : ""; 
            $parameters['address'] = (isset($parameters['address'])) ? ($parameters['address']) : ""; 
            $parameters['number'] = (isset($parameters['number'])) ? ($parameters['number']) : "";
            $parameters['complement'] = (isset($parameters['complement'])) ? ($parameters['complement']) : "";
            $parameters['destrict'] = (isset($parameters['destrict'])) ? ($parameters['destrict']) : ""; 
            $parameters['city'] = (isset($parameters['city'])) ? ($parameters['city']) : ""; 
            $parameters['state'] = (isset($parameters['state'])) ? ($parameters['state']) : "RS"; 
            $parameters['observations'] = (isset($parameters['observations'])) ? ($parameters['observations']) : ""; 
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
     * @param  \Integer $shipping_company_id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $shipping_company_id = null)
    {        
        if(Auth::user()->hasPermission($this->route->module,$this->route->action)) {
            $parameters = array();
            $parameters = $request->except('_token');
            $parameters['shipping_company_id'] = (isset($parameters['shipping_company_id'])) ? ($parameters['shipping_company_id']) : $shipping_company_id; 
            $parameters['registration_type_id'] = (isset($parameters['registration_type_id'])) ? ($parameters['registration_type_id']) : "";
            $parameters['name'] = (isset($parameters['name'])) ? ($parameters['name']) : ""; 
            $parameters['cpf'] = (isset($parameters['cpf'])) ? ($parameters['cpf']) : ""; 
            $parameters['email'] = (isset($parameters['email'])) ? ($parameters['email']) : ""; 
            $parameters['email_secundary'] = (isset($parameters['email_secundary'])) ? ($parameters['email_secundary']) : ""; 
            $parameters['telephone'] = (isset($parameters['telephone'])) ? ($parameters['telephone']) : ""; 
            $parameters['telephone_secundary'] = (isset($parameters['telephone_secundary'])) ? ($parameters['telephone_secundary']) : "";
            $parameters['zipcode'] = (isset($parameters['zipcode'])) ? ($parameters['zipcode']) : ""; 
            $parameters['address'] = (isset($parameters['address'])) ? ($parameters['address']) : ""; 
            $parameters['number'] = (isset($parameters['number'])) ? ($parameters['number']) : "";
            $parameters['complement'] = (isset($parameters['complement'])) ? ($parameters['complement']) : "";
            $parameters['destrict'] = (isset($parameters['destrict'])) ? ($parameters['destrict']) : ""; 
            $parameters['city'] = (isset($parameters['city'])) ? ($parameters['city']) : ""; 
            $parameters['state'] = (isset($parameters['state'])) ? ($parameters['state']) : "RS"; 
            $parameters['observations'] = (isset($parameters['observations'])) ? ($parameters['observations']) : "";             
            $parameters['route'] = $this->route;
            if(isset($shipping_company_id) && !empty($shipping_company_id)) {                                               
                $ShippingCompanyRepository = new ShippingCompanyRepository();
                $ShippingCompany = $ShippingCompanyRepository->findById($shipping_company_id);
                foreach($ShippingCompany->toArray() as $key => $value) {
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
     * @param  \Integer $shipping_company_id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $shipping_company_id)
    {        
        if(Auth::user()->hasPermission($this->route->module, $this->route->action)) {  
            $ShippingCompanyRepository = new ShippingCompanyRepository();
            if(isset($shipping_company_id) && !empty($shipping_company_id)) {
                $ShippingCompany = $ShippingCompanyRepository->findById($shipping_company_id);
                $ShippingCompany->active = false;
                $ShippingCompanyRepository->save($ShippingCompany);
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
        foreach($post_data as $key => $value)
        {
            $$key = $value;
        }

        switch($procedure) {
            case 'create':
                $ShippingCompany = new ShippingCompany();
                $ShippingCompanyRepository = new ShippingCompanyRepository();
                $ShippingCompany->registration_type_id = (!empty($registration_type_id)) ? $registration_type_id : "";
                $ShippingCompany->document = (!empty($document)) ? $document : "";
                $ShippingCompany->company = (!empty($company)) ? mb_convert_case($company, MB_CASE_UPPER, 'UTF-8') : "";
                $ShippingCompany->name = (!empty($name)) ? mb_convert_case($name, MB_CASE_UPPER, 'UTF-8') : "";
                $ShippingCompany->email = (!empty($email)) ? $email : "";
                $ShippingCompany->email_secundary = (!empty($email_secundary)) ? $email_secundary : "";
                $ShippingCompany->telephone = (!empty($telephone)) ? $telephone : "";
                $ShippingCompany->telephone_secundary = (!empty($telephone_secundary)) ? $telephone_secundary : "";
                $ShippingCompany->zipcode = (!empty($zipcode)) ? $zipcode : "";
                $ShippingCompany->state = (!empty($state)) ? $state : "";
                $ShippingCompany->address = (!empty($address)) ? $address : "";
                $ShippingCompany->number = (!empty($number)) ? $number : "";
                $ShippingCompany->complement = (!empty($complement)) ? $complement : "";
                $ShippingCompany->district = (!empty($district)) ? $district : "";
                $ShippingCompany->city = (!empty($city)) ? $city : "";
                $ShippingCompany->payment_information = (!empty($payment_information)) ? $payment_information : "";
                $ShippingCompany->observations = (!empty($observations)) ? $observations : "";
                $ShippingCompany = $ShippingCompanyRepository->save($ShippingCompany);
                //Response
                $parameters = array();
                $parameters['message'] = $this->getMessage('created');
                $parameters['route'] = $this->route;
                $parameters['research_parameters'] = null;
                $View = View::make($this->getView('response'), $parameters)->render();
                break;
            case 'edit':
                $ShippingCompany = new ShippingCompany();
                $ShippingCompanyRepository = new ShippingCompanyRepository();
                $ShippingCompany = $ShippingCompanyRepository->findById($shipping_company_id);
                $ShippingCompany->registration_type_id = (!empty($registration_type_id)) ? $registration_type_id : "";
                $ShippingCompany->document = (!empty($document)) ? $document : "";
                $ShippingCompany->company = (!empty($company)) ? mb_convert_case($company, MB_CASE_UPPER, 'UTF-8') : "";
                $ShippingCompany->name = (!empty($name)) ? mb_convert_case($name, MB_CASE_UPPER, 'UTF-8') : "";
                $ShippingCompany->email = (!empty($email)) ? $email : "";
                $ShippingCompany->email_secundary = (!empty($email_secundary)) ? $email_secundary : "";
                $ShippingCompany->telephone = (!empty($telephone)) ? $telephone : "";
                $ShippingCompany->telephone_secundary = (!empty($telephone_secundary)) ? $telephone_secundary : "";
                $ShippingCompany->zipcode = (!empty($zipcode)) ? $zipcode : "";
                $ShippingCompany->state = (!empty($state)) ? $state : "";
                $ShippingCompany->address = (!empty($address)) ? $address : "";
                $ShippingCompany->number = (!empty($number)) ? $number : "";
                $ShippingCompany->complement = (!empty($complement)) ? $complement : "";
                $ShippingCompany->district = (!empty($district)) ? $district : "";
                $ShippingCompany->city = (!empty($city)) ? $city : "";
                $ShippingCompany->payment_information = (!empty($payment_information)) ? $payment_information : "";
                $ShippingCompany->observations = (!empty($observations)) ? $observations : "";
                $ShippingCompany = $ShippingCompanyRepository->save($ShippingCompany);
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
