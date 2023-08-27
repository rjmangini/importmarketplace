<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Imports\GoogleImportController;
use App\Http\Controllers\Imports\GoogleImportItensController;
use Carbon\Carbon;

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
        $this->line("Importando Vendas - " . Carbon::now());
        $importSales = new GoogleImportController;
        $importSales->import();

        $this->line("Importando Itens - " . Carbon::now());
        $importSales = new GoogleImportItensController;
        $importSales->import();

        $this->line("Importando Finalizada - " . Carbon::now());
    }
}
