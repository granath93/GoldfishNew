<!-- 
Denna fil börjar alla sidor i admin. Här finns även $_SESSION som kontrollerar 
om administratören är inloggad eller inte. Innehåller även toppmenyn till alla sidor.
-->


<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width" charset="utf-8"> <!-- Läser av skärmen användaren sitter på -->
		<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
		<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
		<link rel="stylesheet" href="css/normalize.css" >
		<link rel="stylesheet" href="css/admin.css" >
		<script src="js/functions.js" charset="utf-8"></script>
			<title><?php echo $pageTitle?></title>
	</head>
<body>
<?php session_start();

// Om administratören inte är inloggad hamnar han på "logga in"-sidan direkt.
if(!isset($_SESSION['user_id'])){
	header('location:login.php');
} ?>

<div class="wrapper">

	<div class="topNav">
		<a href="indexAdmin.php"><img src ="images/logotype/LogoSmallWhite.png" class="logoSmall" /></a>
			<nav>
				<a class=" <?php if($currentPage=="index")echo "active"?>"  		href="indexAdmin.php">Statistik 				</a>
				<a class=" <?php if($currentPage=="entry")echo "active"?>"  		href="entryAdmin.php">Bidrag 					</a>
				<a class=" <?php if($currentPage=="product")echo "active"?>"  		href="productAdmin.php">Produkt					</a>
				<a class=" <?php if($currentPage=="text")echo "active"?>"  			href="textAdmin.php">Text 						</a>
				<a class=" <?php if($currentPage=="appearance")echo "active"?>" 	href="appearanceAdmin.php">Utseende 			</a>
				<a class=" <?php if($currentPage=="logout") echo "active"?>"		href="logout.php">Logga ut                      </a>
			</nav>
	</div>


