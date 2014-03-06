<?php
include './blocks/db.php';
session_start();
if ($_SESSION['class'] != 'admin')
{	header('Location: index.php');
	exit();}

if (isset($_GET['l'])) {
	$l = $_GET['l'];
	if ($l == ''){
		exit();}
	$result = $db->prepare("DELETE FROM users WHERE login = :l");
	$result->bindParam(':l',$l);
	$result->execute();
	unlink("images/".$l.".jpg");
	unlink("images/mini/".$l.".jpg");
	$db = null;
	header('Location: userlist.php');
	}
else
{header('Location: index.php'); $db = null; exit();}
?>