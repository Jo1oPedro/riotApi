<?php

namespace Riot\Api\map\Analyzers;

use Riot\Api\map\Plots\AssistPlot;
use Riot\Api\map\Plots\DeathPlot;
use Riot\Api\map\Plots\KillPlot;

class SlaughterParticipation implements Analyzer
{
    private array $killPositions = [];
    private array $assistPositions = [];
    private array $deathPositions = [];

    public function getKillPositions(): array
    {
        return $this->killPositions;
    }

    public function getAssistPositions(): array
    {
        return $this->assistPositions;
    }

    public function getDeathPositions(): array
    {
        return $this->deathPositions;
    }

    #[\Override]
    public function analyze(\stdClass $matchInfo, string $puuid): Analyzer
    {
        $participants = $matchInfo->info->participants;
        foreach($participants as $participant) {
            if($participant->puuid === $puuid) {
                $participantId = $participant->participantId;
            }
        }

        $frames = $matchInfo->info->frames;
        foreach($frames as $frame) {
            foreach($frame->events as $event) {
                if($event->type === "CHAMPION_KILL") {
                    if($event->killerId === $participantId) {
                        $this->killPositions[] = (new KillPlot())->setX($event->position->x)->setY($event->position->y);
                        continue;
                    }
                    if(isset($event->assistingParticipantIds) && in_array($participantId, $event->assistingParticipantIds)) {
                        $this->assistPositions[] = (new AssistPlot())->setX($event->position->x)->setY($event->position->y);
                        continue;
                    }
                    if($event->victimId === $participantId) {
                        $this->deathPositions[] = (new DeathPlot())->setX($event->position->x)->setY($event->position->y);
                    }
                }
            }
        }

        return $this;
    }
}