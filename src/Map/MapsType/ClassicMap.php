<?php

namespace Riot\Map\MapsType;

class ClassicMap extends Map
{
    public function getMapImage(): string
    {
        return "classic_map_16k_px.png";
    }
}