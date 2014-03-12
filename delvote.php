<?php
session_start();
if ((!isset($_SESSION['works'])) or (!isset($_POST['comm'])))
{
	header('Location: '.$_SERVER['HTTP_REFERER']);
	exit();
} 
include './blocks/db.php';
if ((is_numeric($_POST['comm'])) and ($_POST['comm']>0))
{
	$result = $db->prepare("DELETE FROM marks WHERE id=:id and login=:login");
	$result->bindParam(':id',$_POST['comm']);
	$result->bindParam(':login',$_SESSION['works']);
	$result->execute();
}
header('Location: '.$_SERVER['HTTP_REFERER']);
exit();
?>