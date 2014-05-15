<!-- 
DENNA FIL KOLLAR OM ALLA FÄLT I FORMULÄTER PÅ DESIGNSCENEN ÄR IFYLLDA INNAN BIDRAGET SKRIVS IN I DATABASEN
-->		
<?php 

include("includes/db.php");
//Om knappen "skicka bidrag" är klickad på
if(isset($_POST['sendEntry'])){


//Kollar om alla fält är ifyllda annars skrivs en popupruta ut 
	if($_POST['designerName'] == "" || $_POST['entryName'] == "" || $_POST['designerEmail'] == "" || $_POST['designerCity'] == ""){?>

		<script> alert("Du måste fylla i alla fält för att skicka in bidraget");
		return false; </script>

	<?php }

	else{
		//Om alla fält är ifyllda sparas all information in i variabler
			$imageName = $_SESSION['imageName'];

			$designerName = $_POST['designerName'];
			$designerEmail = $_POST['designerEmail'];
			$entryName = $_POST['entryName'];
			$designerCity = $_POST['designerCity'];


//Om rutan "jag vill ha nyhetsbrev" är ikryssad läggs bidraget in med ett y i fältet "mailAgree"
//och en popupruta visas
			if(isset($_POST['agreeMail'])){

				//Här läggs designerns uppgifter in i databasen
					$query=<<<END
					INSERT INTO Designer (designerName, designerEmail, designerCity, mailAgree) 
					VALUES('$designerName', '$designerEmail', '$designerCity', 'y');
END;
					$res = $mysqli->query($query) or die("Could not query database" . $mysqli->errno . 
					" : " . $mysqli->error);

				//Här läggs bidragets uppgifter in i databasen
					$query2=<<<END
					 INSERT INTO Entry (designerId, entryName, entryImage, accepted) 
					 VALUES(LAST_INSERT_ID(), '$entryName', 'images/entry/$imageName', 'n');
END;
 
					$res = $mysqli->query($query2) or die("Could not query database" . $mysqli->errno . 
					" : " . $mysqli->error);?>

					<script> alert("Tack för ditt bidrag! Du kommer få mail.");</script>

	<?php }

		//Om rutan "jag vill ha nyhetsbrev" INTE är ikryssad läggs bidraget in med ett n i fältet "mailAgree" 
		//och en popupruta visas
			else{
		
				//Här läggs designerns uppgifter in i databasen
					$query=<<<END
					INSERT INTO Designer (designerName, designerEmail, designerCity, mailAgree) 
					VALUES('$designerName', '$designerEmail', '$designerCity', 'n');
END;
					$res = $mysqli->query($query) or die("Could not query database" . $mysqli->errno . 
					" : " . $mysqli->error);

				//Här läggs bidragets uppgifter in i databasen
					$query2=<<<END
					 INSERT INTO Entry (designerId, entryName, entryImage, accepted) 
					 VALUES(LAST_INSERT_ID(), '$entryName', 'images/entry/$imageName', 'n');
END;
 
					$res = $mysqli->query($query2) or die("Could not query database" . $mysqli->errno . 
					" : " . $mysqli->error);?>

					<script> alert("Tack för ditt bidrag, du slipper mail.");</script>

			<?php };
		}
}



?>