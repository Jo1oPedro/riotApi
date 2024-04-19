<?php

namespace App\Map\Plots;

class DeathPlot extends Plot
{
    private $redRgb = [255,0,0];
    #[\Override]
    public function getRgb()
    {
        return $this->redRgb;
    }

}