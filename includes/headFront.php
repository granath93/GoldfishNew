<!-- 
DENNA FIL STARTAR FRONT-END, WEBBSIDAN UTÅT MOT KUNDEN
-->

<?php 
// Läggar till databasen-filen för att koppla sidan mot databasen
include("includes/db.php");
	//Hämtar allt från "Appearance"-tabellen för att kunna visa den bakgrundsfärg administratören sätter
	//på admin-sidan
	$res = $mysqli->query('SELECT * FROM Appearance') or die("Could not query database" . $mysqli->errno . 
	" : " . $mysqli->error);

	while($row = $res->fetch_object()) { 
		$background = ($row->background);
	}

?>
<!DOCTYPE html>
	<html>
		<head>
			<meta name="viewport" content="width=device-width" charset="utf-8"> <!-- Läser av skärmen användaren sitter på -->
			<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
			<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
			<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
			<link rel="stylesheet" href="css/normalize.css" >
			<link rel="stylesheet" href="css/front.css" >
			<script src="js/functions.js" charset="utf-8"></script>
				<title>Front</title>
		</head>

			<!-- Sätter den bakgrundsfärg administratören väljer, hämtad ur databasen -->
			<body style="background-color:#<?php echo $background ?>"> 

			<!-- Toppmenyn -->
		<div class="topNav" >
		    
		   		<ul id="menu" class="backgroundNav">
				    <li>  	<a  href="#start">  Start  </a><li>
				    <li>	<a class="" href="#design"> Designa </a><li>
				    <li> 	<a class="" href="#toplist"> Topplista </a><li>
				    <li>	<a class="" href="#latest"> Senaste bidrag </a><li>
				    <li> 	<a class="" href="#rule"> Regler </a><li>
		   		</ul>
		    
		  </div>


			<div class="container">
