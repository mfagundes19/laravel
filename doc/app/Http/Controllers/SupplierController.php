<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\Supplier;
use App\Repositories\SupplierRepository;

class SupplierController extends Controller
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
            $SupplierRepository = new SupplierRepository();
            $parameters = array();
            $parameters = $request->except('_token');
            $parameters['parameters'] = $parameters;
            $research_parameters = $request->except('_token','refresh_route');
            $request->session()->put('research_parameters', $research_parameters);
            $parameters['list'] = $SupplierRepository->findBy($parameters, ['id ASC'], 20, 10);
            $parameters['route'] = $this->route;
            $parameters['research_parameters'] = $parameters;
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
    public function create(Request $request)
    {           
        if(Auth::user()->hasPermission($this->route->module, $this->route->action))
        {
            $parameters = array();
            $parameters = $request->except('_token');
            $parameters['supplier_id'] = (isset($parameters['supplier_id'])) ? ($parameters['supplier_id']) : ""; 
            $parameters['registration_type_id'] = (isset($parameters['registration_type_id'])) ? ($parameters['registration_type_id']) : "2"; 
            $parameters['supplier_category_id'] = (isset($parameters['supplier_category_id'])) ? ($parameters['supplier_category_id']) : ""; 
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
     * @param  \Integer $supplier_id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $supplier_id)
    {        
        if(Auth::user()->hasPermission($this->route->module,$this->route->action))
        {
            $parameters = array();
            $parameters = $request->except('_token');
            $parameters['supplier_id'] = (isset($parameters['supplier_id'])) ? ($parameters['supplier_id']) : $supplier_id; 
            $parameters['registration_type_id'] = (isset($parameters['registration_type_id'])) ? ($parameters['registration_type_id']) : "2"; 
            $parameters['supplier_category_id'] = (isset($parameters['supplier_category_id'])) ? ($parameters['supplier_category_id']) : ""; 
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
            if(isset($supplier_id) && !empty($supplier_id)) 
            {                                               
                $SupplierRepository = new SupplierRepository();
                $Supplier = $SupplierRepository->findById($supplier_id);
                foreach($Supplier->toArray() as $key => $value) 
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
     * @param  \Integer $supplier_id 
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $supplier_id)
    {        
        if(Auth::user()->hasPermission($this->route->module, $this->route->action))
        {  
            $SupplierRepository = new SupplierRepository();
            if(isset($supplier_id) && !empty($supplier_id)) 
            {
                $Supplier = $SupplierRepository->findById($supplier_id);
                $SupplierRepository->delete($Supplier);
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
                $Supplier = new Supplier();
                $SupplierRepository = new SupplierRepository();
                $Supplier->registration_type_id = (!empty($registration_type_id)) ? $registration_type_id : "";
                $Supplier->supplier_category_id = (!empty($supplier_category_id)) ? $supplier_category_id : "";
                $Supplier->document = (!empty($document)) ? $document : "";
                $Supplier->company = (!empty($company)) ? mb_convert_case($company, MB_CASE_UPPER, 'UTF-8') : "";
                $Supplier->name = (!empty($name)) ? mb_convert_case($name, MB_CASE_UPPER, 'UTF-8') : "";
                $Supplier->email = (!empty($email)) ? $email : "";
                $Supplier->email_secundary = (!empty($email_secundary)) ? $email_secundary : "";
                $Supplier->telephone = (!empty($telephone)) ? $telephone : "";
                $Supplier->telephone_secundary = (!empty($telephone_secundary)) ? $telephone_secundary : "";
                $Supplier->zipcode = (!empty($zipcode)) ? $zipcode : "";
                $Supplier->state = (!empty($state)) ? $state : "";
                $Supplier->address = (!empty($address)) ? $address : "";
                $Supplier->number = (!empty($number)) ? $number : "";
                $Supplier->complement = (!empty($complement)) ? $complement : "";
                $Supplier->district = (!empty($district)) ? $district : "";
                $Supplier->city = (!empty($city)) ? $city : "";
                $Supplier->observations = (!empty($observations)) ? $observations : "";
                $Supplier = $SupplierRepository->save($Supplier);
                //Response
                $parameters = array();
                $parameters['message'] = $this->getMessage($procedure);
                $parameters['route'] = $this->route;
                $parameters['research_parameters'] = null;
                $View = View::make($this->getView('response'), $parameters)->render();
            break;
            case '2':   //Edit
                $Supplier = new Supplier();
                $SupplierRepository = new SupplierRepository();
                $Supplier = $SupplierRepository->findById($supplier_id);
                $Supplier->registration_type_id = (!empty($registration_type_id)) ? $registration_type_id : "";
                $Supplier->supplier_category_id = (!empty($supplier_category_id)) ? $supplier_category_id : "";
                $Supplier->document = (!empty($document)) ? $document : "";
                $Supplier->company = (!empty($company)) ? mb_convert_case($company, MB_CASE_UPPER, 'UTF-8') : "";
                $Supplier->name = (!empty($name)) ? mb_convert_case($name, MB_CASE_UPPER, 'UTF-8') : "";
                $Supplier->email = (!empty($email)) ? $email : "";
                $Supplier->email_secundary = (!empty($email_secundary)) ? $email_secundary : "";
                $Supplier->telephone = (!empty($telephone)) ? $telephone : "";
                $Supplier->telephone_secundary = (!empty($telephone_secundary)) ? $telephone_secundary : "";
                $Supplier->zipcode = (!empty($zipcode)) ? $zipcode : "";
                $Supplier->state = (!empty($state)) ? $state : "";
                $Supplier->address = (!empty($address)) ? $address : "";
                $Supplier->number = (!empty($number)) ? $number : "";
                $Supplier->complement = (!empty($complement)) ? $complement : "";
                $Supplier->district = (!empty($district)) ? $district : "";
                $Supplier->city = (!empty($city)) ? $city : "";
                $Supplier->observations = (!empty($observations)) ? $observations : "";
                $Supplier = $SupplierRepository->save($Supplier);
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
