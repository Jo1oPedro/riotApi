<?php

namespace App\Tests\Http;

use App\Client\HttpClientInterface;
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
            ->willReturn(["puuid" => "123456789"]);

        $puuid = $this->riotApiClient->get_puuid("CascataXFrontEnd", "BR1");

        $this->assertSame("123456789", $puuid);
    }
}