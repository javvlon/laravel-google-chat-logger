<?php

namespace Javvlon\GoogleChatLogger;

use Illuminate\Support\ServiceProvider;
use Monolog\Logger;
use Illuminate\Log\LogManager;

class GoogleChatLoggerServiceProvider extends ServiceProvider
{
    /**
     * Register the application services
     */
    public function register()
    {
        $this->app->extend(LogManager::class, function ($logManager) {
            return $logManager->extend('google_chat', function ($app, $config) {
                $webhookUrl = $config['webhook_url'] ?? '';

                return new Logger('google_chat', [
                    new GoogleChatLogger($webhookUrl)
                ]);
            });
        });
    }
}
