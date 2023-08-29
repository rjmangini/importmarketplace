<?php

namespace App\Imports;

use Illuminate\Support\Facades\DB;

class ImportHelpers
{

    public static function getEbookbyISBN(string $isbn)
    {
        return DB::table('ebook_file')
            ->where('isbn', $isbn)
            ->first();
    }

    public static function saleAlreadyExists(string $saleId)
    {
        $sale = DB::table('sale')
            ->where('transaction_key', $saleId)
            ->first();

        return ($sale ? true : false);
    }

    public static function getStore(string $store_id)
    {
        return DB::table('company_store')
            ->where('id', $store_id)
            ->first();
    }

    public static function getCurrency(string $currency)
    {
        return DB::table('currency')
            ->where('code', $currency)
            ->first();
    }

    public static function getSalebyTransactionKey(string $saleId)
    {
        return DB::table('sale')
            ->where('transaction_key', $saleId)
            ->first();
    }

    public static function getBmFee(string $ebookId)
    {
        return DB::table('distribution_distribution')
            ->where('id', $ebookId)
            ->first();
    }

    public static function getTaxFee(string $ebookId)
    {
        return DB::table('distribution_distribution')
            ->where('id', $ebookId)
            ->first();
    }

    public static function getStoreFee(string $ebookId)
    {
        return DB::table('distribution_distribution')
            ->where('id', $ebookId)
            ->first();
    }

    public static function getListPrice(string $ebookId)
    {
        return DB::table('distribution_distribution')
            ->where('id', $ebookId)
            ->first();
    }

    public static function getRetailPrice(string $ebookId)
    {
        return DB::table('distribution_distribution')
            ->where('id', $ebookId)
            ->first();
    }

}
