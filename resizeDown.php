<?php

ini_set("memory_limit", "-1");
// Load the source image
$sourceImage = imagecreatefrompng('graph_with_resized_background2.png');

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
imagepng($newImage, 'graph_with_resized_background3.png');

// Free up memory
imagedestroy($sourceImage);
imagedestroy($newImage);

echo 'Image resized successfully.';

