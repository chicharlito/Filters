<?php
	//$image1 = $_POST['imageData'];
	
	// base64_to_png($image1, 'filename.png');
	
	$src = imagecreatefrompng('../filters/noel4.png');	
	$dest = imagecreatefrompng('../filters/pays_de_galles.png');

	imagealphablending($dest, false);
	imagesavealpha($dest, true);

	imagecopymerge($dest, $src, 10, 9, 0, 0, 181, 180, 100); //have to play with these numbers for it to work for you, etc.
	
	function base64_to_png($base64_string, $output_file) {
		$ifp = fopen($output_file, "wb"); 

		$data = explode(',', $base64_string);

		fwrite($ifp, base64_decode($data[1])); 
		fclose($ifp); 

		return $output_file; 
	}
	
	imagepng($dest);
	
	// echo base64_encode($result);
	
	// echo $result;