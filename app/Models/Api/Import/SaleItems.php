<?php

namespace App\Models\Api\Import;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleItems extends Model
{
    use HasFactory;

    protected $table = "sale_items";
    const CREATED_AT = "created";
    const UPDATED_AT = null;

    public function Sale(){
        return $this->hasOne("App\MOdels\Sale", "id", "sale_id");
    }

}
