# AcyMailer PHP Library

## Installation

```bash
composer require acymailing/sending-service
```

## Usage

```php
require_once 'path/to/vendor/autoload.php';

use AcyMailer\SendingService;

$acymailer = new SendingService('your-license-key');

$domain = $acymailer->addDomain('example.com');

$optionsSendEmail = [
    'to' => 'email@example.com',
    'subject' => 'This is the subject',
    'body' => 'This is the body with a <h1>title</h1> and a <a href="https://www.acymailing.com">link</a>.',
    'alt_body' => 'This is the alternative body. Only text here', // optional
    'from_email' => 'email@example.com',
    'from_name' => 'Email Example',
    'reply_to_email' => 'no-reply@example.com', // optional, default to from_email
    'reply_to_name' => 'no-reply', // optional, default to from_name
    'bounce_email' => 'bounce@example.com', // optional, default to from_email
    'cc' => ['cc@acymailing.com'], // optional, must be an array
    'attachments' => ['path/to/attachment.png'], // optional, must be an array
];

$acymailer->send($optionsSendEmail);
```

## Development

## Installing locally the library

In the composer.json file of the local project, add the following line in the require section:

```json
{
    //...
    "repositories": [
        {
            "type": "path",
            "url": "/path/to/acymailer/library"
        }
    ]
    //...
    "require": {
        "acymailing/sending-service": "@dev"
    }
    //...
}
```

Then, in the terminal, execute the following command:

```bash
composer install
```
