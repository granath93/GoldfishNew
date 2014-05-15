<!-- 
DENNA FIL UPPDATERAR OCH LÄGGER TILL EN RÖST TILL ETT BIDRAG NÄR BESÖKAREN HAR RÖSTAT PÅ ETT BIDRAG
-->

<?php
	
	include("includes/db.php");
	
	// Tar emot ID till det bidrag som blivit röstat på
	$entryId = isset($_GET['entryId']) ? $_GET['entryId'] : '';
	
	//Hämtar antalet röster bidraget har
	$query =<<<END
	SELECT votes
	FROM Entry
	WHERE entryId = $entryId
END;
		
	$res = $mysqli->query($query) or die("Could not query database" . $mysqli->errno . 
		" : " . $mysqli->error);
	
	while($row = $res->fetch_object()) { 
		$entryVote = ($row->votes);
				$entryVote = $entryVote + 1; // Lägger till en röst till bidraget 
				?>
		
	<?php	}
	
 //Sparar in det nya värdet av röster till bidraget
	$query =<<<END
	UPDATE Entry
	SET votes = '$entryVote'
	WHERE entryId = '$entryId';
END;
	
	$res = $mysqli->query($query) or die("Could not query database" . $mysqli->errno . 
		" : " . $mysqli->error);

	//För besökaren tillbaka till webbsidan
	header("Location: index.php");
		
?>
