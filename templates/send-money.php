<?php
require '../libs/connect.php';
require 'nav.php';
require '../libs/loggedout.php';

if(isset($_POST['submit']))
{
$phoneno=trim($_POST['phoneno']);
$code=trim($_POST['code']);
$newaccountno=$code.$phoneno;
$amount=trim($_POST['amount']);
$password=trim($_POST['password']);
if($amount>0)
{ 
$command="SELECT accountbal,password FROM accounts WHERE accountno=?";

if($query=mysqli_prepare($connect,$command))
{
	mysqli_stmt_bind_param($query,"s",$param_accountno);

	$param_accountno=$accountno;

	if(mysqli_execute($query))
	{
		mysqli_stmt_store_result($query);
		if(mysqli_stmt_num_rows($query)==1)
		{
			mysqli_stmt_bind_result($query,$accountbal,$password_hash);
			if(mysqli_stmt_fetch($query))
              {

              	if(password_verify($password,$password_hash))
              	{
              		if($accountbal<$amount)
              			{
              			 $send_err="Your account balance is too low to complete the transaction\nAccount bal:".$accountbal;
              			}
              	    else
              	    { 		 
              		    $commandout="SELECT userid,surname,accountbal FROM accounts WHERE accountno=?";
              		    if($queryout=mysqli_prepare($connect,$commandout))
              		    { 
              		    	mysqli_stmt_bind_param($queryout,"s",$param_newaccountno);

              		    	$param_newaccountno=$newaccountno;

              		        if(mysqli_execute($queryout))
              		        {
                              mysqli_stmt_store_result($queryout);

              			      if(mysqli_stmt_num_rows($queryout)==1)
              			      {
              			      	if($accountno==$newaccountno)
              			      	{
              			      		$send_err="Self-transaction is not allowed";
              			      	}
                                else
                                { 
                                 mysqli_stmt_bind_result($queryout,$rec_userid,$rec_surname,$receiverbal);
                                 if(mysqli_stmt_fetch($queryout))
                                 { 
                                    $rec_username=$rec_surname.$rec_userid;
                                    $new_accountbal=$accountbal-$amount;
                                    $new_receiverbal=$receiverbal+$amount;
                                    
                                    mysqli_query($connect,"SET AUTOCOMMIT=0");
                                    mysqli_query($connect,"START TRANSACTION"); 

                                    $sender="UPDATE accounts SET accountbal=$new_accountbal WHERE accountno='$accountno'";
                                    $receiver="UPDATE accounts SET accountbal=$new_receiverbal WHERE accountno='$newaccountno'";

                                    $query_sender=mysqli_query($connect,$sender);
                                    $query_receiver=mysqli_query($connect,$receiver);

                                    if($query_sender && $query_receiver)
                                    {

                                      $send_mess="Confirmed you sent Ksh. ".$amount." to account: ".$newaccountno;
                                      $ins_mess="SENT Ksh.".$amount." TO ACCOUNT NUMBER ".$newaccountno;
                                      $rec_mess="RECEIVED Ksh.".$amount." FROM ACCOUNT NUMBER ".$accountno;

                                      $ins="INSERT INTO $username(transaction) VALUES('$ins_mess')";
                                      $rec_ins="INSERT INTO $rec_username(transaction) VALUES('$rec_mess')";
                                      mysqli_query($connect,$ins);
                                      mysqli_query($connect,$rec_ins);

                                      $code="";
                                      $newaccountno="";
                                      $amount="";
                                      $password="";
                                    }

                                    else
                                    {
                                    	mysqli_query($connect,"ROLLBACK");
                                    	$send_err="An error occured!Try again";
                                    }
                                    mysqli_query($connect,"SET AUTOCOMMIT=1");
                                 }
                                 }
              			      }
              			      else
              			      {
              			      	$send_err="The account number you entered does not exist".$newaccountno;
              			      }
              		        }
              		        else
              		        {
              			       $send_err="An error occured! Try again.";
              		        }
              	        }
                   	}
                }
              	else
              	{
              		$send_err="The password you entered is wrong";
              	}
                
              }
		}
	}

}
}
else
{
  $send_err="Cannot transact amount below Ksh.1";
}

}

?>

	<h2>Send Money</h2>
	<span hidden id="greet">&nbsp</span>
     <h3>
     	Send money to:
     </h3><br>
     <script type="text/javascript" src="../javascript/popup.js"></script>
       <p id="poperr" style="position: relative;color: red;font-size: 18px;"><?php if(isset($_POST['submit'])){ if(isset($send_err)){echo $send_err; $send_err="";}} ?></p>
       <p id="popmess" style="position: relative;color: green;font-size: 18px;"><?php if(isset($_POST['submit'])){ if(isset($send_mess)){ echo $send_mess; $send_mess="";}} ?></p>
       <script type="text/javascript">popup()</script>
     	<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  ?>">
     		<label>Account Number:</label><br>
 		<select name="code">
			<option>+254</option>
			<option>+255</option>
			<option>+256</option>
		</select>
		<input type="long" name="phoneno" placeholder="PHONE NUMBER" required><br><br>
		<input type="text" name="amount" placeholder="Amount to send"><br>
		<input type="password" name="password" placeholder="password" required><br>
		<input type="submit" name="submit" value="SEND">
     	</form>
</div>
</body>
</html>