<?php

namespace App\Map\Analyzers;

interface AnalyzerInterface
{
    public function analyze(\stdClass $matchInfo, array $puuids): AnalyzerInterface;
}