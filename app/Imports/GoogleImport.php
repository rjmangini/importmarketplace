<?php

namespace App\Imports;

// use app\Imports\ImportConstants;

use App\Models\Api\Import\Sale;
use App\Models\Api\Import\SaleItems;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GoogleImport implements ToModel, WithHeadingRow
{
    use Importable;

    public function model(array $row)
    {
        $customer = [
            'id' => null,
            'fullname' => '',
            'email' => '',
            'gender' => '',
            'birthday' => '0000-00-00',
            'zipcode' => '',
            'country' => 'BR',
            'state' => '',
        ];

        $ebook = ImportHelpers::getEbookbyISBN($row['primary_isbn']);

        if (ImportHelpers::saleAlreadyExists($this->getTransactionKey($row['id']))) {
            return [
                'status' => false,
                'message' => "A Venda GOOGLE_{$this->getTransactionKey($row['id'])} já está no sistema no sistema!"
            ];    
        } else {
            $sale = new Sale([
                "store_id" => ImportConstants::GOOGLE_ID,
                "transaction_key" => $this->getTransactionKey($row['id']),
                "date" => Carbon::createFromFormat('d/m/Y', $row['transaction_date'])->format('Y-m-d H:i:s'),
                "customer_identification_number" => $customer['id'],
                "customer_fullname" => $customer['fullname'],
                "customer_email" => $customer['email'],
                "customer_gender" => $customer['gender'],
                "customer_birthday" => $customer['birthday'],
                "customer_zipcode" => $customer['zipcode'],
                "customer_country" => $customer['country'],
                "customer_state" => $customer['state'],
                "created" => Carbon::now()->format('Y-m-d H:i:s'),
            ]);

            $saleItem = new SaleItems([
                "sale_id" => $sale->id, 
                "ebook_id" => ImportHelpers::getEbookbyISBN($row['isbn_primary']),
                "currency_id" => ImportHelpers::getCurrency($row['list_price_currency'])->id,
                "price" => $row[list_price_tax_inclusive],
                "bm_fee" => 0,
                "store_fee" => 0,
                "tax_fee" => 0,
                "list_price" => 0,
                "retail_price" => 0,
                "tax" => 0,
                "bm_remuneration" => 0,
                "author_remuneration" => 0,
                "imprint_remuneration" => 0,
                "reversed" => 0,
                "payment_id" => 0,
                "original_price" => 0,
            ]);
        }    

        return $sale && $saleItem;
    }

    public function getCsvSettings(): array
    {
        // comma <,> semicolon <;> tab <\t> space < > pipe <|>
        return [
            'delimiter' => "\t"
        ];
    }
 
    // public function batchSize(): int
    // {
    //     return 1000;
    // }

    private function getTransactionKey($id)
    {
        return 'GOOGLE_' . $id;
    }

}
