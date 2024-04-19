<?php

namespace App\Map\PlotsType;

use App\Image;
use App\Map\Analyzers\AnalyzerInterface;
use App\Map\MapsType\Map;

interface PlotTypeInterface
{
    public function plot(Map $map): string;
    public function getPositions(AnalyzerInterface $analyzer): array;
}