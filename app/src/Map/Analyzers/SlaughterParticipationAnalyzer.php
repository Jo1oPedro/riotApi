<?php

namespace App\Map\Analyzers;

use App\Map\Analyzers\Analyzer;
use App\Map\Plots\AssistPlot;
use App\Map\Plots\DeathPlot;
use App\Map\Plots\KillPlot;
use stdClass;

class SlaughterParticipationAnalyzer extends Analyzer
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

    private function setPositions(array $frames, array $participantsId): void
    {
        foreach($frames as $frame) {
            foreach($frame->events as $event) {
                if($event->type === "CHAMPION_KILL") {
                    if(in_array($event->killerId, $participantsId)) {
                        $this->killPositions[] = (new KillPlot())->setX($event->position->x)->setY($event->position->y);
                        continue;
                    }
                    if(isset($event->assistingParticipantIds) && $assistantsId = array_intersect($participantsId, $event->assistingParticipantIds)) {
                        $this->assistPositions[] = (new AssistPlot())->setX($event->position->x)->setY($event->position->y);
                        continue;
                    }
                    if(in_array($event->victimId, $participantsId)) {
                        $this->deathPositions[] = (new DeathPlot())->setX($event->position->x)->setY($event->position->y);
                    }
                }
            }
        }
    }

    /**
     * @param stdClass $matchInfo
     * @param string[] $puuids
     * @return AnalyzerInterface
     */
    #[\Override]
    public function analyze(stdClass $matchInfo, array $puuids): AnalyzerInterface
    {
        $this->matchId = $matchInfo->metadata->matchId;
        $participantsId = $this->getParticipantsId($matchInfo->info->participants, $puuids);
        $this->setPositions($matchInfo->info->frames, $participantsId);

        return $this;
    }
}