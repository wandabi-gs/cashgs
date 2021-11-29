<?php 

if(isset($_SESSION['loggedin']) and $_SESSION['loggedin']===true)
{
	header("location: home.php");
}

?>