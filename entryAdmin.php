<!--
DENNA FIL ÄR "BIDRAG"-SIDAN I ADMIN-DELEN
-->

<?php 
$pageTitle="Bidrag"; //Skriver in vad som skall stå i "webb-browser-fliken"
$currentPage="entry"; //Lägger in sidans namn in i en variabel som sedan används i toppmenyn för att indikera vilken sida admin är på

include("includes/headAdmin.php"); 
include("includes/db.php");

	//Hämtar all data från tabellen Entry där det bara finns kopplade designare
	// Ordnas upp så att de bidrag som ännu inte är godkända och de som lagts till senast av designare skall visas först
	$query = 'SELECT *
	FROM Entry 
	INNER JOIN Designer 
	ON Entry.designerId=Designer.designerId
	GROUP BY Entry.entryName, Entry.entryImage, Entry.timeStamp, Designer.designerName, Designer.designerCity
	ORDER BY Entry.accepted ASC, Entry.timeStamp DESC';


	//Exekutiverar "verkställer" SELECT-satsen
	$res = $mysqli->query($query) or die("Could not query database" . $mysqli->errno . 
	" : " . $mysqli->error);

	//Variabel som hålls tom för att senare kunna fyllas och skrivas ut
	$sort="";

	//Om admin trycker på knappen "välj" utförs det som står i drop-down-menyn
	if (isset($_POST['submit'])){

		//Om alternativ 2 väljs sorteras de senaste bidragen först och skriver även ut en mening som feedback på detta
	   if ($_POST['select'] == "2")  {
	   		$sort = "Sorterat efter de senaste inkomna bidragen"; 

	  }

	//Om alternativ 3 väljs sorteras de bidragen med flest röster först och skriver även ut en mening som feedback på detta
	  	   if ($_POST['select'] == "3") {
			$sort = "Sorterat efter de med flest röster"; 

		//Hämtar all data från tabellen Entry där det bara finns kopplade designare
		// Ordnas upp så att de bidrag som ännu inte är godkända och de som har flest röster kommer först 
		$query = 'SELECT *
		FROM Entry 
		INNER JOIN Designer 
		ON Entry.designerId=Designer.designerId
		GROUP BY Entry.entryName, Entry.entryImage, Entry.timeStamp, Designer.designerName, Designer.designerCity
		ORDER BY Entry.accepted ASC, Entry.votes DESC';

		//Exekutiverar "verkställer" SELECT-satsen
		$res = $mysqli->query($query) or die("Could not query database" . $mysqli->errno . 
		" : " . $mysqli->error);
	   	}
	}


?>
	<!-- Den vänstra gråa menyn -->
	<div class="leftNavEntry"></div>
		<div class="content">

		<!-- Rubriken på bidragsidan -->
			<div class="h1Admin">Alla bidrag </div>

				<!-- Den feedback som skrivs ut beroende på vilket admin väljer i drop-down-menyn -->
				<?php echo $sort ?>

					<!-- Drop-down-menyn -->
					<form method="post" action="" enctype="multipart/form-data">
						<select name="select">
							<option value="1">Sortera bidragen</option>
		 					<option value="2">Senaste bidragen</option>
		  					<option value="3">Flest röster</option>
						</select>
						&nbsp;&nbsp;<input name="submit" type="submit" value="Välj" /> 
					</form>
					
					<!-- En knapp "visa alla mail" och små bilder för att indikera vad knapparna "ta bort" och "godkänna" betyder -->
						&nbsp;&nbsp;&nbsp;<a href="mail.php"><button>Visa alla mail </button></a><br>
						<div class="helpImgs">
							<img src="images/godkannBtn.png"><p> = Godkänn bidrag</p>
							<img src="images/godkannGraBtn.png"><p> = Godkänt bidrag</p>
							<img src="images/tabortBtn.png"><p> = Ta bort bidrag</p>
						</div>

										
					<?php 

						while($row = $res->fetch_object()) :  
							$entryId = ($row->entryId);
							$entryDate = strtotime($row->timeStamp);
							$entryDate = date("d M Y", $entryDate);
							$accepted = ($row->accepted);

							//Om bidraget ännu inte är godkänt av admin skall en grön "godkänna"-knapp finnas samt en länk som länkar till "approveEntry.php" tillsammas med bidragets ID
							if( $accepted =='n'){
								$approveEntryButton = "images/godkannBtn.png";
								$approveEntryButtonUrl = "<a href='approveEntry.php?entryId=$entryId'>";
								
							}
							//Om bidraget är godkänt av admin skall en grå "godkänna"-knapp finnas och länkningen försvinner
							else{
								
								$approveEntryButton = "images/godkannGraBtn.png";
								$approveEntryButtonUrl ="";
							}?>

							<!-- Skriver ut alla bidrag -->				
							<div class="entryWrapper">
								
								<!-- Skriver ut alla bidragsbilder och produkten ovanför bidragsbilderna -->
								<div class="entryImg">
									<img class="productStyle " src="images/product/productImage.png">
									<img class="imgStyle" src="<?php echo $row->entryImage ?>">
								</div>
								
								<!-- Skriver ut all information om bidragen -->	
								<div class="entryText">
									<h2><?php echo $row->entryName ?></h2> 
									<p><?php echo $entryDate; ?></p> <br/>
									<p><?php echo $row->designerName ?></p> <br/>
									<p><?php echo $row->designerCity ?></p> <br/>
									<p>Antal röster:</p>
									<p class="votes"><strong><?php echo $row->votes ?></strong></p>
								</div>
							
								<!-- "Godkänna" och "ta bort"-knapparna till varje bidrag -->
								<div class="entryBtn">
									<?php echo $approveEntryButtonUrl; ?> <img src='<?php echo $approveEntryButton; ?>'> </a>
									<a href="deleteEntry.php?entryId=<?php echo $entryId; ?>"><img src="images/tabortBtn.png"></a>
								</div>
							</div>
					<?php endwhile; ?>
		</div>


	<!-- Avslutar hela sidan --> 
	<?php include("includes/footerAdmin.php"); ?>