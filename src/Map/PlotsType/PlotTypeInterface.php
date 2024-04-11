<?php

namespace Riot\Map\PlotsType;

use Riot\Image;
use Riot\Map\Analyzers\AnalyzerInterface;
use Riot\Map\MapsType\Map;

interface PlotTypeInterface
{
    public function plot(Map $map): string;
    public function getPositions(AnalyzerInterface $analyzer): array;
}