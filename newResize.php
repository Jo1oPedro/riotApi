<?php

ini_set("memory_limit", "-1");

// Create a blank image with specified dimensions
$image = imagecreatetruecolor(16000, 16000);

// Load the background image
$backgroundImage = imagecreatefrompng(__DIR__ . '/MapsImage/img-lol-map.png'); // Replace with the path to your background image

// Get the dimensions of the background image
$bgWidth = imagesx($backgroundImage);
$bgHeight = imagesy($backgroundImage);

// Copy and resize the background image to fill the square
$resizedBackground = imagecreatetruecolor(16000, 16000);
imagecopyresized($resizedBackground, $backgroundImage, 0, 0, 0, 0, 16000, 16000, $bgWidth, $bgHeight);

// Copy the resized background image onto the blank image
imagecopy($image, $resizedBackground, 0, 0, 0, 0, 16000, 16000);

// Allocate colors
$black = imagecolorallocate($image, 0, 0, 0);
$blue = imagecolorallocate($image, 0, 0, 255);

// Draw x and y axes
imageline($image, 0, 8000, 16000, 8000, $black); // x-axis
imageline($image, 8000, 0, 8000, 16000, $black); // y-axis

// Draw a sample plot point
$x = 12000; // x-coordinate
$y = 8000; // y-coordinate
$radius = 5; // point size
imagefilledellipse($image, $x, $y, $radius, $radius, $blue);

// Output image to browser or save to a file
header('Content-type: image/png');
imagepng($image,  __DIR__ . '/MapsImage/classic_map_16kx16k.png'); // Save image to file

// Free up memory
imagedestroy($image);
imagedestroy($backgroundImage);
imagedestroy($resizedBackground);
?>
