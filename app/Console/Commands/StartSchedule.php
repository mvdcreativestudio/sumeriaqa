<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class StartSchedule extends Command
{
    protected $signature = 'start:schedule';
    protected $description = 'Start the Laravel task scheduler along with the web server';

    public function handle()
    {
        $this->info('Starting Laravel task scheduler...');
        $this->call('schedule:work');
    }
}
