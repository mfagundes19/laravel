<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Repositories\RoleRepository;
use App\Models\Role;
use App\Models\RolePermission;

class RoleController extends Controller
{
    
    /**
     * Display a listing of the resource
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $RoleRepository = new RoleRepository();
        $parameters = array();
        $parameters = $request->except('_token');
        $research_parameters = $request->except('_token','refresh_route');
        $request->session()->put('research_parameters', $research_parameters);
        $parameters['research_parameters'] = $research_parameters;
            $parameters['parameters'] = $parameters;
        $parameters['list'] = $RoleRepository->findBy($parameters, ['id ASC'], 20, 10);
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
        $parameters = array();
        $parameters = $request->except('_token');
        $parameters['role_id'] = (isset($parameters['role_id'])) ? ($parameters['role_id']) : ""; 
        $parameters['name'] = (isset($parameters['name'])) ? ($parameters['name']) : ""; 
        $parameters['module_view'] = (isset($parameters['module_view'])) ? ($parameters['module_view']) : [];
        $parameters['module_create'] = (isset($parameters['module_create'])) ? ($parameters['module_create']) : [];
        $parameters['module_edit'] = (isset($parameters['module_edit'])) ? ($parameters['module_edit']) : [];
        $parameters['module_delete'] = (isset($parameters['module_delete'])) ? ($parameters['module_delete']) : [];
        $parameters['module_extra'] = (isset($parameters['module_extra'])) ? ($parameters['module_extra']) : [];
        $parameters['route'] = $this->route;
        $View = View::make($this->getView(),$parameters)->render();
        return (isset($parameters['refresh_route'])) ? ($View) : view('layouts/app',array('View' => $View));
    }


    /**
     * Show the form for editing the specified resource
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Integer $role_id
     * @return \Illuminate\Http\Response
     */
    public function edit($role_id, Request $request)
    {
        $parameters = array();
        $parameters = $request->except('_token');
        $parameters['role_id'] = (isset($parameters['role_id'])) ? ($parameters['role_id']) : $role_id; 
        $parameters['name'] = (isset($parameters['name'])) ? ($parameters['name']) : ""; 
        $parameters['module_view'] = (isset($parameters['module_view'])) ? ($parameters['module_view']) : [];
        $parameters['module_create'] = (isset($parameters['module_create'])) ? ($parameters['module_create']) : [];
        $parameters['module_edit'] = (isset($parameters['module_edit'])) ? ($parameters['module_edit']) : [];
        $parameters['module_delete'] = (isset($parameters['module_delete'])) ? ($parameters['module_delete']) : [];
        $parameters['module_extra'] = (isset($parameters['module_extra'])) ? ($parameters['module_extra']) : [];
        if(isset($role_id) && !empty($role_id)) 
        {               
            $RoleRepository = new RoleRepository();
            $Role = $RoleRepository->findById($role_id);
            foreach($Role->toArray() as $key => $value) 
            {
                $parameters[$key] = (!empty($parameters[$key])) ? $parameters[$key] : $value;
            }
            foreach (\App\Models\Module::all() as $key => $element)
            {
                $permissions = $RoleRepository->loadPermission($role_id, $element->id);                
                $parameters['module_view'][$key] = (isset($permissions['allow_view'])) ? ($permissions['allow_view'])  : "0";
                $parameters['module_create'][$key] = (isset($permissions['allow_create'])) ? ($permissions['allow_create'])  : "0"; 
                $parameters['module_edit'][$key] = (isset($permissions['allow_edit'])) ? ($permissions['allow_edit'])  : "0";
                $parameters['module_delete'][$key] = (isset($permissions['allow_delete'])) ? ($permissions['allow_delete'])  : "0"; 
                $parameters['module_extra'][$key] = (isset($permissions['allow_extra'])) ? ($permissions['allow_extra'])  : "0";
            }
        }        
        $parameters['research_parameters'] = (!empty($request->session()->get('research_parameters'))) ? \Str::toURL($request->session()->get('research_parameters')) : "";
        $parameters['route'] = $this->route;
        $View = View::make($this->getView(),$parameters)->render();
        return (isset($parameters['refresh_route'])) ? ($View) : view('layouts/app',array('View' => $View));
    }


