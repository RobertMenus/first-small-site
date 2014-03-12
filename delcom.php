<?php
session_start();
$id = $_GET['id'];
echo 'ok! id='.$id;
if ((!isset($_SESSION['works'])) or (!isset($id)) or ($_SESSION['class'] != 'admin'))
{
	header('Location: index.php');
	echo "nope!";
	exit();
} 
echo 'im here!';
include './blocks/db.php';
if ((is_numeric($id)) and ($id>0))
{
	$result = $db->prepare("DELETE FROM comments WHERE id=:id");
	$result->bindParam(':id',$id);
	$result->execute();
}
header('Location: '.$_SERVER['HTTP_REFERER']);
exit();
?>