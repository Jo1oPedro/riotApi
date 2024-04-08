<?php

namespace Riot\Api\map\Analyzers;

interface Analyzer
{
    public function analyze(\stdClass $matchInfo, string $puuid): Analyzer;
}