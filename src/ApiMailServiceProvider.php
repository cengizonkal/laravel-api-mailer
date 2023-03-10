<?php

namespace Conkal\LaravelApiMailer;

use Illuminate\Mail\TransportManager;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client as HttpClient;

class ApiMailServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->afterResolving(TransportManager::class, function (TransportManager $transportManager) {
            $transportManager->extend("mailapi", function ($config) {
                if (! isset($config['api_key'])) {
                    $config = $this->app['config']->get('services.mailapi', []);
                }
                $client = new HttpClient(Arr::get($config, 'guzzle', []));
                $endpoint = $config['endpoint'];

                return new ApiMailTransport($client, $config['api_key'], $endpoint);
            });

        });
    }
}