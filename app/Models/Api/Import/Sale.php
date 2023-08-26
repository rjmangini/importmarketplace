<?php

namespace App\Models\Api\Import;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $table = "sale";
    const CREATED_AT = "created";
    const UPDATED_AT = null;

    public function SaleItems(){
        return $this->hasMany("App\Models\SaleItems", "id", "sale_id");
    }
}
