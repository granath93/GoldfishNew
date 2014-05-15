<!--
DENNA FIL GODKÄNNER BIDRAGEN I ADMIN-DELEN NÄR ADMINISTRATÖRE HAR GODKÄNT ETT BIDRAG
-->	
<?php
	
	include("includes/db.php");
	
	// Tar emot det ID som tillhör bidraget som blivit godkänt	
	$entryId = isset($_GET['entryId']) ? $_GET['entryId'] : '';
	

	if(isset($_GET['entryId'])){
	
	//Uppdaterar bidraget med ett Y i databasen för att visa att bidraget är godkänt av administratören
	$query =<<<END
	UPDATE Entry
	SET accepted ='y'
	WHERE entryId = '$entryId';
END;
	
	
	$res = $mysqli->query($query) or die("Could not query database" . $mysqli->errno . 
		" : " . $mysqli->error);
	
	//Skickar administratören tillbaka till "bidrag"-sidan i damin-delen
	header("Location: entryAdmin.php");
	
	}
	
	
	
?>
