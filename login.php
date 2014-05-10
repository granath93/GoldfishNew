<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/normalize.css" >
<link rel="stylesheet" href="css/admin.css" >
<script src="#" charset="utf-8"></script>
	<title>Login</title>
</head>
<body>



<?php
require 'includes/db.php';
//tom array som ger värden vid fel
$error = array();
//kollar om textrutorna är tomma
if(!empty($_POST)){
	$username = trim($_POST['user']);
	$password = trim($_POST['password']);
//skapar en array med värdena från inputboxarna
	$required_field = array('user', 'password');
//loopar igenom post och tar fram nyckelvärdet och värdet i arrayen
	//om värdet är tomt i posten och tomt i required fields så skrivs fel-
	//meddelande ut
	foreach($_POST AS $key => $value){
		if(empty($value) && in_array($key, $required_field)){
			$error[] = 'Alla fält måste vara ifyllda!';
			break 1;
		}
	}
	//om det forrtfarande inte är tomt i posten och error-arrayen är tom så går koden vidare i stegen
	if(!empty($_POST) && empty($error)){
		$username = $mysqli->real_escape_string($username);
		$password = $mysqli->real_escape_string($password);
		$result = $mysqli->query("SELECT * FROM Administrator WHERE adminName = '{$username}' AND adminPassword = '{$password}'");
		if($result->num_rows){
			$row = $result->fetch_assoc();
			session_start();
			session_regenerate_id();
			//kopplar session med databas-id
			$_SESSION['user_id'] = $row['adminId'];
			header('location:indexAdmin.php'); 
				
		}
		else {
			$error[] = 'Felaktig inloggning!';
			
		}
		$result->free();
	}
	$content = '';
		
	foreach($error as $e){
	
		echo '<p>'.$e.'</p>';
	}
		


}	
?>


<!doctype html>
<html>
<head>
	<meta charset="utf-8">
</head>
<body>
	<div class="loginForm">
<form method="post" action="">

	Admin <input type="text" name="user"><br/>
	Lösenord <input type="password" name="password"><br/>
	<input type="submit" name="submit" value="Logga in"  />
</div>

</form>
</body>
</html>