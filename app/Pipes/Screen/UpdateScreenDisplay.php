<?php

namespace App\Pipes\Screen;

use Closure;
use App\Services\SocketService;
use App\Contracts\Pipes\IPipeHandler;
use App\Repositories\SettingRepository;
use Symfony\Component\HttpClient\CurlHttpClient;

final class UpdateScreenDisplay implements IPipeHandler
{
    public function handle(mixed $payload, Closure $next)
    {
        if (array_key_exists('screen_display', $payload)) {
            $this->replaceScreenContent($this->buildUrl($payload['id'], $payload['screen_display']));
            SettingRepository::setNewValue(key: 'screen_display', databaseKey: 'screen_display', data: $payload);
            return $next($payload);
        }
    }

    private function replaceScreenContent(string $url)
    {
        SocketService::established(new CurlHttpClient(), SettingRepository::getValueByName('server_socket_url'))->notify($url);
    }

    private function buildUrl(int $id, string $selectedDisplay): string
    {
        $url = "";
        match ($selectedDisplay) {
            'privilege_hour' => $url = "/screen-privilege-hour/{$id}",
            'question_of_hour' => $url = "/screen-question-of-hour/{$id}",
            'committee_meeting' => $url = "/screen/{$id}",
        };
        return $url;
    }
}
