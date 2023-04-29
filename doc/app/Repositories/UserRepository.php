<?php

namespace App\Repositories;

class UserRepository extends Repository
{
    public function __construct()
    {
        $this->model = new \App\Models\User();
    }

    public function exists($parameters)
    {
        $response = array();
        $where = array();
        if(isset($parameters['seqnr']) && !empty($parameters['seqnr'])) {
            $where[] = ["id", "<>", $parameters['seqnr']];
        }
        $where[] = [$parameters['field'],"=",$parameters['value']];
        $elements = $this->model->select('*')->where($where)->get();
        if(count($elements) > 0) {
            $response['result'] = 'true';
        } else {
            $response['result'] = 'false';
        }
        return $response;
    }
    
    public function findBy($criteria, $order, $limit = 0, $offset = 0)
    {
        $where = array();
        $where[] = array('user.id','>','0');
        $where[] = array('user.active', true);
        if(!empty($criteria['research_search'])) {
            $where[] = array('user.name','ILIKE','%'.$criteria['research_search'].'%');
        }
        $columns = ['user.id','user.name','user.email','role.name as role'];
        return $this->model->select($columns)->join('role', 'user.role_id', '=', 'role.id')->where($where)->paginate($limit);
    }

}//end class