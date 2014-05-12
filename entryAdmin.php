<?php 
$pageTitle="Bidrag"; //Skriver in vad som skall stå i "webb-browser-fliken"
$currentPage="entry";

include("includes/headAdmin.php"); 
include("includes/db.php");

	$query = 'SELECT *
	FROM Entry 
	INNER JOIN Designer 
	ON Entry.designerId=Designer.designerId
	GROUP BY Entry.entryName, Entry.entryImage, Entry.timeStamp, Designer.designerName, Designer.designerCity
	ORDER BY Entry.accepted ASC, Entry.timeStamp DESC';


	//Exekutiverar "verkställer" SELECT-satsen
	$res = $mysqli->query($query) or die("Could not query database" . $mysqli->errno . 
	" : " . $mysqli->error);

	$sort="";

	if (isset($_POST['submit'])){

	   if ($_POST['select'] == "2")  {
	   		$sort = "Sorterat efter de senaste inkomna bidragen"; 

	  }

	   if ($_POST['select'] == "3") {
			$sort = "Sorterat efter de med flest röster"; 

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

	<div class="leftNavEntry"></div>
		<div class="content">

			<div class="h1Admin">Alla bidrag </div>
				<?php echo $sort ?>

					<form method="post" action="" enctype="multipart/form-data">

						<select name="select">
							<option value="1">Sortera bidragen</option>
		 					<option value="2">Senaste bidragen</option>
		  					<option value="3">Flest röster</option>
						</select>

						&nbsp;&nbsp;<input name="submit" type="submit" value="Välj" /> 
					</form>
					
						&nbsp;&nbsp;&nbsp;<a href="mail.php"><button>Visa alla mail </button></a><br>
						<div class="helpImgs" style="position:absolute;margin-left:420px; margin-top:-25px;">
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

							if( $accepted =='n'){
								$approveEntryButton = "images/godkannBtn.png";
								$approveEntryButtonUrl = "<a href='approveEntry.php?entryId=$entryId'>";
								
							}

							else{
								
								$approveEntryButton = "images/godkannGraBtn.png";
								$approveEntryButtonUrl ="";
							}


							?>
							
							<div class="entryWrapper">
								<div class="entryImg">
									<img class="productStyle " src="images/product/productImage.png">
									<img class="imgStyle" src="<?php echo $row->entryImage ?>">
								</div>
									
								<div class="entryText">
									<h2><?php echo $row->entryName ?></h2> 
									<p><?php echo $entryDate; ?></p> <br/>
									<p><?php echo $row->designerName ?></p> <br/>
									<p><?php echo $row->designerCity ?></p> <br/>
									<p>Antal röster:</p>
									<p class="votes"><strong><?php echo $row->votes ?></strong></p>
								</div>
								
								<div class="entryBtn">
									
									<?php echo $approveEntryButtonUrl; ?> <img src='<?php echo $approveEntryButton; ?>'> </a>
								
									<a href="deleteEntry.php?entryId=<?php echo $entryId; ?>"><img src="images/tabortBtn.png"></a>
									
								</div>
							</div>


						<?php endwhile; ?>
		</div>



	<?php include("includes/footerAdmin.php"); ?>