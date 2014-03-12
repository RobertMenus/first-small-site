<?php
session_start();
if ($_SESSION['class'] != 'banned')
{
 header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head><meta content = "text/html" charset = "UTF-8">
<title>Main page</title><link rel="stylesheet" type="text/css" href="style.css"><link rel="icon" type="image/jpg" href="favicon.jpg" /></head>

<body  >
<table border="1px" width="100%" bgcolor=#cccccc>
<?php include './blocks/langbar.php'; ?>
<tr>
<?php 
	include ("blocks/logmenu.php"); 
?>
<td valign="top">
<p><h1 align="center">OOPS!</h1></p>
<p><font color="red">I am sorry, but you're banned and can't log in.</font></p>
<p>May be, you had done smth wrong:)</p>
</td>
</tr>
</table>
</body>
</html>