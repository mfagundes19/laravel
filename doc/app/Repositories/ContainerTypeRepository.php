<?php

namespace App\Repositories;

use App\Repositories\Repository;

class ContainerTypeRepository extends Repository
{
    public function __construct()
    {
        $this->model = new \App\Models\ContainerType();
    }

    public function findBy($criteria, $order, $limit = 0, $offset = 0)
    {
        $where = array();
        $where[] = array('id','>','0');
        if(!empty($criteria['research_search']))
        {
            $where[] = array('name','ILIKE','%'.$criteria['research_search'].'%');
        }
        $columns = ['*'];
        return $this->model->select($columns)->where($where)->paginate($limit);
    }

}//end class