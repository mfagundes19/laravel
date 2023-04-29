<?php

namespace App\Repositories;

interface RepositoryInterface
{
    
    public function findById($id);

    public function findOneBy(array $criteria);

    public function findBy(array $criteria, array $order, $limit = 0);

    public function findAll();
}