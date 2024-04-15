<?php

namespace Riot\Map\Analyzers;

interface AnalyzerInterface
{
    public function analyze(\stdClass $matchInfo, array $puuids): AnalyzerInterface;
}