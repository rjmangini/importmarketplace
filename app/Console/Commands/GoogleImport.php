<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Imports\GoogleImportController;
use App\Http\Controllers\Imports\GoogleImportItensController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class GoogleImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:google';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importar arquivo de venda do Google';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::now()->format('Y-m-d');
        $log = Log::build([
            'driver' => 'single',
            'path' => storage_path("logs/imports/google/{$today}.log"),
        ]);

        $log->info("------------------------------------------- Importação Iniciada - " . Carbon::now());

        $log->info("Importando SALE - " . Carbon::now());
        $importSales = new GoogleImportController;
        $importSales->import();

        $log->info("Importando SALE_ITEMS - " . Carbon::now());
        $importItems = new GoogleImportItensController;
        $importItems->import();

        $log->info("------------------------------------------- Importação Finalizada - " . Carbon::now());
    }
}
