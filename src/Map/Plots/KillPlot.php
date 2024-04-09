<?php

namespace Riot\Map\Plots;

class KillPlot extends Plot
{
    private $blueRgb = [0,0,255];
    #[\Override]
    public function getRgb()
    {
        return $this->blueRgb;
    }
}