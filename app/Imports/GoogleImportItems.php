<?php

namespace App\Imports;

use App\Models\Api\Import\SaleItems;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class GoogleImportItems implements ToModel, WithHeadingRow, WithUpserts, WithChunkReading, WithBatchInserts
{
    use Importable;

    public function model(array $row)
    {
        try {
            $today = Carbon::now()->format('Y-m-d');
            $log = Log::build([
                'driver' => 'single',
                'path' => storage_path("logs/imports/google/{$today}.log"),
            ]);
    
            $id = $this->getTransactionKey($row['id']);
            $ebook = ImportHelpers::getEbookbyISBN($row['primary_isbn']);
            $sale = ImportHelpers::getSalebyTransactionKey($id);
            $currency = ImportHelpers::getCurrency($row['list_price_currency']);
            $bmFee =  ImportHelpers::getBmFee($ebook->id);
            $taxFee =  ImportHelpers::getTaxFee($ebook->id);
            $storeFee =  ImportHelpers::getStoreFee($ebook->id);
            $listPrice =  ImportHelpers::getListPrice($ebook->id);
            $retailPrice =  ImportHelpers::getRetailPrice($ebook->id);
    
            if (empty($sale)) {
                $log->error("SALE ID: {$id} não encontrada");
            }
            if (empty($ebook)) {
                $log->error("PRIMARY ISBN: {$row['primary_isbn']} não encontrada");
            }
            if (empty($currency)) {
                $log->warning("CURRENCY: {$row['list_price_currency']} não encontrada, usado BRL (SALE_ID: {$id} ISBN: {$row['primary_isbn']})");
            }
    
            if (!empty($sale) && !empty($ebook)) {
                $dataItem = [
                    "sale_id" => $sale->id,
                    "ebook_id" => $ebook->ebook_id,
                    "currency_id" => (isset($currency->id) ? $currency->id : 1),
                    "price" => 0,
                    "bm_fee" =>   isset($bmFee->bm_fee) ? $bmFee->bm_fee : 0,
                    "store_fee" => isset($storeFee->store_fee) ?  $storeFee->store_fee  : 0,
                    "tax_fee" => isset($taxFee->tax_fee) ? $taxFee->tax_fee : 0,
                    "list_price" => isset($listPrice->list_price) ?  $listPrice->list_price :  0,
                    "retail_price" => isset($retailPrice->retail_price) ? $retailPrice->retail_price : 0,
                    "tax" => 0,
                    "bm_remuneration" => 0,
                    "author_remuneration" => 0,
                    "imprint_remuneration" => 0,
                    "reversed" => 0,
                    "payment_id" => 0,
                    "original_price" => 0,1
                ];
    
                return new SaleItems($dataItem);
            }
        } catch (Exception $e) {
            $log->error("Message: {$e->getMessage()} - File: {$e->getFile()} - Line: {$e->getFile()}");
        }        
    }

    public function uniqueBy()
    {
        return ['sale_id', 'ebook_id', 'currency_id'];
    }

    public function getCsvSettings(): array
    {
        // comma <,> semicolon <;> tab <\t> space < > pipe <|>
        return [
            'input_encoding' => 'UTF-8',
            'delimiter' => "\t"
        ];
    }

    public function batchSize(): int
    {
        return 4000;
    }

    public function chunkSize(): int
    {
        return 4000;
    }

    private function getTransactionKey($id)
    {
        return 'GOOGLE_' . $id;
    }

}
