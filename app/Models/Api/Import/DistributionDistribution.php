<?php

namespace App\Models\Api\Import;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistributionDistribution extends Model
{
    use HasFactory;

    protected $table = "distribution_distribution";
    const CREATED_AT = "created";
    const UPDATED_AT = null;

    protected $fillable = [
        "ebook_id",
        "store_id",
        "currency",
        "list_price",
        "store_fee",
        "tax_fee",
        "retail_price",
        "bm_fee",
        "distribution_product_availability_id",
        "activated",
        "modified",
        "disabled",
        "disabled_by_store"
    ];

}
