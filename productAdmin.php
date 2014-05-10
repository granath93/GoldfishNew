<?php 
$currentPage = "product";

include("includes/headAdmin.php"); 
include("includes/db.php");


$session = isset($_GET['p']) ? $_GET['p'] : 'product' ;
$productId = 1;
$feedback="";

?>


<div class="leftNav">
	
</div>


<div class="content">

<?php

if($session=="product"){
	$arrow="arrow-right"; 

				$query =<<<END
				SELECT * FROM Product
				WHERE productId = $productId		
END;

		//Exekutiverar "verkställer" UPDATE-satsen
			$res = $mysqli->query($query) or die("Failed");
			
			while($row = $res->fetch_object()){
			$image = $row->productImg;
		}



if(isset($_POST['uploadButton'])){

	$imageName 	= $_FILES['productImage']['name'];
	$imageType	= strtolower(end(explode('.', $imageName)));
	$imageScr = 'images/product/productImage.' . $imageType;
	move_uploaded_file($_FILES['productImage']['tmp_name'], $imageScr);

		$query =<<<END
		UPDATE Product
		SET productImg = '$imageScr'
		WHERE productId = '$productId'
END;

//Exekutiverar "verkställer" UPDATE-satsen
	$res = $mysqli->query($query) or die("Failed");
	
	$image = $imageScr;
	$feedback = "Sparat";
 }  

?>

		<div class="h1Admin">Produkt</div>
		Välj en bild som skall representera produkten som skall designas. <br>
	<ul>
	<li>	Bilden får endast vara formatet .png eller .gif. <br></li>
	<li>	Bilden skall vara kvadratisk, rekommenderar 400*400px stor.
	<li>	Bilden skall vara transparent innanför konturerna och ha ett vitt lager utanför konturerna.<br></li>
	<li>	Bilden kan även innehålla skuggor för att göra produkten effektfull. <br><br></li>
</ul>

<form method="post" action="productAdmin.php" enctype="multipart/form-data">
      <label>Välj bild </label>
      <input type="file" name="productImage"/>
      <input type="submit" name="uploadButton" value="Ladda upp och spara"/>
     &nbsp;&nbsp; <?php echo $feedback;?>
    </form><br><br>
 
<img style="height: 300px;" src=" <?php echo $image;?>"/>


		
<?php } 

if($session=="image"){
	$arrow="arrow-right"; ?>

	<div class="h1Admin">Bild</div>
		Tillåts uppladdning av bild för att designa produkten?


		<form method="post" action="productAdmin.php?p=image" enctype="multipart/form-data">
		<br><br><input type="image" src="images/godkannBtn.png" class="button" name="buttonYes"></input> <p>Ja</p>
		<br><input type="image" src="images/tabortBtn.png" class="button" name="buttonNo"></input> <p>Nej</p>

		</form>-->

<?php } ?>


</div>






<?php include("includes/footerAdmin.php"); ?>

