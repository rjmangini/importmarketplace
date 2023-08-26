<?php

namespace App\Repository\Import;

use App\Models\Api\Import\Sale;
use App\Models\Api\Import\SaleItems;
use App\Repository\ApiRepository;

class SaleItemRepository extends ApiRepository
{
    public function __construct()
    {
        $this->logDatabase = true;
        parent::__construct(new SaleItems());
    }

    public function show($id)
    {
        try {
            $data = SaleItems::where('sale_id', $id)->get();

            if (isset($data)) {
                return json_encode($data);
            }
            return response('Marca não encontrada', 404);
        } catch(Exception $e) {
            return $e;
        }
    }

}
