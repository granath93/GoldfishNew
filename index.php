<?php
session_start();

//inkluderar databaskopplingen
include("includes/db.php");
include("includes/headFront.php");
include("sendEntry.php");
$mysqli->set_charset("utf8");
$accepted="";


$inspentries = 'SELECT *
	FROM Entry, Designer 
	GROUP BY Entry.entryName, Entry.entryImage, Entry.timeStamp
	ORDER BY  votes DESC LIMIT 4';

$topentries = 'SELECT *
	FROM Entry, Designer 
	GROUP BY Entry.entryName, Entry.entryImage, Entry.timeStamp
	ORDER BY votes DESC LIMIT 9';

$dateentries = 'SELECT *
	FROM Entry, Designer 
	WHERE Entry.accepted = "y"
	GROUP BY Entry.entryName, Entry.entryImage, Entry.timeStamp
	ORDER BY Entry.timeStamp DESC LIMIT 8';


/*
$inspentries = 'SELECT Entry.entryId, Entry.entryName, Entry.accepted, Entry.timeStamp, Entry.entryImage, COUNT(EntryVoter.entryId) as votes
	FROM Entry 
	LEFT JOIN EntryVoter
	ON Entry.entryId=EntryVoter.entryId
	GROUP BY Entry.entryName, Entry.entryImage, Entry.timeStamp
	ORDER BY  votes DESC LIMIT 4';

$topentries = 'SELECT Entry.entryId, Entry.entryName, Entry.accepted, Entry.timeStamp, Entry.entryImage, COUNT(EntryVoter.entryId) as votes
	FROM Entry 
	LEFT JOIN EntryVoter
	ON Entry.entryId=EntryVoter.entryId
	GROUP BY Entry.entryName, Entry.entryImage, Entry.timeStamp
	ORDER BY votes DESC LIMIT 8';

$dateentries = 'SELECT Entry.entryId, Entry.entryName, Entry.accepted, Entry.timeStamp, Entry.entryImage, COUNT(EntryVoter.entryId) as votes
	FROM Entry 
	LEFT JOIN EntryVoter
	ON Entry.entryId=EntryVoter.entryId
	WHERE Entry.accepted = "y"
	GROUP BY Entry.entryName, Entry.entryImage, Entry.timeStamp
	ORDER BY Entry.timeStamp DESC LIMIT 8';

*/

//hämtar från tabellen text i databasen
$res = $mysqli->query('SELECT * FROM Text, Logotype') or die("Could not query database" . $mysqli->errno . 
" : " . $mysqli->error);
$entriesRes = $mysqli->query($inspentries) or die("Could not query database" . $mysqli->errno . 
" : " . $mysqli->error);
$entriesTop = $mysqli->query($topentries) or die("Could not query database" . $mysqli->errno . 
" : " . $mysqli->error);
$entriesDate = $mysqli->query($dateentries) or die("Could not query database" . $mysqli->errno . 
" : " . $mysqli->error);

//Vi kommer behöva göra någon slags JOIN eller UNION-sats för att få alla resultat i samma query, istället för flera olika. 
//Jag och Dennis ska titta över det.

while($row = $res->fetch_object()) { 
	$welcomeTitle = ($row->welcomeTitle);
	$welcomeText = ($row->welcomeText);
	$ruleTitle = ($row->ruleTitle);
	$ruleText = ($row->ruleText);
	$logotype = ($row->logotypeImg);
	$logotypeUrl = ($row->logotypeUrl);


	}

	
?>

	<div class="logotype">
				<a href="<?php echo $logotypeUrl?>"><img src="<?php echo $logotype ?>"></a>
			</div>
	<div id="start"></div>
		<div class="content" >
			<div class="contenttext">
					
			<h1><?php echo $welcomeTitle;?></h1>

			<br>

			<p><?php echo nl2br($welcomeText); ?></p><br>
			</div>
			<img src="images/tjuvkika.png"><br>
					 <?php 

					while($row = $entriesRes->fetch_object()) :  
						
						

						if($row->accepted == 'y'){
							?>
							
							<div class="entryWrapper">
								<div class="entryText">
									<h2><?php echo $row->entryName ?></h2> 
								</div>
								<div class="entryImg">
									<img class="productStyle " src="images/product/productImage.png">
									<img class="imgStyle" src="<?php echo $row->entryImage ?>">
								</div>
									
								<div class="roster">
								
								<a href='addVote.php?entryId=<?php echo $row->entryId; ?>'>
								<input id="rosta" name="rosta" type="submit" value="Lägg din röst!" /></a>
								<div class="arrow-right"></div>
								<p class="votes"><strong><?php echo $row->votes ?></strong></p>
								</div>	
							
							</div>


					<?php }
				endwhile; ?>
		</div>



	
	<img src="images/linje.png" >
			

