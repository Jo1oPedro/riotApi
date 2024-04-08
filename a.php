<?php

ini_set("memory_limit", "-1");
// Load the original map image
$map = imagecreatefrompng(__DIR__ . '/classic_map_16k_px.png');

// Define some sample coordinates and numbers to put on the map
$coordinates = array(
    array('x' => 12379, 'y' => 2035, 'number' => "."),
    array('x' => 13520, 'y' => 3766, 'number' => "."),
    array('x' => 8958, 'y' => 3883, 'number' => "."),
    array('x' => 6437, 'y' => 9507, 'number' => "."),
    array('x' => 10167, 'y' => 10243, 'number' => "."),
    array('x' => 11197, 'y' => 6483, 'number' => "."),
    array('x' => 13469, 'y' => 12819, 'number' => "."),
    #array('x' => 3000, 'y' => 4000, 'number' => "."),
    // Add more coordinates as needed
);

// Define the color for the numbers
$color = imagecolorallocate($map, 128, 0, 128); // Purple color

// Loop through each coordinate and put the corresponding number on the map
foreach ($coordinates as $point) {
    $x = $point['x'];
    $y = $point['y'];
    $number = $point['number'];
    imagettftext($map, 5000, 0, $x, $y, $color, __DIR__ . "/Montserrat-VariableFont_wght.ttf", $number); // No font file specified
}

// Output the modified map with numbers
imagepng($map, 'graph_with_resized_background2.png');

// Free up memory
imagedestroy($map);
?>
