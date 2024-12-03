<?php

namespace Mailstream\Quickmail;

use Illuminate\Support\ServiceProvider;

class MailServiceProvider extends ServiceProvider
{
    public function boot()
    {
       $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'quickmail');
        $this->loadMigrationsFrom(__DIR__ .'/database/migrations');
        
        $this->publishes([
            __DIR__.'/database/migrations' =>database_path('migrations'),
        ], 'quickmail-migrations');

        $this->publishes([
            __DIR__ . '/resources/assets/css' => public_path('quickmail/css'),
            __DIR__ . '/resources/assets/js' => public_path('quickmail/js'),
            __DIR__ . '/resources/assets/images' => public_path('quickmail/images'),
        ], 'quickmail-assets');

        $this->publishes([
            __DIR__. '/../config/quickmail.php' => config_path('quickmail.php'),
        ], 'quickmail-config');

        $this->publishes([
            __DIR__ . '/Models' => app_path('Models'),
        ], 'quickmail-models');
        $this->publishes([
            __DIR__. '/Http/Requests' =>app_path('Http/Requests'),
        ], 'quickmails-requests');
    }
    

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/quickmail.php', 'quickmail');
    }
} 

