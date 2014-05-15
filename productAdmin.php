<!--
DENNA FIL ÄR "PRODUKT"-SIDAN I ADMIN-DELEN DÄR ADMIN KAN BYTA UT DEN PRODUKT BESÖKARNA SKALL DESIGNA PÅ FRONT-END, WEBBSIDAN UTÅT MOT BESÖKARNA
-->

<?php 
$pageTitle="Produkt"; //Skriver in vad som skall stå i "webb-browser-fliken"
$currentPage = "product"; //Lägger in sidans namn in i en variabel som sedan används i toppmenyn för att indikera vilken sida admin är på

//Sätter variablerna till 0 om inga bidrag har kommit in för dagen/veckan eller månaden
include("includes/headAdmin.php"); 
include("includes/db.php");

	$feedback=""; //Hålls tom för att senare kunna fyllas och skrivas ut
	$productId = 1;
?>

	<!-- Vänstra gråa menyn på sidan -->
	<div class="leftNav"></div>
		<div class="content">


	<?php 	
			//Hämtar allt ur "product"-tabellen
			$query =<<<END
			SELECT * FROM Product
			WHERE productId = '$productId'		
END;

		//Exekutiverar "verkställer" UPDATE-satsen
			$res = $mysqli->query($query) or die("Failed");
			
			while($row = $res->fetch_object()){
			$image = $row->productImg;
		}


		//Om admin trycker på att ladda upp produkten sparas bilden i images/product som sedan hämtas och visas upp på sidan
		if(isset($_POST['uploadButton'])){

			$imageName 	= $_FILES['productImage']['name'];
			$imageType	= strtolower(end(explode('.', $imageName)));
			$imageScr = 'images/product/productImage.' . $imageType;
			move_uploaded_file($_FILES['productImage']['tmp_name'], $imageScr);

			//Sparar in sökvägen till bilden in i databasen
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
		<!-- Rubriken på prdoukt-sidan -->
		<div class="h1Admin">Produkt</div>

		<!-- Brödtext/hjälptext om hur produkten skall vara -->
			Välj en bild för att representera produkten som skall designas. <br>
		
		<ul>
			<li>	Bilden skall vara i antingen gif (ej animerad) eller png-format. <br></li>
			<li>	Bilden skall vara kvadratisk, rekommenderat 400*400 pixlar stor.
			<li>	Bilden skall vara transparent innanför konturerna och ha en vit yta utanför konturerna.<br></li>
			<li>	Bilden kan även innehålla skuggor för att göra produkten effektfull. <br><br></li>
		</ul>

		<!-- knappen och fältet "fälj fil"/"Ladda upp" -->
		<form method="post" action="productAdmin.php" enctype="multipart/form-data">
		      <label>Välj bild </label>
		      <input type="file" name="productImage"/>
		      <input type="submit" name="uploadButton" value="Ladda upp och spara"/>
		     &nbsp;&nbsp; <?php echo $feedback;?>
	    </form><br><br>
 
 		<!-- Bilden på produkten som laddats upp -->
		<img style="height: 300px;" src=" <?php echo $image;?>"/>

	</div>

<!-- Avslutar hela sidan -->
<?php include("includes/footerAdmin.php"); ?>

