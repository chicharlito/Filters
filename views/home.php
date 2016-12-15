<!DOCTYPE html>
<html>
  <head>
	<meta charset="UTF-8">
    <title>cropit</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script src="dist/jquery.cropit.js"></script>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="src/bootstrap-cstm.css" type="text/css" />
	<link rel="stylesheet" href="src/style.css" type="text/css" />
	<link rel="stylesheet" href="src/styles.css" type="text/css" />
	
  </head>
  <body>
	<div id="overlay" class="text-center">
		<div id="loader" class="text-center">
			<div class='uil-ripple-css' style='transform:scale(0.6);'><div></div><div></div></div>
			<h3>Création de l'image...</h3>
		</div>
	</div>
	<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Brand</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">     
        <li><a>Filtres personnalisés pour photos de profil Facebook</a></li>       
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
	<div class="row">
		<div class="container">
			<div class="image-editor"><div id="overlay-editor" class="text-center"><img src="src/imgs/swipe-up.png" /><h2>Pour commencer, chargez une image de votre ordinateur</h2></div>
					<div class="col-lg-12 text-center" id="fileInput">
						<input type="file" id="chooseFile" class="btn btn-lg btn-primary cropit-image-input">
					</div><hr />
				<div class="col-lg-6 first">
				  <div class="cropit-preview"></div>
				  <img src="filters/noel1.png" class="filter" id="filterId" name="noel4"/>
				  <div class="resize">
						<i class="fa fa-search-minus fa-lg" aria-hidden="true" id="minus"></i>
							<input type="range" class="cropit-image-zoom-input">
						<i class="fa fa-search-plus fa-lg" aria-hidden="true" id="plus"></i>
				  </div>
				  <button class="rotate-ccw btn btn-default"><i class="fa fa-undo" aria-hidden="true"></i></i></button>
				  <button class="rotate-cw btn btn-default"><i class="fa fa-repeat" aria-hidden="true"></i></button>
				</div>
				<div class="col-lg-6 text-center second">
					<h4>Choisissez parmis les filtres originaux</h4>
					<select id="selectFilter" class="form-control">						
					  <?php 
						echo $categories;
					  ?>
					</select>
					<div id="resultFilters" class="text-center"></div>
					<button class="export btn btn-annule" id="reset">Annuler</button>
					<button class="export btn btn-facebook" id="generate">Générer !</button>
				</div>
			</div>
		</div>
	</div>
    

    <script>
      $(function() {
		Lg = $(".cropit-preview").width();
		$(".cropit-preview").height(Lg);
		LgFirst = $(".first").height();
		$(".second").height(LgFirst);
		
		$("#fileInput").on("click","#chooseFile",function(){
			$("#overlay-editor").fadeOut();
		})
		
        $('.image-editor').cropit({
          exportZoom: 1.25,
          imageBackground: true,
          imageBackgroundBorderWidth: 20,
          imageState: {
            src: 'filters/empty.png',
          },
        });

        $('.rotate-cw').click(function() {
          $('.image-editor').cropit('rotateCW');
        });
        $('.rotate-ccw').click(function() {
          $('.image-editor').cropit('rotateCCW');
        });

        $('.export').click(function() {
		  $("#overlay").show();
          var imageData = $('.image-editor').cropit('export',{type: 'image/jpeg',quality: 1,originalSize: true});
		  var filter = $("#filterId").attr("name");
		  url = "index.php";
		  $.ajax({
			  type: "POST",
			  url: url,
			  data: {"imageData" : imageData, "filter":filter},
			  success:function(data){
				  $("#loader").empty().append(data);
			  }
			});
        });
		
		$("#resultFilters").on("click",".img-thumbnail",function(){
			src = $(this).attr("id");
			Nsrc = "filters/" + src + ".png";
			$("#filterId").attr("src", Nsrc);
			$("#filterId").attr("name", src);
		});
		
		$("#selectFilter").change(function () {
			$("#resultFilters").empty().append("<img src=\"src/imgs/loader.gif\" style=\"margin-top:50px;\" />");
			var id = $( "#selectFilter option:selected").attr("id");
			url = "index.php";
			  $.ajax({
				  type: "POST",
				  url: url,
				  data: {"categorieId" : id},
				  success: function(data){
					  $("#resultFilters").empty().append(data);
				  }
				});
		  });
		
      });
    </script>
	<script src="https://use.fontawesome.com/3ea4e2de6c.js"></script>
  </body>
</html>