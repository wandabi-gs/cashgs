<?php

require 'nav.php';
require '../libs/connect.php';

$command="SELECT accountbal FROM accounts WHERE accountno=?";

if($query=mysqli_prepare($connect,$command))
{
	mysqli_stmt_bind_param($query,"s",$param_accountno);
	$param_accountno=$accountno;

	if(mysqli_execute($query))
	{
		mysqli_stmt_store_result($query);

		mysqli_stmt_bind_result($query,$accountbal);
       
       if(mysqli_stmt_fetch($query))
       {



?>
<span hidden id="greet">&nbsp</span>
<h2>Account</h2>
<div>
	BALANCE: <?php echo $accountbal; ?>
</div>
<h2>Transactions history</h2>
<div>
	<table>
		<tr>
			<th>TIME</th>
			<th>TRANSACTION</th>
		</tr>
<?php

$query="SELECT * FROM $username ORDER BY time DESC LIMIT 5";
$result=mysqli_query($connect,$query);

while ($records = mysqli_fetch_array($result))
{


?>	
	
<tr>
	<td>
		<?php echo $records["time"];?>
	</td>
	<td>
		<?php echo $records["transaction"]; ?>
	</td>
</tr>		


<?php
}
       }
	}
}

?>
	</table>
</div>
</div>
</body>
</html>