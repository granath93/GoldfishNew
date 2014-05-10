
<?php

include("includes/db.php");





$entryId = isset($_GET['entryId']) ? $_GET['entryId'] : '';

echo $entryId;


	if(isset($_GET['entryId'])){

	$query =<<<END
		DELETE 
			FROM Entry
			WHERE entryId = $entryId;
END;

	$res = $mysqli->query($query) or die("Could not query database" . $mysqli->errno . 
		" : " . $mysqli->error);


	header("Location: entryAdmin.php");


	}


?>