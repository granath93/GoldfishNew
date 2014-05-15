<!--
DENNA FIL SPARAR IN DEN BILDEN SOM DESIGNERN TILL BIDRAGET LÄGGER UPP I DESIGNSCENEN.
VISAR UPP BILDEN INUTI PRODUKTEN OCH SPARA NER DEN I MAPPEN IMAGES/ENTRY
-->

<?php
	session_start();

	$_SESSION['imageName'] = $_FILES['image']['name'];
	$imageName = $_SESSION['imageName'];

 	move_uploaded_file($_FILES['image']['tmp_name'], 'images/entry/'.$imageName);

//Här kollar man om bilden är liggande eller stående. Beroende på det så fylls designscenen ut på antingen höjden eller bredden
		list($width, $height) = getimagesize("images/entry/".$imageName);
	if ($width > $height){
		$size = "height: 350px";
	}
	if($height > $width){
		$size = "width: 350px";
	}


?>
<!DOCTYPE html>
<html>
  <head>
  	
  </head>
  <body>
     <img style=" <?php echo $size ?> " src="images/entry/<?php echo $imageName?>?v=<?php echo rand(0,1000) // rand() prevents the browser from displaying a previously cached image ?>"/>
  </body>
</html>
