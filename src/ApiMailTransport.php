<?php

namespace Conkal\LaravelApiMailer;

use GuzzleHttp\ClientInterface;

use Illuminate\Mail\Transport\Transport;
use Swift_Mime_Message;

class ApiMailTransport extends Transport
{

    private $client;


    private $apiKey;
    private $endpoint;

    public function __construct(ClientInterface $client, $api_key, $endpoint = null)
    {
        $this->client = $client;
        $this->apiKey = $api_key;
        $this->endpoint = $endpoint;
    }

    public function send(Swift_Mime_Message $message, &$failedRecipients = null)
    {
        $payload = [
            'headers' => ['Authorization' => 'Bearer '.$this->apiKey],
        ];
        $data = [
            'from' => array_keys($message->getFrom())[0],
            'to' => implode(array_keys($message->getTo()), ','),
            'subject' => $message->getSubject(),
            'body' => $message->getBody(),
        ];

        $payload += ['form_params' => $data];

        return $this->client->post($this->endpoint, $payload);
    }
}