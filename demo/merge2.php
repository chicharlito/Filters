<?php
// Création des instances d'image
$width = 500;
$height = 500;

$src = imagecreatefrompng('../filters/noel4.png');

$image_p = imagecreatetruecolor($width, $height);
$dest = imagecreatefrompng('../filters/pays_de_galles.png');
imagecopyresampled($image_p, $dest, 0, 0, 0, 0, $width, $height, 900, 900);

/*$w = imagesx($dest);
$h = imagesy($dest);*/
imagealphablending($src,true);

// Copie et fusionne
imagecopymerge($image_p, $src, 0, 100, 0, 100, 500, 500, 100);

// Affichage et libération de la mémoire
header('Content-Type: image/png');
imagepng($image_p,"monimage2.png");
?>