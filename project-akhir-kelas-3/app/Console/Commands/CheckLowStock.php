<?php

namespace App\Console\Commands;

use App\Models\Obat;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckLowStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'obat:check-stock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for medicines with low stock';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info("Checking for low stock medicines...");

        // Using the scopeLowStock from model
        $lowStockObats = Obat::lowStock()->get();

        if ($lowStockObats->isEmpty()) {
            $this->info('All medicine usage levels are healthy.');
            return 0;
        }

        foreach ($lowStockObats as $obat) {
            $this->warn("Low Stock: {$obat->nama_obat} (Current: {$obat->stok} {$obat->satuan}, Min: {$obat->stok_minimum})");
            Log::warning("Obat Low Stock: {$obat->nama_obat} (#{$obat->id})");
        }

        $this->info('Stock check completed.');
        return 0;
    }
}
