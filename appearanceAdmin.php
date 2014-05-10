	<?php
	$pageTitle="Utseende"; //Skriver in vad som skall stå i "webb-browser-fliken"
	$currentPage = "appearance"; //Lägger in värde så man vet vilken sida administratören är på
	
	//Lägger till filer som behöver vara med på sidan så att sidan skall fungera rätt
	include("includes/db.php"); 
	include("includes/headAdmin.php"); 
	
	//Sparar det som finns i alla fält i formuläten och sparar de i variabler
	$session = isset($_GET['p']) ? $_GET['p'] : 'Background' ; 
	$feedback="";
	$feedbackLogotype="";
	$feedbackUrl="";
	$empty="";
	$arrow="";
	$MaxAllowedWidth = 450;
	$MaxAllowedHeight =85;
	
	
	?>
	<!--Menyn på vänser sida-->
	<div class="leftNav">			
	
		<ul>
			<li>	<div class="arrow"><?php if($session=="Background")echo ">"?></div>    <a href="appearanceAdmin.php?p=Background">		Bakgrund</a> 		</li>	
			<li>	<div class="arrow"><?php if($session=="Logotype")echo ">"?></div>		<a href="appearanceAdmin.php?p=Logotype">		Logotyp</a>		</li>
			
		</ul>	
	
	</div>
	
	<div class="content">
	<?php
	
	if ($session =="Background"){
	
		?>
		<?php 
	$query = <<<END
	SELECT *
	FROM Appearance;
END;
	
	
	
	//Exekutiverar "verkställer" SELECT-satsen
	$res = $mysqli->query($query) or die("Could not query database" . $mysqli->errno . 
	" : " . $mysqli->error); //Performs query
	
	//Loopar igenom alla attribut i tabellen och lägger in de i variabler
	while($row = $res->fetch_object()) { 
	$background = ($row->background);
	
	}
	$showBackground = $background;
	
	//När användaren trycker på "spara"-knappen uppdateras och sparas välkomsttexten, reglerna och mailen i respektive tabeller/fält som ligger i formuläret
	if(isset($_POST['save'])){
	
	//Här börjar satsen som sparar bakgrundsfärgen
	 	if(isset($_POST['background'])){
	
	//Sparar det som står i formuläret i variabler
		$background = isset($_POST['background']) ? $_POST['background'] : '' ;  
		
	
	//Här uppdateras tabellen med allt som är skrivet i formuläret
			$query =<<<END
			UPDATE Appearance
			SET background = '$background'
			
END;
	$showBackground = $background;
	
	//Exekutiverar "verkställer" UPDATE-satsen
		$res = $mysqli->query($query) or die("Failed");
		$feedback = "Sparat";
	
		}
	
	}?>
		<div class="h1Admin">Bakgrund</div>
	
	<p> Ange en sex-siffrig Hex-kod (000000, svart) för att ange sidans bakgrundsfärg<br></p>
	
		<form action="appearanceAdmin.php?p=Background" method="post">
				<label class="field" for ="background">Välj Bakgrundsfärg:</label>
				<textarea id="background" name="background"><?php echo $showBackground ?></textarea><br>
				<button name="save">Spara </button>  &nbsp; &nbsp; &nbsp; <?php echo $feedback ?>
			</form>
	</form>
	
		
	<iframe width="340" height="192" style="background-color:#<?php echo $background ?>"></iframe>
	<!--<iframe src="http://localhost/goldfish/" width="100%" height="192" scrolling="no" ></iframe>-->
	
	
	<div class="backgroundButtonContent">
	
		<div class="backgroundButton lightGreen"> bae860</div>
		<div class="backgroundButton lightRed"> e89489</div>
		<div class="backgroundButton yellow"> f7e859</div>
		<div class="backgroundButton lightBlue"> 7db7ff</div>
		<div class="backgroundButton pink"> ff86b6</div><br>
		<div class="backgroundButton green"> 2caa23</div>
		<div class="backgroundButton red"> a90808</div>
		<div class="backgroundButton blue"> 2f27cc</div>
		<div class="backgroundButton white"> ffffff</div>
		<div class="backgroundButton black"> 000000</div>
	
	</div>
	
	
	<?php } 
	
	
	//Visar vilken sektion man är på, detta fall i logotyp-sektionen
	
	if($session=="Logotype"){
	$arrow="arrow-right";
	$logotypeId=1;
	
					$query =<<<END
					SELECT * FROM Logotype
					WHERE logotypeId = $logotypeId		
END;
	
			//Exekutiverar "verkställer" UPDATE-satsen
				$res = $mysqli->query($query) or die("Failed");
				
				while($row = $res->fetch_object()){
				$logotype = ($row->logotypeImg);
				$logotypeUrl = ($row->logotypeUrl);
				$logotypeId = ($row->logotypeId);
	
						
				}	
	
	
	//När användaren väljer att ladda upp bilden på logotypen sker detta
	if(isset($_POST['uploadButton'])){
	
		$logotypeName 	= $_FILES['logotypeImg']['name']; //sparar hela namnet på logotypen som användaren laddar upp
		$logotypeType	= strtolower(end(explode('.', $logotypeName))); //sparar logotypens format
		$logotypeScr = 'images/logotype/logotypeImage.' . $logotypeType; //skapar hela URLen till bilden i bildmappen
		move_uploaded_file($_FILES['logotypeImg']['tmp_name'], $logotypeScr); //sparar logotypen i bildmappen
		
	
	$query =<<<END
			UPDATE Logotype
			SET logotypeImg = '$logotypeScr'
			WHERE logotypeId = '$logotypeId'
END;
		$res = $mysqli->query($query) or die("Failed");
	
		$logotype = $logotypeScr;
	//När användaren trycker på "spara", sparas logotypen i databasen med en "UPDATE"-sats	
	}	
	
	if(isset($_POST['saveImg'])){
	 $feedbackLogotype="Sparat";
	 
	 }
	
	
	if(isset($_POST['saveUrl'])){
	$feedbackUrl ="sparat";
	
	$logotypeUrl =  isset($_POST['logotypeUrl']) ? $_POST['logotypeUrl'] : '' ;  
	
	//Här uppdateras tabellen med allt som är skrivet i formuläret
			$query =<<<END
			UPDATE Logotype
			SET logotypeUrl = '$logotypeUrl'
			
			
END;
	
	
	$res = $mysqli->query($query) or die("Failed");	
	
	}
	
	list($width, $height) = getimagesize("images/logotype/logotypeImage.png");
	if ($width > $MaxAllowedWidth){
		echo $feedback ="Din bild är för bred!";
	}
	if($height > $MaxAllowedHeight){
		echo $feedback = "Din bild är för hög!";
	}
	?>
	<div class="h1Admin">Logotyp</div>
	
	<br>
	<!-- Formuläret där användaren laddar upp logotypen från egen dator -->
	<form method="post" action="appearanceAdmin.php?p=Logotype" enctype="multipart/form-data">
	      <label>Välj en bild som är din logotyp </label>
	      <input type="file" name="logotypeImg"/>
	      <input type="submit" name="uploadButton" value="Ladda upp"/>
	   &nbsp;&nbsp;  <button name="saveImg">Spara </button>    &nbsp;&nbsp;  <?php echo $feedbackLogotype; ?> 
	   </form>  
	  <br>
	 
	 <!-- Visar logotypen med hjälp av hela url-en som tidigare sparats i variabeln "$logotype"-->
	<div class="logoPreview">
	<img src="<?php echo $logotype;?>"/>
	</div>
	<br><br><br>
	
	<form method="post" action="appearanceAdmin.php?p=Logotype" enctype="multipart/form-data">
	<!-- Formuläret där användaren sparar en URL kopplat till logotypen -->
	    	<label>Skriv in en URL som din logotyp skall länka till på själva webbsidan</label><br><br>
	    	<input type='field' name="logotypeUrl"/>
	    	<button name="saveUrl">Spara</button>   &nbsp;&nbsp;  <?php echo $feedbackUrl; ?>
	    </form>
	<?php
	//Skriver ut URL-en användaren har matat in
	echo "Din URL-länk är nu: <strong>". $logotypeUrl . "</strong>";
	
	//Användaren trycker på "spara" för att spara URL-en till databasen med en "UPDATE"-sats 
	
	
	}
	include("includes/footerAdmin.php");  
	?>
