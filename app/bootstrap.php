<?php

use App\Client\HttpClient;
use App\Client\HttpClientInterface;
use App\Client\Riot\RiotApiClientProxy;
use DI\ContainerBuilder;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient as SymfonyHttpClient;
use Symfony\Component\HttpClient\HttpOptions;

require BASE_PATH . '/vendor/autoload.php';

(new Dotenv())->loadEnv(BASE_PATH . "/.env");

$httpOptions = (new HttpOptions())
    ->setHeaders(["X-Riot-Token" => $_ENV["RIOT_KEY"], "Accept" => "application/json"])
    ->toArray();
$symfonyHttpClient = SymfonyHttpClient::create()->withOptions($httpOptions);

$httpClient = new HttpClient($symfonyHttpClient);

$containerBuilder = new ContainerBuilder();

$riotApiClientProxy = DI\create(RiotApiClientProxy::class)
    ->constructor($httpClient, $_ENV["RIOT_KEY"]);

$containerBuilder->addDefinitions([
    HttpClientInterface::class => $httpClient,
    RiotApiClientProxy::class => $riotApiClientProxy
]);

$container = $containerBuilder->build();