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
    public function should_return_puuid_correctly()
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

    #[Test]
    public function should_return_matches_id_correctly()
    {
        $matchesId = '["BR1_2925730714","BR1_2925713324","BR1_2925688737","BR1_2925255743","BR1_2925233603","BR1_2925216479","BR1_2925198267","BR1_2923547621","BR1_2923259595","BR1_2923247695","BR1_2923181301","BR1_2920235070","BR1_2916654118","BR1_2916629545","BR1_2916396525","BR1_2916380484","BR1_2916365075","BR1_2916156285","BR1_2916141449","BR1_2916119747"]';
        $this->httpClient
            ->method("request")
            ->willReturn(new Response(200, $matchesId));

        $matchesId = $this->riotApiClient->getMatchesId("123456789");

        $this->assertSame(
            $matchesId,
            $matchesId
        );
    }
}