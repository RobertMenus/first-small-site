<?php 
session_start();
if ((!isset($_SESSION['works'])) or (!isset($_POST['mark'])) or (!isset($_POST['comm'])))
{
	header('Location: '.$_SERVER['HTTP_REFERER']);
	exit();
} 
include './blocks/db.php';
$goto = 'Location: news_view.php?id='.$_POST['comm'];
if ((is_numeric($_POST['mark'])) and (is_numeric($_POST['comm'])) and
	($_POST['mark']>0) and ($_POST['comm']>0))
{
	$result = $db->prepare("INSERT INTO marks(id,login,mark) VALUES (:id,:login,:mark)");
	$result->bindParam(':id',$_POST['comm']);
	$result->bindParam(':login',$_SESSION['works']);
	$result->bindParam(':mark',$_POST['mark']);
	$result->execute();
	$goto .= '&mes=1';
}
header($goto);
exit();
?>