<?php

namespace Riot;

use Riot\Map\MapsType\Map;
use Riot\Map\PlotsType\PlotTypeInterface;

class Image
{
    /**
     * @param PlotTypeInterface $plotType
     * @param Map $map
     * @return string
     */
    public function plotPositions(PlotTypeInterface $plotType, Map $map): string
    {
        $reflectionPlot = new \ReflectionClass($plotType);
        $mapImage = imagecreatefrompng(__DIR__ . "/../MapsImage/{$map->getMapImage()}");

        // Loop through each plot and put the corresponding number on the Map
        foreach ($plotType->getPositions($map->getAnalyzer()) as $plot) {
            $color = imagecolorallocate($mapImage, ...$plot->getRgb());
            $x = $plot->getX() - 100;
            $y = 16000 - $plot->getY();
            $number = ".";
            imagettftext($mapImage, 3500/*5000*/, 0, $x, $y, $color, __DIR__ . "/../Montserrat-VariableFont_wght.ttf", $number);
        }

        // Output the modified Map with numbers
        $imageName = "{$map->getAnalyzer()->getMatchId()}&{$reflectionPlot->getShortName()}.png";
        imagepng($mapImage, __DIR__ . "/../MapsImage/{$imageName}");

        // Free up memory
        imagedestroy($mapImage);

        $this->resizeDown($imageName);
        return $imageName;
    }

    private function resizeDown(string $imageName)
    {
        $sourceImage = imagecreatefrompng(__DIR__ . "/../MapsImage/{$imageName}");

        // Get the dimensions of the source image
        $sourceWidth = imagesx($sourceImage);
        $sourceHeight = imagesy($sourceImage);

        // Define the new dimensions
        $newWidth = 304;
        $newHeight = 304;

        // Create a new image with the new dimensions
        $newImage = imagecreatetruecolor($newWidth, $newHeight);

        // Resize the source image to the new dimensions
        imagecopyresampled($newImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $sourceWidth, $sourceHeight);

        // Save the resized image
        imagepng($newImage, __DIR__ . "/../MapsImage/{$imageName}");

        // Free up memory
        imagedestroy($sourceImage);
        imagedestroy($newImage);
    }
}