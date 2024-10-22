<?php

namespace Javvlon\GoogleChatLogger;

use Monolog\Logger;
use Monolog\LogRecord;
use Monolog\Handler\AbstractProcessingHandler;
use Illuminate\Support\Facades\Http;

class GoogleChatLogger extends AbstractProcessingHandler
{
    /**
     * The webhook URL for Google Chat
     *
     * @var string
     */
    protected string $webhookUrl;

    /**
     * Create a new Google Chat Logger instance
     *
     * @param string $webhookUrl
     * @param int $level
     * @param bool $bubble
     */
    public function __construct(string $webhookUrl, $level = Logger::ERROR, bool $bubble = true)
    {
        $this->webhookUrl = $webhookUrl;
        parent::__construct($level, $bubble);
    }

    /**
     * Write a log record to Google Chat
     *
     * @param LogRecord $record
     */
    protected function write(LogRecord $record): void
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
