<?php
include("includes/headAdmin.php"); 
include("includes/db.php");
$answer ="";

$query = 'SELECT *
	FROM Designer 
	INNER JOIN Entry
	ON Entry.entryId = Designer.designerId
	ORDER BY Designer.designerName ASC';

//Exekutiverar "verkställer" SELECT-satsen
$res = $mysqli->query($query) or die("Could not query database" . $mysqli->errno . 
" : " . $mysqli->error); ?>

	<div class="leftNav"></div>

	<div class="content">	

	<div class="h1Admin">Alla deltagarens email</div><br><br>
	
	&nbsp;&nbsp;&nbsp;<a href="entryAdmin.php"><button>Tillbaka till alla bridag </button></a><br>
<hr>
<p>Vill ha nyhetsbrev</p> <p class="mailTitle">Email</p>
<hr>
<?php
	while($row = $res->fetch_object()) : 
	$designerEmail = ($row->designerEmail); 
	$agree = ($row->mailAgree);

	if($agree == 'n'){
		$answer = "Nej";
		$color="red";
	}
	if($agree == 'y'){
		$answer = "Ja";
		$color="green";
	}


	?>
				
					<table>
						<tr>
							<td class="mailTable">
								<p class="<?php echo  $color ?>"> <?php echo  $answer ?> </p>
							</td>
							<td>
								<p class="<?php echo  $color ?>"><?php echo  $designerEmail ?> </p>
							</td>
						</tr>
					</table>
				
					
					
			

 <?php endwhile; ?>


 </div>