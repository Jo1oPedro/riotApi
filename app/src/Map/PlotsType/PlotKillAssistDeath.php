<?php

namespace Riot\Map\PlotsType;

use Riot\Image;
use Riot\Map\Analyzers\AnalyzerInterface;
use Riot\Map\MapsType\Map;

class PlotKillAssistDeath implements PlotTypeInterface
{

    #[\Override]
    public function plot(Map $map): string
    {
        return (new Image())
            ->plotPositions($this, $map);
    }

    #[\Override]
    public function getPositions(AnalyzerInterface $analyzer): array
    {
        return array_merge(
            $analyzer->getKillPositions(),
            $analyzer->getAssistPositions(),
            $analyzer->getDeathPositions()
        );
    }
}