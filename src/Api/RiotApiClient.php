<?php

namespace Riot\Api;

class RiotApiClient
{
    const RIOT_ACCOUNT = "https://americas.api.riotgames.com/riot/account/v1";
    const RIOT_MATCHES = "https://americas.api.riotgames.com/lol/match/v5";
    private string $riotKey = "";

    public function __construct()
    {
        $this->riotKey = $_ENV["RIOT_KEY"];
    }

    private function curl(string $url, string $method, $jsonDecode = true): array|\stdClass|string
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_CUSTOMREQUEST => $method
        ]);
        $response = ($jsonDecode === true) ? json_decode(curl_exec($curl)) : curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    public function get_puuid(string $userName, string $tag): string
    {
        $url = self::RIOT_ACCOUNT . "/accounts/by-riot-id/{$userName}/{$tag}?api_key={$this->riotKey}";
        $response = $this->curl($url, "GET");
        return $response->puuid;
    }

    public function getMatchesId(string $puuid, int $count = 20, string $type = "normal", $jsonDecode = true): array|string
    {
        $curl = curl_init();
        $url = self::RIOT_MATCHES . "/matches/by-puuid/{$puuid}/ids?start=0&count=20&includeTimeline=true&api_key={$this->riotKey}";
        $matchesId = $this->curl($url, "GET", $jsonDecode);
        return $matchesId;
    }

    public function getMatchInfo(string $matchId, $jsonDecode = true): \stdClass|string
    {
        $url = self::RIOT_MATCHES . "/matches/{$matchId}?api_key={$this->riotKey}";
        $matchInfo = $this->curl($url, "GET", $jsonDecode);
        return $matchInfo;
    }

    public function getMatchInfoTimeline(string $matchId, $jsonDecode = true): \stdClass|string
    {
        $url = self::RIOT_MATCHES . "/matches/{$matchId}/timeline?api_key={$this->riotKey}";
        $matchInfo = $this->curl($url, "GET", $jsonDecode);
        return $matchInfo;
    }
}