    /**
     * Remove\delete resource of storage
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Integer $role_id 
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $role_id)
    {
        $RoleRepository = new RoleRepository();
        if(isset($role_id) && !empty($role_id)) 
        {
            $Role = $RoleRepository->findById($role_id);
            $Role->active = false;
            $RoleRepository->save($Role);
            $RolePermission = new \App\Models\RolePermission(); 
            $list = $RolePermission->select('*')->where('role_id','=',$role_id)->get();
            foreach($list as $element) {
                $Permission = $RolePermission->find($element->id);
                $Permission->active = false;
                $RoleRepository->save($Permission);
            }
        }
        //Response
        $parameters = array();
        $parameters['message'] = $this->getMessage('deleted');
        $parameters['route'] = $this->route;
        $parameters['research_parameters'] = (!empty($request->session()->get('research_parameters'))) ? \Str::toURL($request->session()->get('research_parameters')) : "";
        $View = View::make($this->getView('response'), $parameters)->render();
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
            case 'create':   //Create
                //Role
                $Role = new Role();
                $RoleRepository = new RoleRepository();
                $Role->name = (!empty($name)) ? $name : "";
                $Role = $RoleRepository->save($Role);
                $role_id = $Role->id;
                //Permissions
                for($i=0; $i < count($module_id); $i++)
                {
                    $module_id[$i] = (isset($module_id[$i])) ? $module_id[$i] : 0;
                    $module_view[$i] = (isset($module_view[$i])) ? true : false;
                    $module_create[$i] = (isset($module_create[$i]) && !empty($module_create[$i])) ? 'true' : 'false';
                    $module_edit[$i] = (isset($module_edit[$i])) ? true : false;
                    $module_delete[$i] = (isset($module_delete[$i])) ? true : false;
                    $module_extra[$i] = (isset($module_extra[$i])) ? true : false;
                    $module_master[$i] = (isset($module_master[$i])) ? true : false;
                    $RolePermission = new RolePermission();
                    $RolePermission->role_id = $role_id;
                    $RolePermission->module_id = $module_id[$i];
                    $RolePermission->allow_view = $module_view[$i];
                    $RolePermission->allow_create = $module_create[$i];
                    $RolePermission->allow_edit = $module_edit[$i];
                    $RolePermission->allow_delete = $module_delete[$i];
                    $RolePermission->allow_extra = $module_extra[$i];
                    $RolePermission->allow_master = $module_master[$i];
                    $RolePermission = $RoleRepository->insertPermission($RolePermission);
                }
                //Response
                $parameters = array();
                $parameters['message'] = $this->getMessage('created');
                $parameters['route'] = $this->route;
                $parameters['research_parameters'] = null;
            break;
            case 'edit':   //Edit
                //Role
                $Role = new Role();
                $RoleRepository = new RoleRepository();
                $Role = $RoleRepository->findById($role_id);
                $Role->name = (!empty($name)) ? $name : "";
                $Role = $RoleRepository->save($Role);
                //Permissions
                $RoleRepository->removePermission($role_id);
                for($i=0; $i < count($module_id); $i++)
                {
                    $module_id[$i] = (isset($module_id[$i])) ? $module_id[$i] : 0;
                    $module_view[$i] = (isset($module_view[$i])) ? true : false;
                    $module_create[$i] = (isset($module_create[$i]) && !empty($module_create[$i])) ? 'true' : 'false';
                    $module_edit[$i] = (isset($module_edit[$i])) ? true : false;
                    $module_delete[$i] = (isset($module_delete[$i])) ? true : false;
                    $module_extra[$i] = (isset($module_extra[$i])) ? true : false;
                    $module_master[$i] = (isset($module_master[$i])) ? true : false;
                    $RolePermission = new RolePermission();
                    $RolePermission->role_id = $role_id;
                    $RolePermission->module_id = $module_id[$i];
                    $RolePermission->allow_view = $module_view[$i];
                    $RolePermission->allow_create = $module_create[$i];
                    $RolePermission->allow_edit = $module_edit[$i];
                    $RolePermission->allow_delete = $module_delete[$i];
                    $RolePermission->allow_extra = $module_extra[$i];
                    $RolePermission->allow_master = $module_master[$i];
                    $RolePermission = $RoleRepository->insertPermission($RolePermission);
                }
                //Response
                $parameters = array();
                $parameters['message'] = $this->getMessage('edited');
                $parameters['route'] = $this->route;
                $parameters['research_parameters'] = (!empty($request->session()->get('research_parameters'))) ? \Str::toURL($request->session()->get('research_parameters')) : "";
            break;
        }
        $View = View::make($this->getView('response'), $parameters)->render();
        return view('layouts/app',array('View' => $View));
    }
}//end class
