<?php
$pageTitle="Text"; //Skriver in vad som skall stå i "webb-browser-fliken"
$currentPage = "text"; //Lägger in värde så man vet vilken sida administratören är på

//Lägger till filer som behöver vara med på sidan så att sidan skall fungera rätt
include("includes/db.php"); 
include("includes/headAdmin.php"); 

//Sparar det som finns i alla fält i formuläten och sparar de i variabler
$session = isset($_GET['p']) ? $_GET['p'] : 'welcome' ; 
$feedback="";
$empty="";
$arrow="";


//Hämtar all data från tabellen "Text" ur databasen
$query = <<<END
SELECT *
FROM Text;
END;

//Exekutiverar "verkställer" SELECT-satsen
$res = $mysqli->query($query) or die("Could not query database" . $mysqli->errno . 
" : " . $mysqli->error); //Performs query

//Loopar igenom alla attribut i tabellen och lägger in de i variabler
while($row = $res->fetch_object()) { 
$textId = ($row->textId);
$welcomeTitle = ($row->welcomeTitle); 
$welcomeText = ($row->welcomeText); 
$ruleTitle = ($row->ruleTitle);
$ruleText = ($row->ruleText);
$mailTitle = ($row->mailTitle);
$mailText = ($row->mailText); 
}


//När användaren trycker på "spara"-knappen uppdateras och sparas välkomsttexten, 
//reglerna och mailen i respektive tabeller/fält som ligger i formuläret
if(isset($_POST['save'])){

//Här börjar satsen som sparar välkomsttexten
 	if(isset($_POST['welcomeTitle']) && isset($_POST['welcomeText']) ){

//Sparar det som står i formuläret i variabler
	$welcomeTitle = isset($_POST['welcomeTitle']) ? $_POST['welcomeTitle'] : '' ;  
	$welcomeText = isset($_POST['welcomeText']) ? $_POST['welcomeText'] : '' ; 

//Här uppdateras tabellen med allt som är skrivet i formuläret
		$query =<<<END
		UPDATE Text
		SET welcomeTitle = '$welcomeTitle', welcomeText = '$welcomeText'
		WHERE textId = $textId
END;

//Exekutiverar "verkställer" UPDATE-satsen
	$res = $mysqli->query($query) or die("Failed");
	$feedback = "Sparat";
	}

//Här börjar satsen som sparar regeltexten, gör på samma sätt som välkomsttextens sats
	if(isset($_POST['ruleTitle']) && isset($_POST['ruleText']) ){


	$updateRuleTitle = isset($_POST['ruleTitle']) ? $_POST['ruleTitle'] : '' ;  
	$updateRuleText = isset($_POST['ruleText']) ? $_POST['ruleText'] : '' ; 


		$query =<<<END
		UPDATE Text
		SET ruleTitle = '$updateRuleTitle', ruleText = '$updateRuleText'
		WHERE textId = $textId
END;


	$res = $mysqli->query($query) or die("Failed");
	$feedback = "Sparat";
	}

//Här börjar satsen som sparar mailtexten, gör på samma sätt som välkomsttextens sats
	if(isset($_POST['mailTitle']) && isset($_POST['mailText']) ){

	$updateMailTitle = isset($_POST['mailTitle']) ? $_POST['mailTitle'] : '' ;  
	$updateMailText = isset($_POST['mailText']) ? $_POST['mailText'] : '' ; 

		$query =<<<END
		UPDATE Text
		SET mailTitle = '$updateMailTitle', mailText = '$updateMailText'
		WHERE textId = $textId
END;

	$res = $mysqli->query($query) or die("Failed");
	$feedback = "Sparat";
	}

//Hämtar all data från tabellen "Text" ur databasen
	$query = <<<END
	SELECT *
	FROM Text;
END;

//Exekutiverar "verkställer" SELECT-satsen
$res = $mysqli->query($query) or die("Could not query database" . $mysqli->errno . 
" : " . $mysqli->error); //Performs query

//Loopar igenom alla attribut i tabellen och lägger in de i variabler
while($row = $res->fetch_object()) { 
$textId = ($row->textId);
$welcomeTitle = ($row->welcomeTitle); 
$welcomeText = ($row->welcomeText); 
$ruleTitle = ($row->ruleTitle);
$ruleText = ($row->ruleText);
$mailTitle = ($row->mailTitle);
$mailText = ($row->mailText); 
}

}?>

