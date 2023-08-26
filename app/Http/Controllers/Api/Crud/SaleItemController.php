<?php

namespace App\Http\Controllers\Api\Crud;

use App\Http\Controllers\ApiController;
use App\Repository\Import\SaleItemRepository;


class SaleItemController extends ApiController
{
    private $repository;

    public function __construct(SaleItemRepository $repository)
    {
        parent::__construct(new SaleItemRepository());
    }
    
    public function destroy($id)
    {
        return false;
    }

}
