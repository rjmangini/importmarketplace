<?php

namespace App\Http\Controllers\Imports;

use App\Http\Controllers\Controller;
use App\Imports\GoogleImport;

class GoogleImportController extends Controller
{

    public function import()
    {
        (new GoogleImport)->import(storage_path('app/public/import/google/teste.csv'), null, \Maatwebsite\Excel\Excel::CSV);
    }

}
