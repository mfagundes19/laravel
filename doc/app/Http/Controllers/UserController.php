<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

use App\Repositories\UserRepository;
use App\Models\User;

//use Spatie\Activitylog\Models\Activity;

class UserController extends Controller
{
    
    /**
     * Display a listing of the resource
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        if(Auth::user()->hasPermission($this->route->module,$this->route->action))
        {
            $UserRepository = new UserRepository();
            $parameters = array();
            $parameters = $request->except('_token');
            $research_parameters = $request->except('_token','refresh_route');
            $request->session()->put('research_parameters', $research_parameters);
            $parameters['parameters'] = $parameters;
            $parameters['list'] = $UserRepository->findBy($parameters, ['id ASC'], 20, 10);
            $parameters['route'] = $this->route;
            $View = View::make($this->getView(), $parameters)->render();
        }
        else
        {
            $View = View::make('errors/403',[])->render();
        }
        return (isset($parameters['refresh_route'])) ? ($View) : view('layouts/app',array('View' => $View));
    }


    /**
     * Verify if email is registered how user in database
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exists(Request $request)
    {
        $parameters = $request->except('_token');
        $UserRepository = new UserRepository();
        return json_encode($UserRepository->exists($parameters),\JSON_UNESCAPED_UNICODE);
    }


    /**
     * Show the form for creating a new resource
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {        
        if(Auth::user()->hasPermission($this->route->module,$this->route->action))
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
            $View = View::make($this->getView(), $parameters)->render();
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
     * @param  \Integer $user_id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $user_id)
    {
        if(Auth::user()->hasPermission($this->route->module,$this->route->action))
        {
            $parameters = array();
            $parameters = $request->except('_token');
            $parameters['user_id'] = (isset($parameters['role_id'])) ? ($parameters['role_id']) : $user_id; 
            $parameters['name'] = (isset($parameters['name'])) ? ($parameters['name']) : ""; 
            $parameters['module_view'] = (isset($parameters['module_view'])) ? ($parameters['module_view']) : [];
            $parameters['module_create'] = (isset($parameters['module_create'])) ? ($parameters['module_create']) : [];
            $parameters['module_edit'] = (isset($parameters['module_edit'])) ? ($parameters['module_edit']) : [];
            $parameters['module_delete'] = (isset($parameters['module_delete'])) ? ($parameters['module_delete']) : [];
            $parameters['module_extra'] = (isset($parameters['module_extra'])) ? ($parameters['module_extra']) : [];
            if(isset($user_id) && !empty($user_id)) 
            {               
                $UserRepository = new UserRepository();
                $User = $UserRepository->findById($user_id);
                foreach($User->toArray() as $key => $value) 
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
     * Show the form for editing the specified resource
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Integer $supplier_id
     * @return \Illuminate\Http\Response
     */
    public function profile(Request $request)
    {
        $parameters = array();
        $parameters = $request->except('_token');
        $parameters['user_id'] = (isset($parameters['user_id'])) ? ($parameters['user_id']) : Auth::user()->id; 
        $parameters['name'] = (isset($parameters['name'])) ? ($parameters['name']) : ""; 
        $parameters['module_view'] = (isset($parameters['module_view'])) ? ($parameters['module_view']) : [];
        $parameters['module_create'] = (isset($parameters['module_create'])) ? ($parameters['module_create']) : [];
        $parameters['module_edit'] = (isset($parameters['module_edit'])) ? ($parameters['module_edit']) : [];
        $parameters['module_delete'] = (isset($parameters['module_delete'])) ? ($parameters['module_delete']) : [];
        $parameters['module_extra'] = (isset($parameters['module_extra'])) ? ($parameters['module_extra']) : [];
        if(isset($parameters['user_id']) && !empty($parameters['user_id'])) 
        {               
            $UserRepository = new UserRepository();
            $User = $UserRepository->findById($parameters['user_id']);
            foreach($User->toArray() as $key => $value) 
            {
                $parameters[$key] = (!empty($parameters[$key])) ? $parameters[$key] : $value;
            }
        }     
        $parameters['route'] = $this->route;   
        $parameters['research_parameters'] = (!empty($request->session()->get('research_parameters'))) ? \Str::toURL($request->session()->get('research_parameters')) : "";
        $View = View::make($this->getView(), $parameters)->render();
        return view('layouts/app',array('View' => $View));
    }


