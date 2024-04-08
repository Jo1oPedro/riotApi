<?php

declare(strict_types = 1);
ini_set("memory_limit", "-1");

use Riot\Api\image;
use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ . "/vendor/autoload.php";

(new Dotenv())->loadEnv(__DIR__ . "/.env");

$riotAccount = "https://americas.api.riotgames.com/riot/account/v1";
$riotMatches = "https://americas.api.riotgames.com/lol/match/v5";
$riotKey = $_ENV["RIOT_KEY"];
$userName = "CascataXFrontEnd";
$tag = "BR1";

$url = "{$riotAccount}/accounts/by-riot-id/{$userName}/{$tag}?api_key={$riotKey}";

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => TRUE,
    CURLOPT_CUSTOMREQUEST => "GET"
]);
$response = json_decode(curl_exec($curl));
curl_close($curl);
$puuid = $response->puuid;

$riotUrl = "{$riotMatches}/matches/by-puuid/{$puuid}/ids?start=0&count=20&includeTimeline=true&api_key={$riotKey}";

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $riotUrl,
    CURLOPT_RETURNTRANSFER => TRUE,
    CURLOPT_CUSTOMREQUEST => "GET"
]);
$response = json_decode(curl_exec($curl));
curl_close($curl);

/*$riotUrl = "{$riotMatches}/matches/{$response[0]}?api_key={$riotKey}";

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $riotUrl,
    CURLOPT_RETURNTRANSFER => TRUE,
    CURLOPT_CUSTOMREQUEST => "GET"
]);
$response = (curl_exec($curl));
curl_close($curl);

$content = print_r($response, true);
file_put_contents("dale.txt", $content);*/

$riotUrl = "{$riotMatches}/matches/{$response[1]}/timeline?api_key={$riotKey}";

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $riotUrl,
    CURLOPT_RETURNTRANSFER => TRUE,
    CURLOPT_CUSTOMREQUEST => "GET"
]);
$response = (curl_exec($curl));
curl_close($curl);

#$content = print_r($response, true);
#file_put_contents("dale2.txt", $content);

$response = json_decode($response);
$participants = $response->info->participants;
foreach($participants as $participant) {
    if($participant->puuid === $puuid) {
        $participantId = $participant->participantId;
    }
}
$x = 0;
$frames = $response->info->frames;
$positions = [];
foreach($frames as $frame) {
    foreach($frame->events as $event) {
        if($event->type === "CHAMPION_KILL" ) {
            if($event->killerId === $participantId) {
                $positions[] = ["x" => $event->position->x, "y" => $event->position->y, "type" => "KillPlots"];
                continue;
            }
            if(is_array($event->assistingParticipantIds) && in_array($participantId, $event->assistingParticipantIds)) {
                $positions[] = ["x" => $event->position->x, "y" => $event->position->y, "type" => "assist"];
                continue;
            }
            if($event->victimId === $participantId) {
                $positions[] = ["x" => $event->position->x, "y" => $event->position->y, "type" => "killed"];
            }
        }
    }
}

(new image())->plotKillAssistPoints($positions)->resizeDown();
var_dump($positions);