<?php

namespace App\Repositories;

use App\Repositories\Repository;

class NegotiationRepository extends Repository
{
    public function __construct()
    {
        $this->model = new \App\Models\Negotiation();
    }

    public function findBy($criteria, $order, $limit = 0, $offset = 0)
    {
        $where = array();
        $where[] = array('negotiation.id','>','0');
        $where[] = array('negotiation.active', true);
        if(!empty($criteria['research_supplier_id']))
        {
            $where[] = array('negotiation.supplier_id', $criteria['research_supplier_id']);
        }   
        if(!empty($criteria['research_search'])) {
            $where[] = array('supplier_name','ILIKE','%'.$criteria['research_search'].'%');
        }
        $columns = ['negotiation.*','supplier.name as supplier'];
        $query = $this->model->select($columns)
                    ->join('supplier', 'negotiation.supplier_id', '=', 'supplier.id')
                    ->where($where)
                    ->paginate($limit);       
        return $query;
    }

}//end class