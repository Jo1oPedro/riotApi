<?php

namespace Riot\Api\map\PlotsType;

use Riot\Api\Image;
use Riot\Api\map\Analyzers\Analyzer;
use Riot\Api\map\MapsType\Map;

interface PlotType
{
    public function plot(Analyzer $analyzer, Map $map): Image;
}