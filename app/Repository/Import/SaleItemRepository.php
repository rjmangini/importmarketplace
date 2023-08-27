<?php

namespace App\Repository\Import;

use App\Models\Api\Import\SaleItems;
use App\Repository\ApiRepository;

class SaleItemRepository extends ApiRepository
{
    public function __construct()
    {
        $this->logDatabase = true;
        parent::__construct(new SaleItems());
    }

}
