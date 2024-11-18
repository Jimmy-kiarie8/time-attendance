<?php

namespace App\Providers;

use App\Channels\SmsChannel;
use Illuminate\Support\ServiceProvider;
use Illuminate\Notifications\ChannelManager;

class SmsServceProvider extends ServiceProvider
{
    public function boot()
    {
        // Register the sms channel with the Laravel Notification system
        app(ChannelManager::class)->extend('sms', function ($app) {
            return new SmsChannel;
        });
    }
}
