<?php

namespace Riot\Map\PlotsType;

use Riot\Image;
use Riot\Map\Analyzers\Analyzer;
use Riot\Map\Analyzers\AnalyzerInterface;
use Riot\Map\MapsType\Map;

class PlotKillDeath implements PlotTypeInterface
{
    #[\Override]
    public function plot(Map $map): string
    {
        return (new Image())
            ->plotPositions($this, $map->getAnalyzer());
    }

    #[\Override]
    public function getPositions(AnalyzerInterface $analyzer): array
    {
        return array_merge(
            $analyzer->getKillPositions(),
            $analyzer->getDeathPositions()
        );
    }
}