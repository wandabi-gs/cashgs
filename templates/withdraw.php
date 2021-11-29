<?php

require 'nav.php';

?>
<h2>Withdraw</h2>
	<span hidden id="greet">&nbsp</span>

<div>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
		<input type="text" name="amount" placeholder="Amount"><br>
		<input type="password" name="password" placeholder="Password"><br>
		<input type="submit" name="submit" value="Withdraw">
		
	</form>
</div>

</body>
</html>