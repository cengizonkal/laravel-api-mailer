Add the mailapi service provider in config/app.php:
```php
'providers' => [
    Conkal\ApiMailServiceProvider::class,
];

config/services.php 
```php
    'mailapi' => [
        'api_key' => env('MAILAPI_API_KEY'),
        'endpoint' => env('MAILAPI_ENDPOINT', 'https://api.mailapi.io'),
    ],
```