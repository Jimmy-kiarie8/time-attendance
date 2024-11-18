<?php

namespace App\Jobs;

use App\Models\Client;
use App\Notifications\SendSmsNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $clients;
    protected $message;

    /**
     * Create a new job instance.
     *
     * @param \Illuminate\Support\Collection $clients
     * @param string $message
     */
    public function __construct($clients, $message)
    {
        $this->clients = $clients;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->clients as $client) {
            // Send SMS to each client
            $client->notify(new SendSmsNotification($this->message));
        }
    }
}
