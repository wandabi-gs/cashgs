<?php

$host="localhost";
$user="root";
$pass="gydion1880";
$database="moneytransfer";

$connect=mysqli_connect($host,$user,$pass,$database);

if ($connect===false) 
{
	echo("could not connect to database");
}

?>