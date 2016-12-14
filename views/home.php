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
	
  </head>
  <body>
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
			<div class="image-editor">
				<div class="col-lg-6">
				  <input type="file" class="cropit-image-input">
				  <div class="cropit-preview"></div>
				  <img src="filters/noel4.png" class="filter" id="filterId" name="noel4"/>
				  <div class="image-size-label">
					Resize image
				  </div>
				  <input type="range" class="cropit-image-zoom-input">
				  <button class="rotate-ccw btn btn-default"><i class="fa fa-undo" aria-hidden="true"></i></i></button>
				  <button class="rotate-cw btn btn-default"><i class="fa fa-repeat" aria-hidden="true"></i></button>
				  <button class="export btn btn-success">Générer !</button>
				</div>
				<div class="col-lg-6">
					<select id="selectFilter" class="form-control">
					  <?php 
						echo $categories;
					  ?>
					</select>
					
					<div id="resultFilters"></div>
				</div>
			</div>
		</div>
	</div>
    

    <script>
      $(function() {
		Lg = $(".cropit-preview").width();
		$(".cropit-preview").height(Lg);
        $('.image-editor').cropit({
          exportZoom: 1.25,
          imageBackground: true,
          imageBackgroundBorderWidth: 20,
          imageState: {
            src: 'http://lorempixel.com/500/400/',
          },
        });

        $('.rotate-cw').click(function() {
          $('.image-editor').cropit('rotateCW');
        });
        $('.rotate-ccw').click(function() {
          $('.image-editor').cropit('rotateCCW');
        });

        $('.export').click(function() {
          var imageData = $('.image-editor').cropit('export');
		  var filter = $("#filterId").attr("name");
		  url = "index.php";
		  $.ajax({
			  type: "POST",
			  url: url,
			  data: {"imageData" : imageData, "filter":filter}
			});
        });
		
		$("#resultFilters").on("click",".img-thumbnail",function(){
			src = $(this).attr("id");
			Nsrc = "filters/" + src + ".png";
			$("#filterId").attr("src", Nsrc);
			$("#filterId").attr("name", src);
		});
		
		$("#selectFilter").change(function () {
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