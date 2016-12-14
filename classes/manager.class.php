<?php

	class manager
	{
		private $_dbh;
		
		
		public function __construct($dbh){
			$this->_dbh = $dbh;
		}
		
		public function test(){
			echo "Hello World !";
		}
		
		public function createImage($background,$filter){
			define("WIDTH", 500);
			define("HEIGHT", 500);
			$filterPath = "filters/".$filter.".png";
			$backgroundPath = htmlentities($background);
			$imageSize = getimagesize($backgroundPath);
			$widthBG = $imageSize[0];
			$heightBG = $imageSize[1];

			$src = imagecreatefrompng($filterPath);

			$image_p = imagecreatetruecolor(WIDTH, WIDTH);
			$dest = imagecreatefrompng($backgroundPath);
			imagecopyresampled($image_p, $dest, 0, 0, 0, 0, WIDTH, WIDTH, $widthBG, $heightBG);

			/*$w = imagesx($dest);
			$h = imagesy($dest);*/
			imagealphablending($src,true);

			// Copie et fusionne
			imagecopymerge($image_p, $src, 0, 0, 0, 0, WIDTH, WIDTH, 100);
			
			$auj = date('d-m-Y');
			$mili = time();
			
			$ext = $auj."-".$mili;
			$imgToSave = "imgs/img_".$ext.".png";

			// Affichage et libération de la mémoire
			imagepng($image_p,$imgToSave);
		}
		
		public function getFiltres($categorieId){
			$id = (int) $categorieId;
			$q = "SELECT * FROM filtres WHERE id_categorie=:id";
			$sth = $this->_dbh->prepare($q);
			$sth->bindParam(":id",$id,PDO::PARAM_INT);
			$sth->execute();
			
			$output = $sth->fetchAll(PDO::FETCH_ASSOC);
			
			$result = "";
			
			foreach($output as $data){
				$result .= "<img src=\"filters/".$data['path'].".png\" alt=\"".$data['nom']."\" id=\"".$data['nom']."\" class=\"img-thumbnail col-lg-3\">";
			}
			
			echo $result;
		}
		
		public function getCategories(){
			$q = "SELECT * FROM categories";
			$sth = $this->_dbh->query($q);
			
			$output = $sth->fetchAll(PDO::FETCH_ASSOC);
			
			$categories = "";
			
			foreach($output as $data){
				$categories .= "<option id=\"".$data['id']."\">".$data['nom']."</option>";
			}
			
			return $categories;
		}
	}