<?php

namespace App\Http\Controllers\Imports;

use App\Http\Controllers\Controller;
use App\Imports\GoogleImportItems;

class GoogleImportItensController extends Controller
{

    public function import()
    {
        (new GoogleImportItems)->import(storage_path('app/public/import/15/teste.csv'), null, \Maatwebsite\Excel\Excel::CSV);
    }

}
