<?php

namespace App\Client\Riot;

use App\Client\HttpClientInterface;

interface RiotApiClientInterface
{
    const RIOT_ACCOUNT = "https://americas.api.riotgames.com/riot/account/v1";
    const RIOT_MATCHES = "https://americas.api.riotgames.com/lol/match/v5";
    public function __construct(HttpClientInterface $httpClient, string $riotKey);

    public function get_puuid(string $userName, string $tag): string;

    public function getMatchesId(string $puuid, int $count = 20, string $type = "normal", $jsonDecode = true): array|string;

    public function getMatchInfo(string $matchId, $jsonDecode = true): \stdClass|string;

    public function getMatchInfoTimeline(string $matchId, $jsonDecode = true): \stdClass|string;
}