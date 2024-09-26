<?php

namespace Javvlon\GoogleChatLogger;

use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;
use Illuminate\Support\Facades\Http;

class GoogleChatLogger extends AbstractProcessingHandler
{
    protected $webhookUrl;

    public function __construct($webhookUrl, $level = Logger::ERROR, bool $bubble = true)
    {
        $this->webhookUrl = $webhookUrl;
        parent::__construct($level, $bubble);
    }

    protected function write(array $record): void
    {
        $message = [
            'text' => sprintf(
                "*[%s]* %s (%s) %s\n%s\n%s",
                $record['level_name'],
                env('APP_NAME'),
                env('APP_ENV'),
                $record['datetime']->format('Y-m-d H:i:s'),
                $record['message'],
                $record['context'] ? json_encode($record['context'], JSON_PRETTY_PRINT) : ''
            )
        ];

        Http::post($this->webhookUrl, $message);
    }
}
