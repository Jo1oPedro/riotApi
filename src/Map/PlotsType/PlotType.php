<?php

namespace Riot\Map\PlotsType;

use Riot\Image;
use Riot\Map\Analyzers\Analyzer;
use Riot\Map\MapsType\Map;

interface PlotType
{
    public function plot(Analyzer $analyzer, Map $map): Image;
}