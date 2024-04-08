<?php

namespace Riot\Api\map\Plots;

use Riot\Api\Image;

abstract class Plot
{
    private string $x = "";
    private string $y = "";

    public function setX(string $x): Plot
    {
        $this->x = $x;
        return $this;
    }
    public function setY(string $y): Plot
    {
        $this->y = $y;
        return $this;
    }

    public function getX(): string
    {
        return $this->x;
    }
    public function getY(): string
    {
        return $this->y;
    }

    public abstract function getRgb();
}