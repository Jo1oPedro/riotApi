<?php

ini_set("memory_limit", "-1");
// Create a blank image with specified dimensions
$image = imagecreatetruecolor(16500, 16000);

// Load the background image
$backgroundImage = imagecreatefrompng(__DIR__ . '/MapsImage/img-lol-map.png'); // Provide path to your background image

// Get the dimensions of the background image
$bgWidth = imagesx($backgroundImage);
$bgHeight = imagesy($backgroundImage);

// Calculate scaling factors to fit the background image within the graph dimensions
$scaleX = 16500 / $bgWidth;
$scaleY = 16000 / $bgHeight;
$scale = min($scaleX, $scaleY);

// Calculate new dimensions for the resized background image
$newWidth = $bgWidth * $scale;
$newHeight = $bgHeight * $scale;

// Create a resized version of the background image
$resizedBackground = imagecreatetruecolor($newWidth, $newHeight);
imagecopyresampled($resizedBackground, $backgroundImage, 0, 0, 0, 0, $newWidth, $newHeight, $bgWidth, $bgHeight);

// Copy the resized background image onto the blank image
imagecopy($image, $resizedBackground, 0, 0, 0, 0, $newWidth, $newHeight);

// Allocate colors
$black = imagecolorallocate($image, 0, 0, 0);
$blue = imagecolorallocate($image, 0, 0, 255);

// Draw x and y axes
imageline($image, 0, 8000, 16500, 8000, $black); // x-axis
imageline($image, 8250, 0, 8250, 16000, $black); // y-axis

// Draw a sample plot point
$x = 12375; // x-coordinate
$y = 8000; // y-coordinate
$radius = 5; // point size
imagefilledellipse($image, $x, $y, $radius, $radius, $blue);

// Output image to browser or save to a file
header('Content-type: image/png');
imagepng($image, __DIR__ . '/MapsImage/classic_map_1516k_px.png'); // Save image to file

// Free up memory
imagedestroy($image);
imagedestroy($backgroundImage);
imagedestroy($resizedBackground);
?>
