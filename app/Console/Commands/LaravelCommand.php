<?php

namespace App\Console\Commands;

use App\Jobs\PenaltyJob;
use Illuminate\Console\Command;

class LaravelCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel:command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        PenaltyJob::dispatch();
    }
}
