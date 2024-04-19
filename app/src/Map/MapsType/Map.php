<?php

namespace App\Map\MapsType;

use App\Map\Analyzers\AnalyzerInterface;
use App\Map\PlotsType\PlotType;
use App\Map\PlotsType\PlotTypeInterface;

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