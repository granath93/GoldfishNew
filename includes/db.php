<!-- 

DETTA ÄR FILEN SOM KOPPLAR SAMMAN VÅR KOD MED DATABASEN

-->

<?php

$mysqli = new mysqli('mysql11.citynetwork.se', '127288-fb30027', 'Bprojekt', '127288-goldfish'); // (HOST, USER, PASSWORD, DATABASE) 

if(mysqli_connect_error()){
	echo "Kontakten misslyckades: " . mysqli_connect_error() . "<br>";
	exit();
}

// Gör så att vår databas och webbsidor skall kunna hantera alla svenska tecken, så som ÅÄÖ 
$mysqli->set_charset("utf8");

?>