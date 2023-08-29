<?php

namespace App\Imports;

// use app\Imports\ImportConstants;

use App\Models\Api\Import\Sale;
use App\Models\Api\Import\SaleItems;
use Carbon\Carbon;
use Exception;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class GoogleImport implements ToModel, WithHeadingRow, WithUpserts, WithChunkReading, WithBatchInserts
{
    use Importable;

    public function model(array $row)
    {
        $customer = [
            'id' => 0,
            'fullname' => '',
            'email' => '',
            'gender' => '',
            'birthday' => '1900-01-01',
            'zipcode' => '',
            'country' => 'BR',
            'state' => '',
        ];
        $date = Carbon::createFromFormat('d/m/Y', $row['transaction_date'])->format('Y-m-d H:i:s');

        $dataSale = [
            "store_id" => ImportConstants::GOOGLE_ID,
            "transaction_key" => $this->getTransactionKey($row['id']),
            "date" => $date,
            "customer_identification_number" => $customer['id'],
            "customer_fullname" => $customer['fullname'],
            "customer_email" => $customer['email'],
            "customer_gender" => $customer['gender'],
            "customer_birthday" => $customer['birthday'],
            "customer_zipcode" => $customer['zipcode'],
            "customer_country" => $customer['country'],
            "customer_state" => $customer['state'],
            "created" => Carbon::now()->format('Y-m-d H:i:s'),
        ];

        return new Sale($dataSale);
    }

    public function uniqueBy()
    {
        return ['store_id', 'transaction_key'];
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
        return 5000;
    }

    public function chunkSize(): int
    {
        return 5000;
    }

    private function getTransactionKey($id)
    {
        return 'GOOGLE_' . $id;
    }

}
