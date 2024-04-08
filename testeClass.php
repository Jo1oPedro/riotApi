<?php

declare(strict_types = 1);
ini_set("memory_limit", "-1");

use Riot\Api\api\RiotApiClient;
use Riot\Api\map\Analyzers\SlaughterParticipation;
use Riot\Api\map\MapsType\ClassicMap;
use Riot\Api\map\PlotsType\PlotKillAssistDeath;
use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ . "/vendor/autoload.php";

(new Dotenv())->loadEnv(__DIR__ . "/.env");

$match = 8;

$maps = [
    "ONEFORALL" => "Classic",
    "ARAM" => "Aram",
    "CLASSIC" => "Classic",
];

$riotApiClient = new RiotApiClient();

$puuid = $riotApiClient->get_puuid("CascataXFrontEnd", "BR1");
$matchesId = $riotApiClient->getMatchesId($puuid);

$matchInfo = $riotApiClient->getMatchInfo($matchesId[$match]);
foreach($matchInfo->metadata->participants as $key => $participant) {
    if($participant === $puuid) {
        $participantKey = $key;
    }
}
$participant = $matchInfo->info->participants[$participantKey];

$mapType = $maps[$matchInfo->info->gameMode];
$mapClass = new ReflectionClass("Riot\Api\map\MapsType\\{$mapType}Map");

$matchInfoTimeline = $riotApiClient->getMatchInfoTimeline($matchesId[$match]);

$classicMap = ($mapClass->newInstance())
    ->analyzeMap((new SlaughterParticipation()), $matchInfoTimeline, $puuid)
    ->plotOnMap(new PlotKillAssistDeath());