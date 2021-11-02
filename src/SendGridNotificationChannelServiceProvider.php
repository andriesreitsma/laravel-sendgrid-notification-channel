<?php

namespace Konstruktiv\SendGridNotificationChannel;

use Illuminate\Container\Container;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;
use Konstruktiv\SendGridNotificationChannel\Channels\SendGridChannel;
use SendGrid;

class SendGridNotificationChannelServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/sendgrid.php', 'sendgrid');

        $this->app->when(SendGridChannel::class)
            ->needs(SendGrid::class)
            ->give(function () {
                return new SendGrid(
                    $this->app['config']['sendgrid.api_key']
                );
            });
    }

    /**
     * Register application service.
     * @return void
     */
    public function register()
    {
        Notification::extend('sendgrid',static function (Container $app) {
            return $app->make(SendGridChannel::class);
        });
    }

}
