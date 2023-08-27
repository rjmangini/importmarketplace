<?php

namespace App\Imports;

use Illuminate\Support\Facades\DB;

Class ImportHelpers
{
    
    static public function getEbookbyISBN($isbn)
    {
        return DB::table('ebook_file')
            ->where('isbn', $isbn)
            ->first();
    }

    static public function saleAlreadyExists($saleId)
	{
        $sale = DB::table('sale')
            ->where('transaction_key', $saleId)
            ->first();

		return !$sale;
	}

	static public function getStore($store_id)
	{
        return DB::table('company_store')
            ->where('id', $store_id)
            ->first();
	}

    static public function getCurrency($currency)
    {
        return DB::table('currency')
            ->where('code', $currency)
            ->first();
    }

}