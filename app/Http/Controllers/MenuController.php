<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Models\Module;
use App\Models\Menu;
use App\Repositories\MenuRepository;

class MenuController extends Controller
{
    
    /**
     * Display a listing of the resource
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(request $request)
    {
        if(Auth::user()->hasPermission($this->route->module, $this->route->action)) {            
            $MenuRepository = new MenuRepository();
            $parameters = array();
            $parameters = $request->except('_token');
            $research_parameters = $request->except('_token','refresh_route');
            $request->session()->put('research_parameters', $research_parameters);
            $parameters['research_parameters'] = $research_parameters;
            $parameters['parameters'] = $parameters;
            $parameters['list'] = $MenuRepository->findBy($parameters, ['id ASC'], 20, 10);
            $parameters['route'] = $this->route;
            $View = View::make($this->getView(), $parameters)->render();
        } else {
            $View = View::make('errors/403',[])->render();
        }
        return view('layouts/app',array('View' => $View));
    }


    /**
     * Show the form for creating a new resource
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(request $request)
    {
        if(Auth::user()->hasPermission($this->route->module, $this->route->action)) {
            $parameters = array();
            $parameters = $request->except('_token');
            $parameters['menu_id'] = (isset($parameters['menu_id'])) ? ($parameters['menu_id']) : ""; 
            $parameters['name'] = (isset($parameters['name'])) ? ($parameters['name']) : ""; 
            $parameters['link'] = (isset($parameters['link'])) ? ($parameters['link']) : ""; 
            $parameters['module_id'] = (isset($parameters['module_id'])) ? ($parameters['module_id']) : ""; 
            $parameters['nivel'] = (isset($parameters['nivel'])) ? ($parameters['nivel']) : "";
            $parameters['nivel_1_menu_id'] = (isset($parameters['nivel_1_menu_id'])) ? ($parameters['nivel_1_menu_id']) : "";
            $parameters['nivel_2_menu_id'] = (isset($parameters['nivel_2_menu_id'])) ? ($parameters['nivel_2_menu_id']) : "";
            $parameters['route'] = $this->route;
            if(isset($parameters['module_id']) && !empty($parameters['module_id'])) {
                $Module = new Module();
                $Module = $Module->find($parameters['module_id']);
                if(!empty($Module)) {
                    $parameters['name'] = $Module->name;
                    $parameters['link'] = $Module->module;
                }
            }
            $View = View::make($this->getView(), $parameters)->render();
        } else {
            $View = View::make('errors/403',[])->render();
        }
        return (isset($parameters['refresh_route'])) ? ($View) : view('layouts/app',array('View' => $View));
    }


    /**
     * Show the form for editing the specified resource
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Integer $menu_id
     * @return \Illuminate\Http\Response
     */
    public function edit(request $request, $menu_id) 
    {
        if(Auth::user()->hasPermission($this->route->module, $this->route->action)) {
            $parameters = array();
            $parameters = $request->except('_token');
            $parameters['menu_id'] = (isset($parameters['menu_id'])) ? ($parameters['menu_id']) : $menu_id; 
            $parameters['name'] = (isset($parameters['name'])) ? ($parameters['name']) : ""; 
            $parameters['link'] = (isset($parameters['link'])) ? ($parameters['link']) : ""; 
            $parameters['module_id'] = (isset($parameters['module_id'])) ? ($parameters['module_id']) : ""; 
            $parameters['nivel'] = (isset($parameters['nivel'])) ? ($parameters['nivel']) : "";
            $parameters['nivel_1_menu_id'] = (isset($parameters['nivel_1_menu_id'])) ? ($parameters['nivel_1_menu_id']) : "";
            $parameters['nivel_2_menu_id'] = (isset($parameters['nivel_2_menu_id'])) ? ($parameters['nivel_2_menu_id']) : "";
            if(isset($menu_id) && !empty($menu_id)) {            
                $MenuRepository = new MenuRepository();
                $Menu = $MenuRepository->findById($menu_id);
                foreach($Menu->toArray() as $key => $value) {
                    $parameters[$key] = (!empty($parameters[$key])) ? $parameters[$key] : $value;
                }
            }
            if(isset($parameters['module_id']) && !empty($parameters['module_id'])) {
                $Module = new Module();
                $Module = $Module->find($parameters['module_id']);
                if(!empty($Module)) {
                    $parameters['name'] = $Module->name;
                    $parameters['link'] = $Module->module;
                }
            }
            $parameters['research_parameters'] = (!empty($request->session()->get('research_parameters'))) ? \Str::toURL($request->session()->get('research_parameters')) : "";
            $parameters['route'] = $this->route;
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
     * @param  \Integer $menu_id 
     * @return \Illuminate\Http\Response
     */
    public function delete(request $request, $menu_id)
    {
        if(Auth::user()->hasPermission($this->route->module, $this->route->action)) {
            if(isset($menu_id) && !empty($menu_id)) {
                $MenuRepository = new MenuRepository();
                $Menu = $MenuRepository->findById($menu_id);
                $Menu->active = false;
                $MenuRepository->save($Menu);    
            }
            $parameters = array();
            $parameters['message'] = $this->getMessage('deleted');
            $parameters['research_parameters'] = (!empty($request->session()->get('research_parameters'))) ? \Str::toURL($request->session()->get('research_parameters')) : "";
            $parameters['route'] = $this->route;
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
        $parameters = $request->except('_token');
        $post_data = $request->except('_token');
        foreach($post_data as $key => $value) {
            $$key = $value;
        }
        switch($procedure) {
            case 'create':
                $MenuRepository = new MenuRepository();
                $Menu = new Menu();
                $Menu->module_id = (!empty($module_id)) ? $module_id : null;
                $Menu->name = (!empty($name)) ? $name : "";
                $Menu->link = (!empty($link)) ? $link : "";
                $Menu->nivel = (!empty($nivel)) ? $nivel : "";
                $Menu->nivel_1_menu_id = (!empty($nivel_1_menu_id)) ? $nivel_1_menu_id : null;
                $Menu->nivel_2_menu_id = (!empty($nivel_2_menu_id)) ? $nivel_2_menu_id : null;
                $MenuRepository->save($Menu);
                //Response
                $parameters = array();
                $parameters['message'] = $this->getMessage('created');
                $parameters['route'] = $this->route;
                $parameters['research_parameters'] = null;
                $View = View::make($this->getView('response'), $parameters)->render();            
                break;
            case 'edit':
                $MenuRepository = new MenuRepository();
                $Menu = new Menu();
                $Menu = $MenuRepository->findById($menu_id);
                $Menu->module_id = (!empty($module_id)) ? $module_id : null;
                $Menu->name = (!empty($name)) ? $name : "";
                $Menu->link = (!empty($link)) ? $link : "";
                $Menu->nivel = (!empty($nivel)) ? $nivel : "";
                $Menu->nivel_1_menu_id = (!empty($nivel_1_menu_id)) ? $nivel_1_menu_id : null;
                $Menu->nivel_2_menu_id = (!empty($nivel_2_menu_id)) ? $nivel_2_menu_id : null;
                $MenuRepository->save($Menu);
                $Menu->save();
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
