<?php

namespace Riot\Api\map\PlotsType;

use Riot\Api\Image;
use Riot\Api\map\Analyzers\Analyzer;
use Riot\Api\map\MapsType\Map;

class PlotAssistDeath implements PlotType
{
    #[\Override]
    public function plot(Analyzer $analyzer, Map $map): Image
    {
        return (new Image())
            ->plotPositions(
                array_merge(
                    $analyzer->getAssistPositions(),
                    $analyzer->getDeathPositions()
                ),
                $map->getMapImage()
            );
    }
}