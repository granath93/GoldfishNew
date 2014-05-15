<!--
DENNA FIL ÄR SJÄLVA FRONT-END. WEBBSIDAN SOM VISAS UTÅT MOT BESÖKANRA
-->

<?php
session_start(); //startar session så att olika variabler kan föras över mellan olika filer

//inkluderar databaskopplingen
include("includes/db.php");

//Startar hela sidan
include("includes/headFront.php");

//Lägger till filen som kollar om alla fält är ifyllda i formuläret i designscnene
include("sendEntry.php");

//Gör så att sidan och databasen kan visa svenska tecken så som ÅÄÖ
$mysqli->set_charset("utf8");


//hämtar allt från tabellerna ENTRY och DESIGNER och sätter en limit på 4 för att skriva ut detta i "start"-sektionen. 
//Ordnar bidragen efter flest antal röster
$inspentries = 'SELECT *
	FROM Entry, Designer 
	GROUP BY Entry.entryName, Entry.entryImage, Entry.timeStamp
	ORDER BY  votes DESC LIMIT 4';

//hämtar allt från tabellerna ENTRY och DESIGNER och sätter en limit på 8 för att skriva ut detta i "toppbidrag"-sektionen. 
//Ordnar bidragen efter flest antal röster
$topentries = 'SELECT *
	FROM Entry, Designer 
	WHERE Entry.accepted = "y"
	GROUP BY Entry.entryName, Entry.entryImage, Entry.timeStamp
	ORDER BY votes DESC LIMIT 8';

