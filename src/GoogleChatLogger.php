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
                "*%s* - `%s`\n```\n%s\n```",
                $record['level_name'],
                $record['message'],
                $record['context'] ? json_encode($record['context'], JSON_PRETTY_PRINT) : 'No Context'
            )
        ];

        Http::post($this->webhookUrl, $message);
    }
}
