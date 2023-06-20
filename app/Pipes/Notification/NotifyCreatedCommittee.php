<?php

namespace App\Pipes\Notification;

use Closure;
use App\Contracts\Pipes\IPipeHandler;
use Symfony\Component\HttpClient\CurlHttpClient;

final class NotifyCreatedCommittee implements IPipeHandler
{
    private CurlHttpClient $client;

    public function __construct()
    {
        $this->client = new CurlHttpClient();
    }


    public function handle(mixed $payload, Closure $next)
    {
        $payload = $payload->load('submitted');

        $response = $this->client->request('GET', 'http://localhost:3030/socket.io/?EIO=4&transport=polling&t=N8hyd6w');

        $res = ltrim($response->getContent(), '0');

        $res = json_decode($res, true);

        $clientID = $res['sid'];

        $this->client->request('POST', 'http://localhost:3030/socket.io/?EIO=4&transport=polling&sid=' . $clientID, ['body' => '40']);
        $this->client->request('GET', 'http://localhost:3030/socket.io/?EIO=4&transport=polling&sid=' . $clientID);
        $this->client->request('POST', 'http://localhost:3030/socket.io/?EIO=4&transport=polling&sid=' . $clientID, [
            'body' => '42["NOTIFY_CREATED_COMMITTEE", "submitted=' . $payload?->submitted?->id . '&name=' . $payload->name . '&committee=' . $payload->lead_committee . '"]'
        ]);

        return $next($payload);
    }
}
