<?php 
include './blocks/db.php';
?>
<!DOCTYPE html>
<html>
<head><meta content = "text/html" charset = "UTF-8">
<title>Register</title>
<link rel="stylesheet" type="text/css" href="style.css"><link rel="icon" type="image/jpg" href="favicon.jpg" /></head>

<body  >
<table border="1px" width="100%" bgcolor=#cccccc>
<?php include './blocks/langbar.php'; ?>
<tr>
<?php include './blocks/logmenu.php'; ?>
<td><h3>Register yourself</h3>
	<form name = 'regfield' method = "post" action = "blocks/regcheck.php" 
	onsubmit="return checkForm()">
	<div id = 'menu'>
	<table>
	<tr><td>Login:</td>
	<td><input type = "text" name = "login" maxlength = 64 size = 25></td></tr>
	<tr><td>E-mail:</td>
	<td><input type = "text" name = "mail" maxlength = 64 size = 25></td></tr>
	<tr><td>Password:</td>
	<td><input type = "text" name = "pass" maxlength = 64 size = 25></td></tr>
	<tr><td>Repeat password:</td>
	<td><input type = "text" name = "pass2" maxlength = 64 size = 25></td></tr>
	<tr><td colspan="2" align = "right"><input type = "submit" value = "Register"></td></tr>
	</table></div></form>
	<script type="text/javascript">
	function checkForm(){
		if (regfield.login.value.length <= 3)
		{
			alert('too short login');
			return false;
		}
		if(! (/^[a-zA-Z0-9_\-\.]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/.test(regfield.mail.value))){
			alert("e-mail error!");
			return false;
		}
		if (regfield.pass.value.length ==0)
		{
			alert('password is not set');
			return false;
		}
		if (regfield.pass.value != regfield.pass2.value)
		{
			alert('passwords do not match!');
			regfield.pass2.focus();
			return false;
		}
	}
	</script> 
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