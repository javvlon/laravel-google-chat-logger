# Laravel Google Chat Logger

This package provides a simple way to log messages to a Google Chat room from your Laravel application.

## Installation

You can install the package via composer:

```bash
composer require your-vendor/laravel-google-chat-logger
```

## Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --provider="YourVendor\GoogleChatLogger\GoogleChatLoggerServiceProvider"
```

Add your Google Chat webhook URL to your `.env` file:

```env
GOOGLE_CHAT_WEBHOOK_URL=https://chat.googleapis.com/v1/spaces/...
```

## Usage

You can log messages to Google Chat using the provided facade:

```php
use YourVendor\GoogleChatLogger\Facades\GoogleChatLogger;

GoogleChatLogger::info('This is an info message');
GoogleChatLogger::error('This is an error message');
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
