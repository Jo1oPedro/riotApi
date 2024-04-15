<?php

namespace Riot\Api;

use PDO;
use Riot\Helper\Curl;

interface RiotApiClientInterface
{
    const RIOT_ACCOUNT = "https://americas.api.riotgames.com/riot/account/v1";
    const RIOT_MATCHES = "https://americas.api.riotgames.com/lol/match/v5";
    public function __construct(string $riotKey);

    public function get_puuid(string $userName, string $tag): string;

    public function getMatchesId(string $puuid, int $count = 20, string $type = "normal", $jsonDecode = true): array|string;

    public function getMatchInfo(string $matchId, $jsonDecode = true): \stdClass|string;

    public function getMatchInfoTimeline(string $matchId, $jsonDecode = true): \stdClass|string;
}