//hämtar allt från tabellerna ENTRY och DESIGNER och sätter en limit på 8 för att skriva ut detta i "senaste bidragen"-sektionen. 
//Ordnar bidragen efter senast tillagda
$dateentries = 'SELECT *
	FROM Entry, Designer 
	WHERE Entry.accepted = "y"
	GROUP BY Entry.entryName, Entry.entryImage, Entry.timeStamp
	ORDER BY Entry.timeStamp DESC LIMIT 8';


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

		} ?>

	<div class="logotype">
		<a href="<?php echo $logotypeUrl?>"><img src="<?php echo $logotype ?>"></a>
	</div>

	<!--
	HÄR STARTAR FÖRSTA SEKTIONEN, START
	-->
	<div id="start"></div>
		<div class="content" >
			<div class="contenttext">
				
				<!-- Skriver ut välkomsttexten som admin skriver in i admin-delen -->	
				<h1><?php echo $welcomeTitle;?></h1>
				<br>
				<p><?php echo nl2br($welcomeText); ?></p><br>

			</div>

	<!-- Avskiljningslinjen till sektionerna skrivs ut -->
	<img class="inspire" src="images/tjuvkika.png"><br>
					 

	<?php 	while($row = $entriesRes->fetch_object()) : 

					//Skriver endast ut de som är godkända av administratören som då har y i fältet "accepted" i databasen
						if($row->accepted == 'y'){ 	?>

						<!-- Skriver ut de fyra toppbidragen i "start"-sektionen -->
							<div class="entryWrapper">
								
								<!-- Bidragsnamnet -->
								<div class="entryText">
									<h2><?php echo $row->entryName ?></h2> 
								</div>
								
								<!-- Bilderna -->
								<div class="entryImg">
									<img class="productStyle " src="images/product/productImage.png">
									<img class="imgStyle" src="<?php echo $row->entryImage ?>">
								</div>
								
								<!-- Röstknappen -->	
								<div class="roster">
									<a href='addVote.php?entryId=<?php echo $row->entryId; ?>'>
									<input id="rosta" name="rosta" type="submit" value="Lägg din röst!" onclick="addVote();" /></a>
									
									<div class="arrow-right"></div>
									
									<p class="votes"><strong><?php echo $row->votes ?></strong></p>
								</div>	
							
							</div>
					<?php }
				endwhile; ?>
		</div>



	<!-- Avskiljningslinjen till sektionerna skrivs ut -->
	<img class="line" src="images/linje.png" >
			

		<!-- Här börjar "designa"-sektionen där designscenen ligger samt formuläret till denna -->

			<div id="design" ></div>
				<div class="content" >
					<div class="contenttext">
					
						<!-- Rubriken -->	
						<h1>Designa produkten här!</h1> 
						<br>

					</div>

					<!-- Designscenen med produkt och bidragsbild -->
					<div class="product">
					 
						 <form method="post" action="upload_image.php" enctype="multipart/form-data" target="leiframe">
			      			<p>Välj en bild<p> 
			      			<input  type="file" name="image" />
			      			<input type="submit" value="Ladda upp"/>
			    		</form>

		    			<br>

						<img src="images/product/productImage.png">
						<iframe allowTransparency="true" scrolling="no" name="leiframe"></iframe></div>
				

						<!-- Formuläret som ligger intill designscenen -->
							<div class="sendEntry">
								<p>Skicka in ditt bidrag</p>
								<p><strong>Du måste fylla i alla fält först</strong></p><br>
									

									<form action="index.php#design" method="post" >
										<label for="designerName"> <p>Ditt namn</p> </label> <div id="errorDesignerName"></div>

										<input  type="text" id="designerName" name="designerName" value="" maxlength="18"><br>

										<label for="entryName"> <p>Döp ditt bidrag</p> </label> <div id="errorEntryName"></div>

										<input  type="text" id="entryName" name="entryName" value="" maxlength="10" ><br>

										<label for="designerCity"> <p>Ort</p> </label> <div id="errorDesignerCity"></div>

										<input  type="text" id="designerCity" name="designerCity" value="" maxlength="20"><br>

										<label for="designerEmail"> <p>Email</p> </label> <div class="msg error">Ingen riktig email</div> <div class="msg success">Rätt!</div>
						 
										<input  type="text" id="designerEmail" name="designerEmail"  value=""><br>

										<label for="checkbox" name="agreeMailLabel">Ja, jag vill ha nyhetsbrev</label>

										<input name="agreeMail" type="checkbox" />
										
										<input type="submit" name="sendEntry" value="SKICKA BIDRAG!"  /> 
									
									</form>
							</div>
						</div>



	<!-- Avskiljningslinjen till sektionerna skrivs ut -->
	<img  class="line" src="images/linje.png">

		<!-- Här börjar "toppblistan"-sektionen -->	
			<div id="toplist"></div>
				<div class="content" >
					<div class="contenttext">
						 <h1> Topplistan, topp 8</h1><br>
					</div>
			

			 <?php 	while($row = $entriesTop->fetch_object()) :  
					//Skriver endast ut de som är godkända av administratören som då har y i fältet "accepted" i databasen
							if($row->accepted == 'y'){ ?>
							
							<!-- Skriver ut de 8 toppbidragen i "topplistan"-sektionen -->
								<div class="entryWrapper">

								<!-- Bidragets namn -->
									<div class="entryText">
										<h2><?php echo $row->entryName ?></h2> 
									</div>
								
								<!-- Produkten och bidragets bild -->
								<div class="entryImg">
									<img class="productStyle" src="images/product/productImage.png">
									<img class="imgStyle" src="<?php echo $row->entryImage ?>">
								</div>
									
								<!-- Röstaknappen -->	
								<div class="roster">
									<a href='addVote.php?entryId=<?php echo $row->entryId; ?>'>
									<input id="rosta" name="rosta" type="submit" value="Lägg din röst!" onclick="addVote();" /></a>
									<div class="arrow-right"></div>
									<p class="votes"><strong><?php echo $row->votes ?></strong></p>
								</div>	
							</div>
		<?php }
					endwhile; ?>
			</div>


	<!-- Avskiljningslinjen till sektionerna skrivs ut -->
	<img class="line" src="images/linje.png" >

			<div id="latest"></div>
				<div class="content" >
					<div class="contenttext">
						<h1>De senaste 8 bidragen</h1><br>
					</div>


			 <?php 	while($row = $entriesDate->fetch_object()) :  
								//Skriver endast ut de som är godkända av administratören som då har y i fältet "accepted" i databasen
									if($row->accepted == 'y'){ ?>
									
								<!-- Skriver ut de 8 senaste bidragen i "senaste bidrag"-sektionen -->								
									<div class="entryWrapper">

									<!-- Bidragets namn -->
										<div class="entryText">
											<h2><?php echo $row->entryName ?></h2> 
										</div>

									<!-- Produkten och bidragets bild -->
										<div class="entryImg">
											<img class="productStyle" src="images/product/productImage.png">
											<img class="imgStyle" src="<?php echo $row->entryImage ?>">
										</div>
										
									<!-- Röstaknappen -->			
										<div class="roster">
											<a href='addVote.php?entryId=<?php echo $row->entryId; ?>'>
											<input id="rosta" name="rosta" type="submit" value="Lägg din röst!" onclick="addVote();"  /></a>
											<div class="arrow-right"></div>
											<p class="votes"><strong><?php echo $row->votes ?></strong></p>
										</div>	
									</div>
			<?php }	endwhile; ?>

			</div>


	<!-- Avskiljningslinjen till sektionerna skrivs ut -->
	<img class="line" src="images/linje.png">

				<!-- Här börjar tävlingsreglerna som admin skriver in på admin-delen -->
					<div id="rule"></div>
						<div class="content" >
							<div class="contenttext">
							
							<!-- Tävlingsreglernas rubrik -->
								<h1><?php echo $ruleTitle;?></h1>
								<br>
							</div>
							
							<!-- Tävlingsreglernas brödtext -->
								<p><?php echo nl2br($ruleText); ?></p>
						</div>

					
					<!-- Avskiljningslinjen till sektionerna skrivs ut -->
					<img class="line" src="images/linje.png">


<!-- Avslutar hela sidan -->
<?php include("includes/footerFront.php");
