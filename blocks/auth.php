<?php 
include "db.php";
$login = $_POST['login'];
try{
$res = $db->prepare("SELECT id, login, email, pass, class 
	FROM users WHERE (login = :login or email = :login)");
$res->bindParam(':login',$login);
$res->execute();
$logrow = $res->fetch(PDO::FETCH_ASSOC);
}
catch (PDO_exception $e)
{die ("Error:".$e->getMessage());}
$passw = $_POST['pass'];
if ($logrow['pass'] == $passw) {
	session_start();
	$_SESSION['class'] = $logrow['class'];
	if ($_SESSION['class']=='banned')
	{
		header("Location: ../banned.php");
		exit();
	}
	$_SESSION['works'] = $logrow['login'];
	$_SESSION['id'] = $logrow['id'];
	$result = $db->prepare("UPDATE users SET lastlog=:lastlog WHERE id = :id");
	$result->bindParam(':lastlog',date('Y-m-d'));
	$result->bindParam(':id',$_SESSION['id']);
	$result->execute();
	header('Location: ../index.php');} 
	else {
	echo '<p><b>Login/Password is incorrect</b></font></p>';
	echo '<form method = "post" action = "auth.php">';
	echo '<table>';
	echo '<tr><td>Login/Email:<br>';
	echo '<input type = "text" name = "login" maxlength = 64 size = 15></td></tr>';
	echo '<tr><td>Pass:<br>';
	echo '<input type = "password" name = "pass" maxlength = 64 size = 15></td></tr>';
	echo '<tr><td align = "right"><input type = "submit" value = "Enter"></td></tr>';
	echo '</table></form>';
}?>