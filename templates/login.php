<?php
session_start();
require '../libs/connect.php';
require '../libs/loggedin.php';

if(isset($_POST['submit']))
{

$phoneno=trim($_POST['phoneno']);
$code=trim($_POST['code']);
$accountno=$code.$phoneno;
$password=trim($_POST['password']);

$command="SELECT user_id,unique_id,surname,email,password FROM accounts where accountno=?";

if($query=mysqli_prepare($connect,$command))
{
	mysqli_stmt_bind_param($query,"s",$param_accountno);
	$param_accountno=$accountno;
	if(mysqli_execute($query))
	{
		mysqli_stmt_store_result($query);

		if(mysqli_stmt_num_rows($query) ==1)
		{
              mysqli_stmt_bind_result($query,$userid,$unique_id,$surname,$email,$password_hash);
              if(mysqli_stmt_fetch($query))
              { 
              if(password_verify($password,$password_hash))
              {
				 $status = "online";
				 $sql2 = mysqli_query($connect, "UPDATE users SET status = '$status' WHERE unique_id = $unique_id");
              	 if($sql2)
				{ 
				 $_SESSION['username']=$surname.$userid;
				 $_SESSION['loggedin']=true;
				 $_SESSION['surname']=$surname;
                 $_SESSION['accountno']=$accountno;
                 $_SESSION['email']=$email;
				 $_SESSION['unique_id'] = $unique_id;
                 header("location: home.php");
			     }
              }
              else
              {
              	$log_err="The password is wrong";
              }			
			}
		}
		else
		{
			$log_err="User does not exist";
		}
}

}
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../css/formstyle.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <script type="text/javascript" src="../javascript/showpass.js"></script>
	<title>MONEY-TRANSFER-LOGIN</title>
</head>
<body>
<div class="login">
	<div class="links"><a href="register.php" class="passive">REGISTER</a> <a class="active" href="login.php">LOGIN</a></div>
	<div class="mess">
		<?php if(isset($log_err)){ echo $log_err; } ?>
	</div>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">

		<select name="code">
			<option>+254</option>
			<option>+255</option>
			<option>+256</option>
		</select>
		<input type="long" name="phoneno" placeholder="PHONE NUMBER" required><br>
		<input type="password" name="password" placeholder="Password" id="password" required><br>
		<input type="checkbox" name="show" onclick="showpass()"><label>show password</label>
		<input type="submit" name="submit" value="LOGIN">
	</form>
	</div>	

</body>
</html>