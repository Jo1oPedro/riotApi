<?php

namespace Riot\Map\MapsType;

use Riot\Map\Analyzers\AnalyzerInterface;
use Riot\Map\PlotsType\PlotType;
use Riot\Map\PlotsType\PlotTypeInterface;

abstract class Map
{
    private AnalyzerInterface $analyzer;

    public function analyzeMap(AnalyzerInterface $analyzer, \stdClass $matchInfo, array $puuids): Map
    {
        $this->analyzer = $analyzer->analyze($matchInfo, $puuids);
        return $this;
    }

    public function plotOnMap(PlotTypeInterface $plot)
    {
        return $plot->plot($this);
    }

    public function getAnalyzer()
    {
        return $this->analyzer;
    }

    public abstract function getMapImage(): string;
}