<!--
DENNA FIL TAR BORT BIDRAGEN I ADMIN-DELEN NÄR ADMINISTRATÖRE VÄLJER ATT TA BORT ETT BIDRAG
-->	
<?php

include("includes/db.php");

	// Tar emot det ID som tillhör bidraget som blivit godkänt	
	$entryId = isset($_GET['entryId']) ? $_GET['entryId'] : '';

	if(isset($_GET['entryId'])){

	//Tar bort bidraget ur tabellen i databasen	
	$query =<<<END
		DELETE 
		FROM Entry
		WHERE entryId = $entryId;
END;

	$res = $mysqli->query($query) or die("Could not query database" . $mysqli->errno . 
		" : " . $mysqli->error);

	//Skickar admin tillbaka till "bidrag"-sidan i admin-delen
	header("Location: entryAdmin.php");


	}


?>