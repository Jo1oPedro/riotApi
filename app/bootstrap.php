<?php

use DI\Container;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;

require BASE_PATH . '/vendor/autoload.php';

(new Dotenv())->loadEnv(BASE_PATH . "/.env");

$httpClient = HttpClient::create([
    'headers' => ["X-Riot-Token" => $_ENV["RIOT_KEY"]]
]);

$container = new Container();

dd($httpClient->request("GET", "https://americas.api.riotgames.com/riot/account/v1/accounts/by-riot-id/CascataXFrontEnd/BR1")->toArray());