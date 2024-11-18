<?php

namespace App\Providers;

use App\Contracts\EmailServiceInterface;
use App\Contracts\SmsServiceInterface;
use App\Models\EmailConfig;
use App\Models\SmsConfig;
use App\Services\Email\ZohoEmailService;
use App\Services\Sms\AfricasTalkingSmsService;
use Illuminate\Support\ServiceProvider;

class CommunicationServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(SmsServiceInterface::class, function ($app) {
            $config = SmsConfig::where('is_default', true)->first();
            $provider = $config ? $config->provider : config('communication.sms.provider');
            return $app->make("App\\Services\\Sms\\{$provider}SmsService", ['config' => $config]);
        });

        $this->app->bind(EmailServiceInterface::class, function ($app) {
            $config = EmailConfig::where('is_default', true)->first();
            $provider = $config ? $config->provider : config('communication.email.provider');
            return $app->make("App\\Services\\Email\\{$provider}EmailService", ['config' => $config]);
        });
    }

    public function boot()
    {
        //
    }
}
