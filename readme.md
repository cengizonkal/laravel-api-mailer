# Laravel Api Mailer
## Installation
You can install the package via composer:
```bash
composer require conkal/laravel-api-mailer
```
## Configuration

Add the mailapi service provider in config/app.php:
```php
'providers' => [
    Conkal\ApiMailServiceProvider::class,
];
```

config/services.php 
```php
    'mailapi' => [
        'api_key' => env('MAILAPI_API_KEY'), //bearer token
        'endpoint' => env('MAILAPI_ENDPOINT', 'https://api.mailapi.io'),
    ],
```