    /**
     * Remove\delete resource of storage
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Integer $user_id 
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $user_id)
    {
        $UserRepository = new UserRepository();
        if(isset($user_id) && !empty($user_id)) 
        {
            $User = $UserRepository->findById($user_id);
            $User->active = false;
            $UserRepository->save($User);
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
     * Update password of resource
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function forget(Request $request) 
    {
        $post_data = $request->except('_token');
        foreach($post_data as $key => $value)
        {
            $$key = $value;
        }
        if(!empty($email) && !empty($password))
        {
            $UserRepository = new UserRepository();
            $list = $UserRepository->findOneBy(array('email','ILIKE', '%'.$email.'%'));
            foreach($list as $k => $User) {
                if($password)
                {
                    $User->password = bcrypt($password);
                }
                $User = $UserRepository->save($User);
            }
        }
        return view('auth/forgot-message',array('message' => 'Senha Alterada com sucesso!'));
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
        switch($procedure)
        {
            case 'create':
                $User = new User();
                $UserRepository = new UserRepository();
                $User->role_id = (!empty($role_id)) ? $role_id : null;
                $User->name = (!empty($name)) ? $name : null;
                $User->email = (!empty($email)) ? $email : null;
                if($password)
                {
                    $User->password = bcrypt($password);
                }
                $User = $UserRepository->save($User);
                //Response
                $parameters = array();
                $parameters['message'] = $this->getMessage('created');
                $parameters['route'] = $this->route;
                $parameters['research_parameters'] = null;
                $View = View::make($this->getView('response'),$parameters)->render();
            break;
            case 'edit':
                $User = new User();
                $UserRepository = new UserRepository();
                $User = $UserRepository->findById($user_id);
                $User->role_id = (!empty($role_id)) ? $role_id : null;
                $User->name = (!empty($name)) ? $name : null;
                $User->email = (!empty($email)) ? $email : null;
                if($password)
                {
                    $User->password = bcrypt($password);
                }
                $User = $UserRepository->save($User);
                //Response
                $parameters = array();
                $parameters['message'] = $this->getMessage('edited');
                $parameters['route'] = $this->route;
                $parameters['research_parameters'] = (!empty($request->session()->get('research_parameters'))) ? \Str::toURL($request->session()->get('research_parameters')) : "";
                $View = View::make($this->getView('response'),$parameters)->render();
            break;
            case 'profile':   //Profile
                $User = new User();
                $UserRepository = new UserRepository();
                $User = $UserRepository->findById($user_id);
                $User->name = (!empty($name)) ? $name : null;
                $User->email = (!empty($email)) ? $email : null;
                if($password)
                {
                    $User->password = bcrypt($password);
                }
                //Upload
                if($request->hasFile('user_photo'))
                {
                    $extension = $request->file('user_photo')->getClientOriginalExtension();
                    $fileNameToStore = "user_photo_".$user_id.'.'.$extension;
                    $path = $request->file('user_photo')->storeAs('public/users', $fileNameToStore);
                    if(!empty($path))
                    {
                        $User->profile_photo_path = $fileNameToStore;
                    }                    
                } 
                else 
                {
                    $fileNameToStore = 'public\users\no-image.jpg';
                    $User->profile_photo_path = $fileNameToStore;
                }
                $User = $UserRepository->save($User);
                //Response
                $parameters = array();
                $parameters['message'] = $this->getMessage('edited');
                $parameters['route'] = $this->route;
                $parameters['research_parameters'] = (!empty($request->session()->get('research_parameters'))) ? \Str::toURL($request->session()->get('research_parameters')) : "";
                $View = View::make($this->getView('response_profile'),$parameters)->render();
            break;
        }
        return view('layouts/app',array('View' => $View));
    }
}//end class
