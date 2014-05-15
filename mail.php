<!--
DENNA FIL VISAR ALLA MAIL FRÅN DESIGNARE SOM GODKÄNNER NYHETSBREV
-->

<?php
include("includes/headAdmin.php"); 
include("includes/db.php");
$answer ="";

//Hämtar alla bidrag med designare som sagt ja till nyhetsbrev
$query =<<<END
	 SELECT *
	FROM Entry 
	INNER JOIN Designer
	ON Entry.designerId = Designer.designerId
	WHERE mailAgree = 'y';
END;

//Exekutiverar "verkställer" SELECT-satsen
$res = $mysqli->query($query) or die("Could not query database" . $mysqli->errno . 
" : " . $mysqli->error); 

//Hämtar det bidrag med tillhörande kontaktupgifter med flest röster
$topEntry = <<<END
	SELECT *
	FROM Entry 
	Left JOIN Designer
	ON Entry.designerId = Designer.designerId
	ORDER BY votes DESC LIMIT 1;
END;

	//Exekutiverar "verkställer" SELECT-satsen
	$resTopEntry = $mysqli->query($topEntry) or die("Could not query database" . $mysqli->errno . 
	" : " . $mysqli->error); 

	while($row = $resTopEntry->fetch_object()){
		$agree=$row->accepted;

	 //Om bidragen antingen har svarat ja eller nej till nyhetsbrev skall detta skrivas ut med "Ja" eller "nej"
		if($agree == 'y'){
			$answer = "Ja";
		}
		if($agree == 'n'){
			$answer = "Nej";
		}
		
		//Skriver in all information om toppbidraget in i en variabel som senare skrivs ut på sidan
		$topEntry =<<<END
			 
			 Desginerns namn: <strong>{$row->designerName}</strong><br>
			 Email: <strong>{$row->designerEmail}</strong><br>
			 Ort: <strong>{$row->designerCity}</strong><br>
			 Bidragsnamn: <strong>{$row->entryName}</strong> <br>
			 Antal röster: <strong>{$row->votes}</strong><br>
			 Vill ha nyhetsbrev:  <strong>{$answer}</strong><br>
			
END;
	}?>

	<div class="leftNav"></div>

		<div class="content">	

			<div class="h1Admin">Alla deltagares email som vill ha nyhetsbrev</div><br><br>
	
			<a href="entryAdmin.php"><button>Tillbaka till alla bidrag</button></a><br>
<hr>
	<p class="mailTitle">Email</p> <p class="topEntryTitle"> Toppbidraget </p>
<hr>

<?php
	echo "<div class='topEntry'>" . $topEntry . "</div>"; //Skriver ut toppbidraget med tillhörande info

	while($row = $res->fetch_object()) : 
	$designerEmail = ($row->designerEmail); 
	$agree = ($row->mailAgree);?>

				<!-- Skriver ut alla email i en tabell -->
					<table>
						<tr>
							<td>
								<p class="mailGreen"><?php echo  $designerEmail ?> </p>
							</td>
						</tr>
					</table>
				
 	<?php endwhile; ?>

 </div>