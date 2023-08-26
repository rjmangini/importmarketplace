<?php

namespace App\Repository\Import;

use App\Models\Api\Import\Payment;
use App\Models\Api\Import\Sale;
use App\Repository\ApiRepository;

class PaymentRepository extends ApiRepository
{
    public function __construct()
    {
        $this->logDatabase = true;
        parent::__construct(new Payment());
    }
}
