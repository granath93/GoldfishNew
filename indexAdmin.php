<?php 
$currentPage = "index";

include("includes/headAdmin.php"); 
include("includes/db.php");

$dayEntry =0;
$weekEntry =0;
$monthEntry =0;
$totalEntry =0;

//Plockar in alla bidrag och alla attribut som finns i tabellen Entry
$res = $mysqli->query('SELECT * FROM Entry') or die("Could not query database" . $mysqli->errno . 
" : " . $mysqli->error);

//Loopar igenom alla bidrag i tabellen Entry 
while($row = $res->fetch_object()) { 
	$date = strtotime($row->timeStamp); //sparar alla datum i variabeln $date
	$date = date("d m Y", $date); //ordnar alla datum i dag, månad, år
	$now= time(); //skapar en variabel $now som tar in dagens datum och tid
	$now=date("d m Y", $now); //gör om dagens datum till dag, månad, år
	$today=date("D"); //sparar dagens veckodag 
	$firstDayOfMonth= date('01 m Y', strtotime('this month')); //skapar en variabel med veckans första datum
	$lastMonth = date('01 m Y', strtotime('last month'));



	//om det är en måndag idag används dagens måndagsdatum
	if($today=="Mon"){
		$firstDayOfWeek=date('d m Y', strtotime('this monday', time())); //skapar en variabel med månadens första datum
	}
	//om det är tisdag idag eller någon annan dag i veckan sparas senaste måndagens datum
	else{
		$firstDayOfWeek=date('d m Y', strtotime('last monday', time())); //skapar en variabel med månadens första datum
	}

	//räknar upp variabeln $totalEntry för varje bidrag som finns i tabellen
	$totalEntry ++;

		//Om bidragets datum är den samma som dagens datum räknas variabeln upp med +1
		if($date == $now){
			$dayEntry ++;
		}

		//Om bidragets datum är den samma eller större än veckans första dag räknas variabeln upp med +1
		if($date >= $firstDayOfWeek){
			$weekEntry ++; 
				
		}

		//Om bidragets datum är den samma eller större än månadens första dag räknas variabeln upp med +1
		if($date >= $firstDayOfMonth && $date !== $lastMonth){
			$monthEntry ++; 

		}
}

?>


<div class="leftNav">
</div>

<div class="content">

	<div class="h1Admin">Statistik</div>

 	Antal bidrag 

	<br><br>
	<div class="statisticContent">
	<table>
	<tr>
		<td>
			<h3> Idag </h3> 
		</td>
		<td>
			<h3> Denna vecka </h3>
		</td>
	</tr>
	<tr>
		<td>
			<p> <?php echo $dayEntry;?> </p> 
		</td>
		<td>
			<p><?php echo $weekEntry;?> </p> 
		</td>
	</tr>
	<tr>
		<td>
			<h3> Denna månad </h3> 
		</td>
		<td>
			<h3> Totalt </h3>
		</td>
	</tr>
	<tr>
		<td>
			<p> <?php echo $monthEntry;?> </p> 
		</td>
		<td>
			<p><?php echo  $totalEntry;?></p> 
		</td>
	</tr>

	</table>


</div>
<?php include("includes/footerAdmin.php"); ?>
