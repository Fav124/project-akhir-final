<?php

namespace App\Console\Commands;

use App\Models\Obat;
use App\Models\User;
use App\Notifications\ObatExpiringNotification; // We will create this
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckObatExpiry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'obat:check-expiry {days=30}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for medicines expiring soon and log alerts';

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
        $days = $this->argument('days');
        $this->info("Checking for medicines expiring within {$days} days...");

        $expiringObats = Obat::whereNotNull('tanggal_kadaluarsa')
            ->whereDate('tanggal_kadaluarsa', '>', now())
            ->whereDate('tanggal_kadaluarsa', '<=', now()->addDays($days))
            ->get();

        $expiredObats = Obat::whereNotNull('tanggal_kadaluarsa')
            ->whereDate('tanggal_kadaluarsa', '<=', now())
            ->get();

        if ($expiringObats->isEmpty() && $expiredObats->isEmpty()) {
            $this->info('No expiring or expired medicines found.');
            return 0;
        }

        // Log results
        foreach ($expiringObats as $obat) {
            $this->warn("Expiring Soon: {$obat->nama_obat} (Expiries in " . now()->diffInDays($obat->tanggal_kadaluarsa) . " days)");
            Log::warning("Obat Expiring Soon: {$obat->nama_obat} (#{$obat->id})");
            
            // Here we could send notifications to admins
            // User::where('role', 'admin')->each(function($user) use ($obat) { ... });
        }

        foreach ($expiredObats as $obat) {
            $this->error("EXPIRED: {$obat->nama_obat} (Expired on {$obat->tanggal_kadaluarsa->format('Y-m-d')})");
            Log::alert("Obat EXPIRED: {$obat->nama_obat} (#{$obat->id})");
        }

        $this->info('Check completed.');
        return 0;
    }
}
