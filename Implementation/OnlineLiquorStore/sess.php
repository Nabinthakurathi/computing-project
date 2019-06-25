<?php 
session_start();

$loggedIn = false;
if ( isset($_SESSION["username"]) ) {
	$loggedIn = true;
}

?>