# Laravel Api Mailer
A package that allows you to send emails via an API in your Laravel application.
## Installation
To install the package, run the following command in your terminal:
```bash
composer require conkal/laravel-api-mailer
```
## Configuration

In your **config/app.php** file, add the following line to the providers array:
```php
'providers' => [
    Conkal\ApiMailServiceProvider::class,
];
```

Next, in your **config/services.php** file, add the following configuration for the mailapi service:
```php
'mailapi' => [
    'api_key' => env('MAILAPI_API_KEY'), //bearer token
    'endpoint' => env('MAILAPI_ENDPOINT', 'https://api.mailapi.io'),
]
```
Don't forget to set the **MAILAPI_API_KEY** and **MAILAPI_ENDPOINT** environment variables with your API key and desired endpoint, respectively.