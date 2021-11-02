<table >
	<tr>
		<td colspan="2">	
<h4>Please login to continue:</h4> 
</td>
</tr>
<form name="login" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"> 
	<tr> 
		<td>Username:</td> 
		<td><input name="username" type="text" size="50"></td> 
	</tr> 
	<tr> 
		<td>Email Address:</td> 
		<td><input name="emailaddy" type="text" size="50"></td> 
	</tr> 
		<td>Password:</td> 
		<td><input name="password" type="text" size="50"></td> 
	</tr>
	<tr> 
		<td colspan="2" align="center"><input name="login-submit" type="submit" value="Submit"></td> 
	</tr>
</table>
</form>