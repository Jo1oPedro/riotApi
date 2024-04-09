<?php

declare(strict_types = 1);
ini_set("memory_limit", "-1");

use Riot\Api\RiotApiClient;
use Riot\Map\Analyzers\SlaughterParticipation;
use Riot\Map\MapsType\ClassicMap;
use Riot\Map\PlotsType\PlotKillAssistDeath;
use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ . "/vendor/autoload.php";

(new Dotenv())->loadEnv(__DIR__ . "/.env");

$match = 11;

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
$mapClass = new ReflectionClass("Riot\Map\MapsType\\{$mapType}Map");

$matchInfoTimeline = $riotApiClient->getMatchInfoTimeline($matchesId[$match]);

$classicMap = ($mapClass->newInstance())
    ->analyzeMap((new SlaughterParticipation()), $matchInfoTimeline, $puuid)
    ->plotOnMap(new PlotKillAssistDeath());