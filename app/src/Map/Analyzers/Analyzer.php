<?php

namespace Riot\Map\Analyzers;

use Riot\Map\Analyzers\AnalyzerInterface;
use stdClass;

abstract class Analyzer implements AnalyzerInterface
{
    protected string $matchId = "";
    public function getMatchId(): string
    {
        return $this->matchId;
    }

    /**
     * @param stdClass[] $participants
     * @param string[] $puuid
     * @return string[]
     */
    protected function getParticipantsId(array $participants, array $puuids): array
    {
        $participantsId = [];
        foreach($participants as $participant) {
            if(in_array($participant->puuid, $puuids)) {
                $participantsId[] = $participant->participantId;
            }
        }
        return $participantsId;
    }
}