<!--Menyn på vänser sida-->
<div class="leftNav">								<!--class="<?php if($currentPage=="index")echo $class="active" ?>-->

	<ul>
		<li>	<div class="arrow"><?php if($session=="welcome")echo ">"?></div>    <a href="textAdmin.php?p=welcome">		Välkomssttext</a> 		</li>	
		<li>	<div class="arrow"><?php if($session=="rules")echo ">"?></div>		<a href="textAdmin.php?p=rules">		Tävlingsregler</a>		</li>
		<li>	<div class="arrow"><?php if($session=="mail")echo ">"?></div>		<a href="textAdmin.php?p=mail">			Mail</a>				</li>
	</ul>	

</div>

<div class="content">

<?php

//Visar vilken sektion man är på, detta fall i välkomsttext-sektionen
if($session=="welcome"){
$arrow="arrow-right";

//Skriver in den texten som finns i tabellen från databasen och lägger in i en variabel som skall visa texten i formuläret
$showWelcomeTitle = $welcomeTitle;
$showWelcomeText = $welcomeText;

//När användaren trycker på knappen "rensa" tas allt i formuläret bort med denna sats
	if(isset($_POST['reset'])){
	$showWelcomeTitle=$empty;
	$showWelcomeText=$empty;
}

//Om användaren ångrar att han raderade all text ångras rensningen
	if(isset($_POST['regret'])){
	$showWelcomeTitle=$welcomeTitle;
	$showWelcomeText=$welcomeText;
}


?>

<h1>Välkomsttext</h1>

<form action="textAdmin.php?p=welcome" method="post">
			<label class="field" for ="welcomeTitle">Rubrik:</label>
			<input class="field title" type="text" id="welcomeTitle" name="welcomeTitle" value="<?php echo $showWelcomeTitle ?>" /><br>
			<label class="field" for ="welcomeText">Välkomsttext:</label>
			<textarea class="field text" id="welcomeText" name="welcomeText"><?php echo $showWelcomeText ?></textarea><br>
			<button name="reset">Rensa </button>
			<button name="regret">Ångra </button>
			<button name="save">Spara </button>  &nbsp; &nbsp; &nbsp; <?php echo $feedback ?>
		</form>


<?php 

}

//Om användaren har tryckt på "Tävlingsregler" visas denna sektion
 else if($session=="rules") {

//Skriver in den texten som finns i tabellen från databasen och lägger in i en variabel som skall visa texten i formuläret
$showRuleTitle = $ruleTitle;
$showRuleText = $ruleText;

//När användaren trycker på knappen "rensa" tas allt i formuläret bort med denna sats
	if(isset($_POST['reset'])){
	$showRuleTitle=$empty;
	$showRuleText=$empty;
}

//Om användaren ångrar att han raderade all text ångras rensningen
	if(isset($_POST['regret'])){
	$showRuleTitle=$ruleTitle;
	$showRuleText=$ruleText;
}?>

<h1>Tävlingsregler</h1>


<form action="textAdmin.php?p=rules" method="post">
			<label class="field" for ="ruleTitle">Rubrik:</label>
			<input class="field title" type="text" id="ruleTitle" name="ruleTitle" value="<?php echo $showRuleTitle ?>" /><br>
			<label class="field" for ="ruleText">Tävlingsregler:</label>
			<textarea class="field text" id="ruleText" name="ruleText"><?php echo $showRuleText ?></textarea><br>
			<button name="reset">Rensa </button>
			<button name="regret">Ångra </button>
			<button name="save">Spara </button>  &nbsp; &nbsp; &nbsp; <?php echo $feedback ?>
		</form>


<?php 
} 
//Om användaren har tryckt på "Mail" visas mail-sektionen
 else if($session=="mail") {

//Skriver in den texten som finns i tabellen från databasen och lägger in i en variabel som skall visa texten i formuläret
$showMailTitle = $mailTitle;
$showMailText = $mailText;

//När användaren trycker på knappen "rensa" tas allt i formuläret bort med denna sats
	if(isset($_POST['reset'])){
	$showMailTitle=$empty;
	$showMailText=$empty;
}

//Om användaren ångrar att han raderade all text ångras rensningen
	if(isset($_POST['regret'])){
	$showMailTitle=$mailTitle;
	$showMailText=$mailText;
}?>

<h1>Mail</h1>


<form action="textAdmin.php?p=mail" method="post">
			<label class="field" for ="mailTitle">Rubrik:</label>
			<input class="field title" type="text" id="mailTitle" name="mailTitle" value="<?php echo $showMailTitle ?>" /><br>
			<label class="field" for ="mailText">Mailtext:</label>
			<textarea class="field text" id="mailText" name="mailText"><?php echo $showMailText ?></textarea><br>
			<button name="reset">Rensa </button>
			<button name="regret">Ångra </button>
			<button name="save">Spara </button> &nbsp; &nbsp; &nbsp; <?php echo $feedback ?>
		</form>

<?php } ?>

</div>


<?php include("includes/footerAdmin.php"); 

