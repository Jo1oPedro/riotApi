<?php

namespace Riot\Api\map\MapsType;

class AramMap extends Map
{
    #[\Override]
    public function getMapImage(): string
    {
        return "aram_map_16k_px.png";
    }
}