<!--
När administratören har loggat ut kommar han tillbaka till inloggningssidan igen
-->

<?php
session_start();

//$page = $_SERVER['REQUEST_URI'];
$_SESSION = array(); 
 
session_unset(); 
session_destroy(); 
 
header("Location: login.php"); 


?>