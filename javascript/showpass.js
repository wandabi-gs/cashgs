	function showpass()
	{
		var pass=document.getElementById("password");
        if(pass.type=="password")
		{
          pass.type="text";
		}
		else
		{
			pass.type="password";
		}


		var cpass=document.getElementById("cpassword");
        if(cpass.type=="password")
        {
        	cpass.type="text";
        }
        else
        {
        	cpass.type="password";
        }
	 }       