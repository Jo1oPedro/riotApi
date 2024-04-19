<?php

namespace App\Map\PlotsType;

use App\Image;
use App\Map\Analyzers\Analyzer;
use App\Map\Analyzers\AnalyzerInterface;
use App\Map\MapsType\Map;

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