<!DOCTYPE html>
<html>
  <head>
  	<style type="text/css">
  	
  	iframe{
  		
  		position: absolute;
  		top:100px; 
  		left:110px;
  		width:400px; 
  		height:400px;
  		border:10px;
  		background-image: url('images/pic.jpg');
  		background-position: center center;
  		background-repeat: no-repeat;
  


  	}

  	img{
  		
  		z-index: 2;
  		position: absolute;
  		top:100px; 
  		left:110px;
  		width:400px; 
  		height:400px;

  	}

  	</style>
  </head>
  <body>
    <form method="post" action="upload_image.php" enctype="multipart/form-data" target="leiframe">
      <input type="file" name="image"/>
      <input type="submit" value="upload"/>
    </form>
   <img src="images/product/productImage.png">
    <iframe allowTransparency="true" frameborder="50" name="leiframe"></iframe>
  </body>
</html>