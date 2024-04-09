<?php

namespace Riot\Map\PlotsType;

use Riot\Image;
use Riot\Map\Analyzers\Analyzer;
use Riot\Map\MapsType\Map;

class PlotKillAssistDeath implements PlotType
{

    #[\Override]
    public function plot(Analyzer $analyzer, Map $map): Image
    {
        return (new Image())
            ->plotPositions(
                array_merge(
                    $analyzer->getKillPositions(),
                    $analyzer->getAssistPositions(),
                    $analyzer->getDeathPositions()
                ),
                $map->getMapImage()
            );
    }
}