<?php

namespace App\Client;

use App\Database\Connection;
use App\Helper\Curl;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RiotApiClient implements RiotApiClientInterface
{
    private Curl $curl;

    public function __construct(
        private HttpClientInterface $httpClient,
        private string $riotKey = "",
    ) {
        $this->curl = new Curl();
    }

    public function get_puuid(string $userName, string $tag): string
    {
        $url = self::RIOT_ACCOUNT . "/accounts/by-riot-id/{$userName}/{$tag}?api_key={$this->riotKey}";
        $response = $this->httpClient->request("GET", $url)->toArray();
        return $response["puuid"];
    }

    public function getMatchesId(string $puuid, int $count = 20, string $type = "normal", $jsonDecode = true): array|string
    {
        $curl = curl_init();
        $url = self::RIOT_MATCHES . "/matches/by-puuid/{$puuid}/ids?start=0&count=20&includeTimeline=true&api_key={$this->riotKey}";
        $matchesId = $this->curl->request($url, "GET", $jsonDecode);
        return $matchesId;
    }

    public function getMatchInfo(string $matchId, $jsonDecode = true): \stdClass|string
    {
        $url = self::RIOT_MATCHES . "/matches/{$matchId}?api_key={$this->riotKey}";
        $matchInfo = $this->curl->request($url, "GET", $jsonDecode);
        return $matchInfo;
    }

    public function getMatchInfoTimeline(string $matchId, $jsonDecode = true): \stdClass|string
    {
        $url = self::RIOT_MATCHES . "/matches/{$matchId}/timeline?api_key={$this->riotKey}";
        $matchInfo = $this->curl->request($url, "GET", $jsonDecode);
        return $matchInfo;
    }
}