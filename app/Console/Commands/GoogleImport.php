<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Imports\GoogleImportController;
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
        $this->line(Carbon::now());
        $import = new GoogleImportController;
        $import->import();
        $this->line(Carbon::now());
    }
}
