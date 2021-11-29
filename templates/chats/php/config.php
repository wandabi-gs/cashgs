<?php
  $hostname = "localhost";
  $username = "root";
  $password = "gydion1880";
  $dbname = "moneytransfer";

  $conn = mysqli_connect($hostname, $username, $password, $dbname);
  if(!$conn){
    echo "Database connection error".mysqli_connect_error();
  }
?>
