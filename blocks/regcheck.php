<?php 
include 'db.php';
try{
$res = $db->prepare("SELECT count(*) AS Counto FROM users WHERE (login=:login or email=:mail)");
$res->bindParam(':login',$_POST['login']);
$res->bindParam(':mail',$_POST['mail']);
$res->execute();
$logrow = $res->fetch(PDO::FETCH_ASSOC);
}
catch (PDO_exception $e)
{die ("Error:".$e->getMessage());}
if ($logrow['Counto']!=0)
{
	header('Location: ../reg.php?e=1');
}
else
{
	if ($logrow['pass']!==$logrow['pass2'])
	{ header('Location: ../reg.php?e=2'); }
	try {
		$res = $db->prepare(
			"INSERT into users(class,login, email, pass, registr, lastlog) VALUES('user',:login,:mail,:pass,:registr,:lastlog)");
		$res->bindParam(':login',$_POST['login']);
		$res->bindParam(':mail',$_POST['mail']);
		$res->bindParam(':pass',$_POST['pass']);
		$res->bindParam(':registr',date('Y-m-d'));
		$res->bindParam(':lastlog',date('Y-m-d'));
		$res->execute();

		$res = $db->prepare
			("SELECT id FROM users WHERE login = :login, pass = :pass");
		$res->bindParam(':login',$_POST['login']);
		$res->bindParam(':pass',$_POST['pass']);
		$res->execute();

		$logrow = $res->fetch(PDO::FETCH_ASSOC);

		session_start();
		$_SESSION['works'] = $_POST['login'];
		$_SESSION['id'] = $logrow['id'];
		$_SESSION['class'] = 'user';

		header('Location: ../index.php');
	} catch (PDO_exception $e) {
		die ("Error:".$e->getMessage());}
}?>