<div id="design" ></div>
		<div class="content" >
			<div class="contenttext">
			
			
			<h1>Designa produkten här!</h1> 
			<br>
</div>
			<div class="product">
			 
			 <form method="post" action="upload_image.php" enctype="multipart/form-data" target="leiframe">
      			<p>Välj en bild<p> 
      			<input  type="file" name="image" />
      			<input type="submit" value="Ladda upp"/>
    		</form>

    		<br>
			<img src="images/product/productImage.png">
			<iframe allowTransparency="true" name="leiframe"></iframe></div>
		
	<div class="sendEntry">
		<p>Skicka in ditt bidrag</p>
		<p><strong>Du måste fylla i alla fält först</strong></p><br>
			

			<form action="index.php#design" method="post" >
				<label for="designerName"> <p>Ditt namn</p> </label> <div id="errorDesignerName"></div>

				<input  type="text" id="designerName" name="designerName" value=""><br>

				<label for="entryName"> <p>Döp ditt bidrag</p> </label> <div id="errorEntryName"></div>

				<input  id="entryName" name="entryName" value=""  ><br>

				<label for="designerCity"> <p>Ort</p> </label> <div id="errorDesignerCity"></div>

				<input  id="designerCity" name="designerCity"  value=""><br>

				<label for="designerEmail"> <p>Email</p> </label> <div class="msg error">Ingen riktig email</div> <div class="msg success">Rätt!</div>
 
				<input  id="designerEmail" name="designerEmail"  value=""><br>

				<label for="checkbox" name="agreeMailLabel">Ja, jag vill ha nyhetsbrev</label>

				<input name="agreeMail" type="checkbox" />
				
				<input type="submit" name="sendEntry" value="SKICKA BIDRAG!"  /> 
			
			</form>
				
	

	</div>
		</div>



	
	<img src="images/linje.png">


<div id="toplist"></div>
		<div class="content" >
			<div class="contenttext">
			 <h1> Topplistan, topp 8</h1><br>
			</div>
			 <?php 

					while($row = $entriesTop->fetch_object()) :  
						

							if($row->accepted == 'y'){
							?>
							
							<div class="entryWrapper">
								<div class="entryText">
									<h2><?php echo $row->entryName ?></h2> 
								</div>
								<div class="entryImg">
									<img class="productStyle" src="images/product/productImage.png">
									<img class="imgStyle" src="<?php echo $row->entryImage ?>">
								</div>
									
								<div class="roster">
								<a href='addVote.php?entryId=<?php echo $row->entryId; ?>'>
								<input id="rosta" name="rosta" type="submit" value="Lägg din röst!" /></a>
								<div class="arrow-right"></div>
								<p class="votes"><strong><?php echo $row->votes ?></strong></p>
								</div>	
							
							</div>


						<?php }
					endwhile; ?>
		</div>



	<img src="images/linje.png" >

	<div id="latest"></div>
		<div class="content" >
			<div class="contenttext">


			<h1>De senaste 8 bidragen</h1><br>
			</div>
					 <?php 

					while($row = $entriesDate->fetch_object()) :  
						
							if($row->accepted == 'y'){

							?>
							
							<div class="entryWrapper">
								<div class="entryText">
									<h2><?php echo $row->entryName ?></h2> 
								</div>
								<div class="entryImg">
									<img class="productStyle" src="images/product/productImage.png">
									<img class="imgStyle" src="<?php echo $row->entryImage ?>">
								</div>
									
								<div class="roster">
								<a href='addVote.php?entryId=<?php echo $row->entryId; ?>'>
								<input id="rosta" name="rosta" type="submit" value="Lägg din röst!" /></a>
								<div class="arrow-right"></div>
								<p class="votes"><strong><?php echo $row->votes ?></strong></p>
								</div>	
							
							</div>


					<?php }
					endwhile; ?>


		</div>






	<img src="images/linje.png">

	<div id="rule"></div>
		<div class="content" >
			<div class="contenttext">
		
			<h1><?php echo $ruleTitle;?></h1>
			</div>
			<br>


			<p><?php echo nl2br($ruleText); ?></p>
			

		</div>
<img src="images/linje.png">


<?php include("includes/footerFront.php");
