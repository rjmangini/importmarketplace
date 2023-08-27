<?php

namespace App\Models\Api\Import;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleItems extends Model
{
    use HasFactory;

    protected $table = "sale_items";
    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $fillable = [
        "sale_id",
        "ebook_id",
        "currency_id",
        "price",
        "bm_fee",
        "store_fee",
        "tax_fee",
        "list_price",
        "retail_price",
        "tax",
        "bm_remuneration",
        "author_remuneration",
        "imprint_remuneration",
        "reversed",
        "payment_id",
        "original_price",
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class, "id", "sale_id");
    }

}
