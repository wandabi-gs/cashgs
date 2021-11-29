<?php
session_start();
$accountno=$_SESSION['accountno'];
$surname=$_SESSION['surname'];
$accountno=$_SESSION['accountno'];
$username=$_SESSION['username'];
$unique_id=$_SESSION['unique_id'];
if(isset($_SESSION['chatname'])) {$chatname=$_SESSION['chatname'];}
require '../libs/loggedout.php';

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../css/nav.css">
	<script type="text/javascript" src="../javascript/time.js"></script>
	<script type="text/javascript" src="../javascript/updatechat.js"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	<title>MONEY TRANSFER</title>
</head>
<body class="loggedin" onload="clock();setInterval('clock()',1000),updatechat();setInterval('updatechat()',2000),scrollmess();">
  <nav class="navtop">
  	<div>
  	<h1>
  		<span id="thetime">&nbsp</span>
  	</h1>
	<a href="home.php"><i class="fas fa-home"></i>Home</a> 
	<a href="profile.php">Profile</a> 
	<a href="send-money.php">Send money</a> 
	<a href="withdraw.php">Withdraw</a> 
	<a href="account.php">Account</a>
	<a href="chats/users.php">Chats</a>
	<a href="../libs/logout.php?logout_id=<?php echo $unique_id; ?>"><i class="fas fa-sign-out-alt"></i>Logout</a>
	</div>
  </nav>	
<div class="content">


