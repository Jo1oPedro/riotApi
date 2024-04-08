<?php

namespace Riot\Api\map\PlotsType;

use Riot\Api\Image;
use Riot\Api\map\Analyzers\Analyzer;
use Riot\Api\map\MapsType\Map;

class PlotAssist implements PlotType
{
    #[\Override]
    public function plot(Analyzer $analyzer, Map $map): Image
    {
        return (new Image())
            ->plotPositions($analyzer->getAssistPositions(), $map->getMapImage());
    }
}