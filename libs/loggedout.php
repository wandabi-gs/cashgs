<?php 

if(!isset($_SESSION['loggedin']) or $_SESSION['loggedin']!==true)
{
	header("location: login.php");
}

?>