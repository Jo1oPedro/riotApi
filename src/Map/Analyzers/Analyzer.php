<?php

namespace Riot\Map\Analyzers;

interface Analyzer
{
    public function analyze(\stdClass $matchInfo, string $puuid): Analyzer;
}