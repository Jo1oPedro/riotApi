<?php

declare(strict_types = 1);
ini_set("memory_limit", "-1");
define("BASE_PATH", __DIR__);
require_once __DIR__ . "/bootstrap.php";

use App\Client\RiotApiClientProxy;
use App\Map\Analyzers\SlaughterParticipationAnalyzer;
use App\Map\PlotsType\PlotKillAssistDeath;
use App\Discord;


dd(BASE_PATH);

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