<?php 
include("includes/db.php");

	$res = $mysqli->query('SELECT * FROM Appearance') or die("Could not query database" . $mysqli->errno . 
	" : " . $mysqli->error);

	while($row = $res->fetch_object()) { 
	$background = ($row->background);
	}

?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width" charset="utf-8">
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<link rel="stylesheet" href="css/normalize.css" >
<link rel="stylesheet" href="css/front.css" >
<script src="js/functions.js" charset="utf-8"></script>
	<title>Front</title>
</head>

<body style="background-color:#<?php echo $background ?>">


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
