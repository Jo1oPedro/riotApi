<?php

namespace App\Tests\Http;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use App\Client\RiotApiClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

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
    public function get_puuid_returns_correctly_formated_data()
    {
        $this->httpClient
            ->method("request")
            ->willReturn("");

        $this->httpClient
            ->method("ToArray")
            ->willReturn(["puuid" => "123456789"]);

        $puuid = $this->riotApiClient->get_puuid("CascataXFrontEnd", "BR1");;

        $this->assertSame("123456789", $puuid);
    }
}