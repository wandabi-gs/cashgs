<?php
require '../libs/connect.php';
require 'nav.php';

$command="SELECT surname,firstname,lastname,email,accountno FROM accounts where accountno=?";

if($query=mysqli_prepare($connect,$command))
{
	mysqli_stmt_bind_param($query,"s",$param_accountno);

	$param_accountno=$accountno;

	if(mysqli_execute($query))
	{
		mysqli_stmt_store_result($query);

		if(mysqli_stmt_num_rows($query) ==1)
		{
			mysqli_stmt_bind_result($query,$surname,$firstname,$lastname,$email,$accountno);
            if(mysqli_stmt_fetch($query))
			{

?>
	<h2>Profile</h2>
	<span hidden id="greet">&nbsp</span>
	<style type="text/css">input{background: transparent;border: none;}</style>
    <form>
	<table>
    	<tr>
    	    <td>FULL NAME</td><td><input type="text" value="<?php echo $surname." ".$firstname." ".$lastname; ?>" readonly></td>
    	</tr>

    	<tr>
    	    <td>ACCOUNT NUMBER</td><td><input type="text" value="<?php echo $accountno; ?>" readonly></td>
    	</tr>

    	<tr>
    		<td>EMAIL</td><td><input type="text" value="<?php echo $email; ?>" readonly></td>
    	</tr>
    </table>
    </form>
</div>
</body>
</html>

<?php
}}}}

?>