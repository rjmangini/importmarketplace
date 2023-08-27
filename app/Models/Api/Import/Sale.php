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

    protected $fillable = [
        "store_id",
        "transaction_key",
        "date",
        "customer_identification_number",
        "customer_fullname",
        "customer_email",
        "customer_gender",
        "customer_birthday",
        "customer_zipcode",
        "customer_country",
        "customer_state",
        "created",
    ];

    public function saleItem()
    {
        return $this->hasMany(SaleItems::class, "id", "sale_id");
    }
}
