<?php

namespace App\Repositories;

use App\Repositories\Repository;

class ReceivementRepository extends Repository
{
    public function __construct()
    {
        $this->model = new \App\Models\Receivement();
    }

    public function getReceivementPackpage($receivement_id)
    {
        $ReceivementPackpage = new \App\Models\ReceivementPackpage(); 
        $columns = [
            'receivement_packpage.*',
            'shaving_type.name as shaving_type',
            'container_type.name as container_type'
        ];
        $query = $ReceivementPackpage->select($columns)
            ->join('shaving_type', 'receivement_packpage.shaving_type_id', '=', 'shaving_type.id')
            ->join('container_type', 'receivement_packpage.container_type_id', '=', 'container_type.id')
            ->where([['receivement_id','=',$receivement_id]])
            ->get();
        return $query;
    }

    public function getReceivementUpload($receivement_id)
    {
        $ReceivementUpload = new \App\Models\ReceivementUpload(); 
        $query = $ReceivementUpload->select()->where([['receivement_id','=',$receivement_id]])->get();
        return $query;
    }

    public function findBy($criteria, $order, $limit = 0, $offset = 0)
    {
        $where = array();
        $where[] = array('receivement.id','>','0');
        $where[] = array('receivement.active', true);
        if(!empty($criteria['research_user_id']))
        {
            $where[] = array('receivements.user_id', $criteria['research_user_id']);
        }        
        if(!empty($criteria['research_branch_id']))
        {
            $where[] = array('receipt_plans.branch_id', $criteria['research_branch_id']);
        }
        if(!empty($criteria['research_operation_type_id']))
        {
            $where[] = array('receipt_plans.operation_type_id', $criteria['research_operation_type_id']);
        }
        if(!empty($criteria['research_supplier_id']))
        {
            $where[] = array('receipt_plans.supplier_id', $criteria['research_supplier_id']);
        }        
        if(!empty($criteria['research_search']))
        {
            $where[] = array('responsible','ILIKE','%'.$criteria['research_search'].'%');
        }
        $columns = [
            'receivement.id',
            'supplier.name as supplier',
            'operation_type.name as operation',
            'container_type.name as container_type',
            'branch.name as branch',
            'receivement.date_receivement',
            'receivement.nf_number',
            'receivement.ra_number',
            'receivement.weight_reference',
            'receivement.weight_negotiated',
            'receivement.weight_nf',
            'receivement.weight_received',
            'receivement.weight_difference',
            'receivement.massiness',
            'receivement.massiness_received',
            'receivement.time_discharge',
            'receivement_status.name as status'
        ];
        $query = $this->model->select($columns)
            ->join('operation_type', 'receivement.operation_type_id', '=', 'operation_type.id')
            ->join('supplier', 'receivement.supplier_id', '=', 'supplier.id')
            ->join('branch', 'receivement.branch_id', '=', 'branch.id')
            ->join('container_type', 'receivement.container_type_id', '=', 'container_type.id')
            ->join('receivement_status', 'receivement.receivement_status_id', '=', 'receivement_status.id')
            ->where($where)->paginate($limit);
        return $query;
    }

}//end class