<?php
include("includes/headAdmin.php"); 
include("includes/db.php");
$answer ="";


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


$topEntry = 'SELECT *
	FROM Designer 
	INNER JOIN Entry
	ON Entry.entryId = Designer.designerId
	ORDER BY votes DESC LIMIT 1';
//Exekutiverar "verkställer" SELECT-satsen
$resTopEntry = $mysqli->query($topEntry) or die("Could not query database" . $mysqli->errno . 
" : " . $mysqli->error); 

while($row = $resTopEntry->fetch_object()){
$agree=$row->accepted;
/*
if($agree == 'n'){
		$answer = "Nej";
	}*/
	if($agree == 'y'){
		$answer = "Ja";
	}

	
	$topEntry=<<<END
		 
		 Desginerns namn: <strong>{$row->designerName}</strong><br>
		 Email: <strong>{$row->designerEmail}</strong><br>
		 Ort: <strong>{$row->designerCity}</strong><br>
		 Bidragsnamn: <strong>{$row->entryName}</strong> <br>
		 Antal röster: <strong>{$row->votes}</strong><br>
		 Vill ha nyhetsbrev:  <strong>{$answer}</strong><br>
END;


	

}

?>
	<div class="leftNav"></div>

	<div class="content">	

	<div class="h1Admin">Alla deltagarens email som vill ha nyhetsbrev</div><br><br>
	
	&nbsp;&nbsp;&nbsp;<a href="entryAdmin.php"><button>Tillbaka till alla bidrag</button></a><br>
<hr>
<!--<p>Vill ha nyhetsbrev</p> --><p class="mailTitle">Email</p> <p class="topEntryTitle"> Topbidraget </p>
<hr>

<?php

echo "<div class='topEntry'>" . $topEntry . "</div>";

	while($row = $res->fetch_object()) : 
	$designerEmail = ($row->designerEmail); 
	$agree = ($row->mailAgree);

	/*if($agree == 'n'){
		$answer = "Nej";
		$color="mailRed";
	}*/
	if($agree == 'y'){
		$answer = "Ja";
		$color="mailGreen";
	}


	?>
				
					<table>
						<!--
							<td class="mailTable">
								<p class="<?php echo  $color ?>"> <?php echo  $answer ?> </p>
							</td>-->
						<tr>
							<td>
								<p class="<?php echo  $color ?>"><?php echo  $designerEmail ?> </p>
							</td>
						</tr>
					</table>
				
					
					
			

 <?php endwhile; ?>


 </div>