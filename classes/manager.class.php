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
			define("WIDTH", 900);
			define("HEIGHT", 900);
			$filterPath = "filters/HD/".$filter.".png";
			$backgroundPath = htmlentities($background);
			$imageSize = getimagesize($backgroundPath);
			$widthBG = $imageSize[0];
			$heightBG = $imageSize[1];

			$filter = imagecreatefrompng($filterPath);
			imagealphablending($filter,true);

			$image_p = imagecreatetruecolor(WIDTH, WIDTH);
			$dest = imagecreatefromjpeg($backgroundPath);
			imagecopyresampled($image_p, $dest, 0, 0, 0, 0, WIDTH, WIDTH, $widthBG, $heightBG);

			/*$w = imagesx($dest);
			$h = imagesy($dest);*/
			
			
			/*$white = imagecolorallocate($image_p, 255, 255, 255); 
			imagecolortransparent ( $image_p , $white );*/
			imagealphablending($image_p, true);

			// Copie et fusionne
			imagecopy($image_p, $filter, 0, 0, 0, 0, WIDTH, WIDTH);
			
			$auj = date('d-m-Y');
			$mili = time();
			
			$ext = $auj."-".$mili;
			$imgToSave = "imgs/img_".$ext.".png";

			// Affichage et libération de la mémoire
			imagepng($image_p,$imgToSave);
			echo "<img src=\"".$imgToSave."\" class=\"img-result\" /><hr /><a href=\"index.php\" id=\"restart\" class=\"btn btn-restart\">Recommencer</a>
					<a href=\"".$imgToSave."\" download id=\"download\" class=\"btn btn-facebook\">Télécharger</a>";
		}
		
		public function getFiltres($categorieId){
			$id = (int) $categorieId;
			$q = "SELECT * FROM filtres WHERE id_categorie=:id";
			$sth = $this->_dbh->prepare($q);
			$sth->bindParam(":id",$id,PDO::PARAM_INT);
			$sth->execute();
			
			$qr = "SELECT path FROM categories WHERE id=:id";
			$sth2 = $this->_dbh->prepare($qr);
			$sth2->bindParam(":id",$id,PDO::PARAM_INT);
			$sth2->execute();
			
			$path = $sth2->fetch();
			$path = $path[0];
			
			$output = $sth->fetchAll(PDO::FETCH_ASSOC);
			
			$result = "";
			
			foreach($output as $data){
				$result .= "<img src=\"filters/".$path."/".$data['path'].".png\" alt=\"".$data['nom']."\" id=\"".$path."/".$data['path']."\" class=\"img-thumbnail col-lg-3 thmbs\">";
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