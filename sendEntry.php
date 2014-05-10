		
<?php 

include("includes/db.php");



if(isset($_POST['sendEntry'])){

	if($_POST['designerName'] == "" || $_POST['entryName'] == "" || $_POST['designerEmail'] == "" || $_POST['designerCity'] == ""){

	?>

		<script> alert("Du måste fylla i alla fält för att skicka in bidraget");
		return false; </script>

	<?php	
	


	}

	else{
			$imageName = $_SESSION['imageName'];

			$designerName = $_POST['designerName'];
			$designerEmail = $_POST['designerEmail'];
			$entryName = $_POST['entryName'];
			$designerCity = $_POST['designerCity'];

			if(isset($_POST['agreeMail'])){

					$query=<<<END
					INSERT INTO Designer (designerName, designerEmail, designerCity, mailAgree) 
					VALUES('$designerName', '$designerEmail', '$designerCity', 'y');
END;
					$res = $mysqli->query($query) or die("Could not query database" . $mysqli->errno . 
					" : " . $mysqli->error);


					$query2=<<<END
					 INSERT INTO Entry (designerId, entryName, entryImage, accepted) 
					 VALUES(LAST_INSERT_ID(), '$entryName', 'images/entry/$imageName', 'n');
END;
 
					$res = $mysqli->query($query2) or die("Could not query database" . $mysqli->errno . 
					" : " . $mysqli->error);

			?><script> alert("Tack för ditt bidrag! Du kommer få mail.");</script><?php

			}







			else{
				

				?><script> alert("Tack för ditt bidrag, du slipper mail.");</script><?php

	
					$query=<<<END
					INSERT INTO Designer (designerName, designerEmail, designerCity, mailAgree) 
					VALUES('$designerName', '$designerEmail', '$designerCity', 'n');
END;
					$res = $mysqli->query($query) or die("Could not query database" . $mysqli->errno . 
					" : " . $mysqli->error);


					$query2=<<<END
					 INSERT INTO Entry (designerId, entryName, entryImage, accepted) 
					 VALUES(LAST_INSERT_ID(), '$entryName', 'images/entry/$imageName', 'n');
END;
 
					$res = $mysqli->query($query2) or die("Could not query database" . $mysqli->errno . 
					" : " . $mysqli->error);
				};


		}

}



?>