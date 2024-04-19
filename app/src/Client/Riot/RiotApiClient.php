<?php

namespace App\Client\Riot;

use App\Client\Exceptions\PlayerNotFound;
use App\Client\HttpClientInterface;
use App\Helper\Curl;

class RiotApiClient implements RiotApiClientInterface
{
    private Curl $curl;

    public function __construct(
        private HttpClientInterface $httpClient,
        private string $riotKey = "",
    ) {
        $this->curl = new Curl();
    }

    /**
     * @param string $userName
     * @param string $tag
     * @return string
     * @throws PlayerNotFound
     */
    public function get_puuid(string $userName, string $tag): string
    {
        $url = self::RIOT_ACCOUNT . "/accounts/by-riot-id/{$userName}/{$tag}?api_key={$this->riotKey}";
        $response = $this->httpClient->request("GET", $url);
        if($response->getStatusCode() === "404") {
            throw new PlayerNotFound($response->getContent()->status->message);
        }

        return $response->getContent()->puuid;
    }

    public function getMatchesId(string $puuid, int $count = 20, string $type = "normal", $jsonDecode = true): array|string
    {
        $url = self::RIOT_MATCHES . "/matches/by-puuid/{$puuid}/ids?start=0&count=20&includeTimeline=true&api_key={$this->riotKey}";
        $matchesId = $this->httpClient->request($url, "GET");
        return $matchesId->getContent();
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