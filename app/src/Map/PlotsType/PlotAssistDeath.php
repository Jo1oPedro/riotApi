<?php

namespace App\Map\PlotsType;

use App\Image;
use App\Map\Analyzers\AnalyzerInterface;
use App\Map\MapsType\Map;

class PlotAssistDeath implements PlotTypeInterface
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
            $analyzer->getAssistPositions(),
            $analyzer->getDeathPositions()
        );
    }
}