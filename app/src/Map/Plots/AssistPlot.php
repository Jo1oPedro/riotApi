<?php

namespace App\Map\Plots;

class AssistPlot extends Plot
{
    private $greenRgb = [0,255,0];
    #[\Override]
    public function getRgb()
    {
        return $this->greenRgb;
    }
}