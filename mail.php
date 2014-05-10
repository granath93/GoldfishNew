<?php
include("includes/headAdmin.php"); 
include("includes/db.php");

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
<?php
	while($row = $res->fetch_object()) : 
	$designerEmail = ($row->designerEmail); 
	?>

					 <?php echo  $designerEmail ?> <br>
			

 <?php endwhile; ?>


 </div>