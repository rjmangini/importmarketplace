<?php

namespace App\Http\Controllers\Api\Crud;

use App\Http\Controllers\ApiController;
use App\Repository\Import\SaleRepository;

class SaleController extends ApiController
{
    private $repository;

    public function __construct(SaleRepository $repository)
    {
        parent::__construct(new SaleRepository());
    }

    public function destroy($id)
    {
        return false;
    }

}
