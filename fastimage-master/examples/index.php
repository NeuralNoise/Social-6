<?php

require '../Fastimage.php';

$uri = 'http://www.codemymobile.com/services';

echo "\n\n";

$time = microtime(true);
$image = new FastImage($uri);
list($width, $height) = $image->getSize();
echo "FastImage: \n";
echo "Width: ". $width . "px Height: ". $height . "px in " . (microtime(true)-$time) . " seconds \n";

$time = microtime(true);
list($width, $height) = getimagesize($uri);
echo "getimagesize: \n";
echo "Width: ". $width . "px Height: ". $height . "px in " . (microtime(true)-$time) . " seconds \n";
exit;