# Laravel Google Chat Logger

**Laravel Google Chat Logger** is a simple package that integrates Google Chat logging with Laravel. It sends logs directly to a Google Chat room using a webhook, making it easy to track errors or important events in your Laravel application.

## Features

- Send Laravel logs to a Google Chat space via webhook
- Customizable logging level (error, warning, info, etc.)
- Simple setup and configuration

## Installation

### Step 1: Install the Package via Composer

To install the package, add it to your `composer.json` or install it directly via the command line:

    composer require javvlon/laravel-google-chat-logger

## Configuration

After installing the package, you need to configure your logging channels. To do this, open your `config/logging.php` file and add the `google_chat` channel configuration:

    'channels' => [
        // Other log channels...

        'google_chat' => [
            'driver' => 'google_chat',
            'webhook_url' => env('GOOGLE_CHAT_WEBHOOK_URL'),
            'level' => 'error', // You can set the desired log level: debug, info, notice, warning, error, critical, alert, emergency
        ],
    ],

### Environment Variables

You must add your Google Chat webhook URL to your `.env` file:

    GOOGLE_CHAT_WEBHOOK_URL=https://chat.googleapis.com/v1/spaces/your-space/messages?key=your-key&token=your-token

## Usage

Once configured, Laravel will automatically send any logs to Google Chat using the specified channel. You can use the `google_chat` channel to log errors:

    Log::channel('google_chat')->error('This is a test error log message.');

## Customization

You can adjust the logging level in the `logging.php` configuration to filter what types of logs are sent to Google Chat.

For example, to log only warnings and above:

    'level' => 'warning',

## License

The MIT License (MIT). Please see License File for more information.

## Contributing

Feel free to open issues or submit pull requests to improve the functionality. We welcome contributions!

## Support

If you encounter any issues or need assistance, feel free to open a GitHub issue.
