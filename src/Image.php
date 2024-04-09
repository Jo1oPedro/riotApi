<?php

namespace Riot;

use Riot\Map\Plots\Plot;

class Image
{
    /**
     * @param Plot[] $plots
     * @return $this
     */
    public function plotPositions(array $plots, string $map): Image
    {
        $map = imagecreatefrompng(__DIR__ . "/../MapsImage/{$map}");

        // Loop through each plot and put the corresponding number on the Map
        foreach ($plots as $plot) {
            $color = imagecolorallocate($map, ...$plot->getRgb());
            $x = $plot->getX() - 400;
            $y = 16000 - $plot->getY();
            $number = ".";
            imagettftext($map, 3500/*5000*/, 0, $x, $y, $color, __DIR__ . "/../Montserrat-VariableFont_wght.ttf", $number);
        }

        // Output the modified Map with numbers
        imagepng($map, __DIR__ . "/../MapsImage/plotedKillAssistMap.png");

        // Free up memory
        imagedestroy($map);
        return $this;
    }

    public function resizeDown()
    {
        $sourceImage = imagecreatefrompng(__DIR__ . "/../MapsImage/plotedKillAssistMap.png");

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
        imagepng($newImage, __DIR__ . "/../MapsImage/plotedKillAssistMapResized.png");

        // Free up memory
        imagedestroy($sourceImage);
        imagedestroy($newImage);
    }
}