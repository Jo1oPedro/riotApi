<?php

namespace Riot\Api\map\MapsType;

use Riot\Api\map\Analyzers\Analyzer;
use Riot\Api\map\PlotsType\PlotType;

abstract class Map
{
    private Analyzer $analyzer;

    public function analyzeMap(Analyzer $analyzer, \stdClass $matchInfo, string $puuid): Map
    {
        $this->analyzer = $analyzer->analyze($matchInfo, $puuid);
        return $this;
    }

    public function plotOnMap(PlotType $plot, bool $resize = true)
    {
        return ($resize) ? $plot->plot($this->analyzer, $this)->resizeDown() : $plot->plot($this->analyzer, $this);
    }

    public abstract function getMapImage(): string;
}