<?php

namespace Riot\Api;

use PDO;
use Riot\Database\Connection;
use Riot\Helper\Curl;

class RiotApiClientProxy implements RiotApiClientInterface
{
    private $riotApiClient = "";
    private PDO $pdo;

    public function __construct(
        private string $riotKey,
    ) {
        $this->riotApiClient = new RiotApiClient($this->riotKey);
        $this->pdo = Connection::getInstance();
    }

    public function get_puuid(string $userName, string $tag): string
    {
        $stmt = $this->pdo->prepare("SELECT puuid FROM users WHERE name = :name AND tag = :tag");
        $stmt->execute(["name" => $userName, "tag" => $tag]);
        if($user = $stmt->fetch()) {
            return $user->puuid;
        }
        $puuid = $this->riotApiClient->get_puuid($userName, $tag);
        $stmt = $this->pdo->prepare("INSERT INTO users (puuid, name, tag) VALUES (:puuid, :name, :tag)");
        $stmt->execute(["puuid" => $puuid, "name" => $userName, "tag" => $tag]);
        return $puuid;
    }

    public function getMatchesId(string $puuid, int $count = 20, string $type = "normal", $jsonDecode = true): array|string
    {
        return $this->riotApiClient->getMatchesId($puuid, $count, $type, $jsonDecode);
    }

    public function getMatchInfo(string $matchId, $jsonDecode = true): \stdClass|string
    {
        return $this->riotApiClient->getMatchInfo($matchId, $jsonDecode);
    }

    public function getMatchInfoTimeline(string $matchId, $jsonDecode = true): \stdClass|string
    {
        return $this->riotApiClient->getMatchInfoTimeline($matchId, $jsonDecode);
    }
}