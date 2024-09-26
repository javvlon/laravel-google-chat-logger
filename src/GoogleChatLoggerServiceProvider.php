<?php

namespace Javvlon\GoogleChatLogger;

use Illuminate\Support\ServiceProvider;
use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class GoogleChatLoggerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/google_chat_logger.php' => config_path('google_chat_logger.php'),
        ]);

        // Add custom logger channel
        Log::extend('google_chat', function ($app, array $config) {
            return new Logger('google_chat', [new GoogleChatLoggerHandler()]);
        });
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/google_chat_logger.php',
            'google_chat_logger'
        );
    }
}
