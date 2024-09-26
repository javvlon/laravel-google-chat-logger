<?php

namespace Javvlon\GoogleChatLogger;

use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;
use Illuminate\Support\Facades\Http;

class GoogleChatLoggerHandler extends AbstractProcessingHandler
{
    protected $webhookUrl;
    protected $appName;
    protected $environment;

    public function __construct($level = Logger::ERROR, bool $bubble = true)
    {
        parent::__construct($level, $bubble);
        $this->webhookUrl = config('google_chat_logger.webhook_url');
        $this->appName = config('app.name');
        $this->environment = config('app.env');
    }

    protected function write(array $record): void
    {
        $message = $this->formatMessage($record);
        $this->sendToGoogleChat($message);
    }

    protected function formatMessage(array $record): string
    {
        return sprintf(
            "*[%s]* %s\n" .
                "*App Name:* %s\n" .
                "*Environment:* %s\n\n" .
                "-- Request --\n" .
                "URL: %s\n" .
                "Method: %s\n" .
                "Headers:\n%s\n" .
                "Body:\n%s\n\n" .
                "-- Response --\n" .
                "Status Code: %s\n" .
                "Headers:\n%s\n" .
                "Body:\n%s\n\n" .
                "Error Message: %s",
            $record['level_name'],
            $record['datetime']->format('Y-m-d H:i:s'),
            $this->appName,
            $this->environment,
            $record['context']['request_url'] ?? 'N/A',
            $record['context']['request_method'] ?? 'N/A',
            $record['context']['request_headers'] ?? 'N/A',
            $record['context']['request_body'] ?? 'N/A',
            $record['context']['response_status_code'] ?? 'N/A',
            $record['context']['response_headers'] ?? 'N/A',
            $record['context']['response_body'] ?? 'N/A',
            $record['message']
        );
    }

    protected function sendToGoogleChat(string $message)
    {
        Http::post($this->webhookUrl, [
            'text' => $message,
        ]);
    }
}
