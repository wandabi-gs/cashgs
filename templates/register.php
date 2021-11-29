<?php
require '../libs/connect.php';

if(isset($_POST['submit']))
{
$surname=strtoupper(trim($_POST['surname']));
$firstname=strtoupper(trim($_POST['firstname']));
$lastname=strtoupper(trim($_POST['lastname']));
$email=trim($_POST['email']);
$password=$_POST['password'];
$phoneno=trim($_POST['phoneno']);
$code=trim($_POST['code']);
$accountno=$code.$phoneno;
$ran_id = rand(time(), 100000000);
$status = "online";
$command="SELECT email,accountno,password FROM accounts where accountno=?";

if(isset($_FILES['image'])){
	$img_name = $_FILES['image']['name'];
	$img_type = $_FILES['image']['type'];
	$tmp_name = $_FILES['image']['tmp_name'];
	$img_explode = explode('.',$img_name);
	$img_ext = end($img_explode);

	$extensions = ["jpeg", "png", "jpg"]; 
if(in_array($img_ext, $extensions) === true){
		$types = ["image/jpeg", "image/jpg", "image/png"];
if(in_array($img_type, $types) === true){
			$time = time();
			$new_img_name = $time.$img_name;
if(move_uploaded_file($tmp_name,"chats/php/images/".$new_img_name))	
{ 
if($query=mysqli_prepare($connect,$command))
{
	mysqli_stmt_bind_param($query,"s",$param_accountno);
	$param_accountno=$accountno;
	if(mysqli_execute($query))
	{
		mysqli_stmt_store_result($query);

		if(mysqli_stmt_num_rows($query) ==1)
		{
			$reg_err="user already exists";
		}
		else
		{
			$password_hash=password_hash($password, PASSWORD_DEFAULT);
            $accountbal=0;
			$insert_query = mysqli_query($connect, "INSERT INTO accounts (unique_id, surname,firstname, lastname, email,accountno,accountbal, password)
			VALUES ({$ran_id}, '{$surname}' , '{$firstname}','{$lastname}', '{$email}','{$accountno}' , {$accountbal} , '{$password_hash}')");

			if($insert_query)
			{
				  $out="SELECT user_id,surname FROM accounts WHERE accountno=?";
				  if($queryout=mysqli_prepare($connect,$out))
				  { 
				  	mysqli_stmt_bind_param($queryout,"s",$param_accountno);
				  	$param_accountno=$accountno;
				  if(mysqli_execute($queryout))
				  {
				  	mysqli_stmt_store_result($queryout);
				  	if(mysqli_stmt_num_rows($queryout)==1)
				  	{
				  		mysqli_stmt_bind_result($queryout,$num,$surname);
				  		if(mysqli_stmt_fetch($queryout))
				  		{
				  			$tablename=$surname.$num;
				  			$create_table="CREATE TABLE $tablename(time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,transaction VARCHAR(400) NOT NULL)";
				  			if(mysqli_query($connect,$create_table))
				  			{
								$user_query = mysqli_query($connect, "INSERT INTO users (unique_id, fname, lname, email, img, status)
                                VALUES ({$ran_id}, '{$firstname}' , '{$lastname}' , '{$email}', '{$new_img_name}', '{$status}')");
								if($user_query)
								{ 
				  				header("location: login.php");
								}
				  			}
				  		}
				  	}
				  }
				}
			    
			}
			else
			{
				$reg_err="An error occured";
			}
		}
	}
}
}
}}}}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../css/formstyle.css">
	<script type="text/javascript" src="../javascript/showpass.js"></script>
	<title>MONEY-TRANSFER-REGISTER</title>
</head>
<body>

<div class="register">
	<div class="links"><a class="active">REGISTER</a> <a class="passive" href="login.php">LOGIN</a></div>
	<form method="post" enctype="multipart/form-data" autocomplete="off"  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">

		<input type="text" name="surname" placeholder="SURNAME" required="required">
		<input type="text" name="firstname" placeholder="FIRST NAME"  required="required">
		<input type="text" name="lastname" placeholder="LAST NAME"  required="required"><br>
		<input type="email" name="email" required placeholder="EMAIL"><br>
		<select name="code">
			<option>+254</option>
			<option>+255</option>
			<option>+256</option>
		</select>
		<input type="long" name="phoneno" placeholder="PHONE NUMBER" required><br>
		<label>Select Image</label>
          <input type="file" name="image" accept="image/x-png,image/gif,image/jpeg,image/jpg" required>
		<input type="password" name="password" id="password" required placeholder="PASSWORD" minlength="8" maxlength="12"><br>
		<input type="password" name="cpassword" id="cpassword" required placeholder="CONFIRM PASSWORD" minlength="8" maxlength="12"><br>
		<input type="checkbox" name="show" onclick="showpass()"><label>show password</label>
		<input type="submit" name="submit" value="CREATE ACCOUNT">

	</form>
</div>	

</body>
</html>