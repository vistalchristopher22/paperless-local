<?php

namespace App\Services;

use Symfony\Contracts\HttpClient\HttpClientInterface;

final class SocketService
{
    public static $connection;
    public static $clientID;
    public static $baseUrl;

    public static function established(HttpClientInterface $client, string $baseUrl)
    {
        self::$connection = $client;
        self::$baseUrl = $baseUrl;
        $response = $client->request('GET', self::$baseUrl . "socket.io/?EIO=4&transport=polling&t=N8hyd6w");
        $res = ltrim($response->getContent(), '0');
        $res = json_decode($res, true);
        self::$clientID = $res['sid'];
        return new static();
    }

    public static function notify(string $url)
    {
        self::$connection->request('POST', self::$baseUrl . 'socket.io/?EIO=4&transport=polling&sid=' . self::$clientID, ['body' => '40']);
        self::$connection->request('GET', self::$baseUrl . 'socket.io/?EIO=4&transport=polling&sid=' . self::$clientID);
        self::$connection->request('POST', self::$baseUrl . 'socket.io/?EIO=4&transport=polling&sid=' . self::$clientID, [
            'body' => '42["SCREEN_DISPLAY_CHANGED", "url=' . $url . '"]'
        ]);
    }

    public static function refresh()
    {
        self::$connection->request('POST', self::$baseUrl . 'socket.io/?EIO=4&transport=polling&sid=' . self::$clientID, ['body' => '40']);
        self::$connection->request('GET', self::$baseUrl . 'socket.io/?EIO=4&transport=polling&sid=' . self::$clientID);
        self::$connection->request('POST', self::$baseUrl . 'socket.io/?EIO=4&transport=polling&sid=' . self::$clientID, [
            'body' => '42["TRIGGER_REFRESH"]'
        ]);
    }

}
