<!DOCTYPE html>
<html>
<head><meta content = "text/html" charset = "UTF-8">
<title>Register</title></head>

<body background="img/bg.gif">
<table border="1px" width="100%" bgcolor=#cccccc>
<?php include './blocks/langbar.php'; ?>
<tr>
<?php include 'blocks/logmenu.php'; ?>
<td><h3>Register yourself</h3>
	<form method = "post" action = "blocks/regcheck.php">
	<table>
	<tr><td>Login:</td>
	<td><input type = "text" name = "login" maxlength = 64 size = 25></td></tr>
	<tr><td>E-mail:</td>
	<td><input type = "text" name = "mail" maxlength = 64 size = 25></td></tr>
	<tr><td>Password:</td>
	<td><input type = "text" name = "pass" maxlength = 64 size = 25></td></tr>
	<tr><td>Repeat password:</td>
	<td><input type = "text" name = "pass2" maxlength = 64 size = 25></td></tr>
	<tr><td></td><td align = "right"><input type = "submit" value = "Register"></td></tr>
	</table></form>
	
	<?php 
	if ($_GET['e']==1){
	echo "<p><font color='red'>
		Login or/and e-mail is already used.<br>
		Possibly, you're already registered.
		</font></p>";
	}
	if ($_GET['e']==2){
	echo "<p><font color='red'>
		Passwords do not match!
		</font></p>";
	}?>
</td>
</tr>
</table>
</body>
</html>