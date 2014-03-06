<?php
include './blocks/db.php';
session_start();
if (!isset($_SESSION['works']))
{
	header('Location: index.php');
	exit();
}
$id = $_SESSION['id'];
$result=$db->prepare("SELECT pass FROM users WHERE id = :id");
$result->bindParam(':id',$id);
$result->execute();
$row = $result->fetch(PDO::FETCH_ASSOC);
$oldpass = $_POST['oldpass'];
if ($oldpass != $row['pass']) {
	header("Location: editme.php?id=$id&e=3");
	exit();}
if ($oldpass == '') {
	header("Location: editme.php?id=$id&e=1");
	exit();}
$pass1=$_POST['pass'];
$pass2=$_POST['pass2'];
if ($pass1 != $pass2) {
	header("Location: editme.php?id=$id&e=2");
	exit();}
?>
<!DOCTYPE html>
<html>
<head><meta content = "text/html" charset = "UTF-8">
<title>Editing</title></head>

<body background="img/bg.gif">

<table border="1px" width="100%" bgcolor=#cccccc>
<tr>
<?php 
	include './blocks/logmenu.php'; 
?>
<td valign = top>
<?php 
$login = $_POST['login'];
$mail = $_POST['mail'];
$surname = $_POST['surname'];
$name = $_POST['name'];
/*echo "login = ".$login."\n";
echo "oldpass=".$oldpass."\n";
echo "pass=".$pass1."\n";
echo "mail=".$mail."\n";
echo "surname=".$surname."\n";
echo "name=".$name."\n";*/
try{
/*if ($pass1 == ''){ 
	$result = $db->prepare("UPDATE users SET (login = ':login', mail = ':mail',
 	surname = ':surname', name = ':name') WHERE id = :id");
}
else
	{$result = $db->prepare("UPDATE users SET (login = ':login', mail = ':mail', pass = ':pass',
 surname = ':surname', name = ':name') WHERE id = :id");
$result->bindParam(":pass",$pass1);}
$result->bindParam(":login",$login);
$result->bindParam(":mail",$mail);*/
$result = $db->prepare("UPDATE users SET surname = :surname, ");
$result->bindParam(":surname",$surname);
$result->bindParam(":name",$name);
$result->bindParam(":id",$id);
$result->execute();
}
catch (PDO_exception $e)
{
	die ("Error:".$e->getMessage());
}
if ($result)
{
	echo '<p>Successfully updated.</p>';
	echo "<p>Press <a href = 'user_view.php?id=$id'>here</a> to watch it.</p>";
	echo 'Or <a href = "index.php">here</a> to go to main.';
}
else
{
	echo '<p>Something is wrong.</p>';
}
unset($id);
?>
</td>
</tr>
</table>
</body>
</html>