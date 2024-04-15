<?php

declare(strict_types = 1);
ini_set("memory_limit", "-1");

use Riot\Api\RiotApiClientProxy;
use Riot\Map\Analyzers\SlaughterParticipationAnalyzer;
use Riot\Map\PlotsType\PlotKillAssistDeath;
use Symfony\Component\Dotenv\Dotenv;
use Riot\Discord;

require_once __DIR__ . "/vendor/autoload.php";

(new Dotenv())->loadEnv(__DIR__ . "/.env");

$match = 14;

$maps = [
    "ONEFORALL" => "Classic",
    "ARAM" => "Aram",
    "CLASSIC" => "Classic",
];

$riotApiClient = new RiotApiClientProxy($_ENV["RIOT_KEY"]);

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

$analyzer = new SlaughterParticipationAnalyzer();
$image = ($mapClass->newInstance())
    ->analyzeMap($analyzer, $matchInfoTimeline, [$puuid])
    ->plotOnMap(new PlotKillAssistDeath());

Discord\NewMatch::sendMessage($image);