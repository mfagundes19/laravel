<?php

namespace App\Repositories;

use App\Repositories\Repository;

class ShippingCompanyRepository extends Repository
{
    public function __construct()
    {
        $this->model = new \App\Models\ShippingCompany();
    }

    public function findBy($criteria, $order, $limit = 0, $offset = 0)
    {
        $where = array();
        $where[] = array('id','>','0');
        $where[] = array('active', true);
        if(!empty($criteria['research_search']))
        {
            $where[] = array('name','ILIKE','%'.$criteria['research_search'].'%');
        }
        $columns = ['*'];
        $query = $this->model->select($columns)->where($where)->orderBy('name','ASC')->paginate($limit);
        return $query;
    }

}//end class