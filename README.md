# laravel-sendgrid-notification-channel
Laravel Sendgrid Notification channel

## Installation

To get started, you need to require this package:

```bash
composer require konstruktiv/laravel-sendgrid-notification-channel
```

The service provider will be auto-detected by Laravel. So, no need to register it manually.

## Usage

To make use of this package, your notification class should look like this:

```php
<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class ExampleNotification extends Notification
{
    public function via($notifiable)
    {
        return [
            'sendgrid',
            // And any other channels you want can go here...
        ];
    }
    
    // ...

    public function toSendGrid($notifiable)
    {
        return (new SendGridMessage('Your SendGrid template ID'))
            ->subject('Subject goes here')
            ->from('sendgrid@example.com','SendGrid')
            ->to(
                $notifiable->email,
                $notifiable->name,
                [
                    'key' => 'value'
                ]
            )
            ->payload([
                'key' => 'value'
            ]);
	}
}
```
