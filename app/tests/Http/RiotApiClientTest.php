<?php

namespace App\Tests\Http;

use App\Client\Exceptions\PlayerNotFound;
use App\Client\HttpClientInterface;
use App\Client\Response;
use App\Client\Riot\RiotApiClient;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class RiotApiClientTest extends TestCase
{
    private RiotApiClient $riotApiClient;
    private HttpClientInterface $httpClient;

    public function setUp(): void
    {
        $this->httpClient = $this->createMock(HttpClientInterface::class);
        $this->riotApiClient = new RiotApiClient($this->httpClient, $_ENV["RIOT_KEY"]);
    }

    #[Test]
    public function get_puuid_returns_correctly()
    {
        $this->httpClient
            ->method("request")
            ->willReturn(new Response("200", '{"puuid":"123456789","gameName":"Mad Freestyle","tagLine":"BR1"}'));

        $puuid = $this->riotApiClient->get_puuid("Mad Freestyle", "BR1");

        $this->assertSame("123456789", $puuid);
    }

    #[Test]
    public function should_throw_exception_for_player_not_found()
    {
        $this->httpClient
            ->method("request")
            ->willReturn(new Response("404", '{"status":{"status_code":404,"message":"Data not found - No results found for player with riot id Mad Freestyle1#BR1"}}'));
        $userName = "Mad Freestyle1";
        $tag = "BR1";

        $this->expectException(PlayerNotFound::class);
        $this->expectExceptionMessage("Data not found - No results found for player with riot id {$userName}#{$tag}");
        $this->riotApiClient->get_puuid($userName, $tag);
    }
}