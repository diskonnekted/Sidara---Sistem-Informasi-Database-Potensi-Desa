<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\ImportVillages;
use App\Console\Commands\GeneratePotentialsFromVillages;
use App\Console\Commands\AddSembawaVillage;
use App\Console\Commands\AddPetambakanProduct;
use App\Console\Commands\AddPagentanMarketplace;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        ImportVillages::class,
        GeneratePotentialsFromVillages::class,
        AddSembawaVillage::class,
        AddPetambakanProduct::class,
        AddPagentanMarketplace::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
