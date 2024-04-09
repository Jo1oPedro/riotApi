<?php

namespace Riot\Map\PlotsType;

use Riot\Image;
use Riot\Map\Analyzers\Analyzer;
use Riot\Map\MapsType\Map;

class PlotAssist implements PlotType
{
    #[\Override]
    public function plot(Analyzer $analyzer, Map $map): Image
    {
        return (new Image())
            ->plotPositions($analyzer->getAssistPositions(), $map->getMapImage());
    }
}