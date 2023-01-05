<?php

namespace Conkal\LaravelApiMailer;

use GuzzleHttp\ClientInterface;

use Illuminate\Mail\Transport\Transport;
use Swift_Attachment;
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
            'headers' => ['Authorization' => 'Bearer ' . $this->apiKey],
        ];

        $data = [
            'from' => $this->getFrom($message),
            'to' => implode(array_keys($message->getTo()), ','),
            'cc' => $this->getCc($message),
            'bcc' => $this->getBcc($message),
            'subject' => $message->getSubject(),
            'body' => $message->getBody(),
            'attachments' => $this->getAttachments($message),
        ];

        $payload += ['form_params' => $data];

        return $this->client->post($this->endpoint, $payload);
    }

    private function getFrom(Swift_Mime_Message $message)
    {
        $from = $message->getFrom();
        if (is_array($from) && count($from) > 0) {
            return array_keys($from)[0];
        }
        return $from;
    }

    private function getCc(Swift_Mime_Message $message)
    {
        $cc = $message->getCc();
        if (is_array($cc) && count($cc) > 0) {
            return implode(array_keys($cc), ',');
        }
        return $cc;
    }

    private function getBcc(Swift_Mime_Message $message)
    {
        $bcc = $message->getBcc();
        if (is_array($bcc) && count($bcc) > 0) {
            return implode(array_keys($bcc), ',');
        }
        return $bcc;
    }

    private function getAttachments(Swift_Mime_Message $message)
    {
        $attachments = [];
        foreach ($message->getChildren() as $attachment) {
            if (!$attachment instanceof Swift_Attachment) {
                continue;
            }
            $attachments[] = [
                'filename' => $attachment->getFilename(),
                'content' => base64_encode($attachment->getBody()),
                'content_type' => $attachment->getContentType(),
            ];
        }
        return $attachments;
    }

}