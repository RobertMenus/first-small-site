<?php
include './blocks/db.php';
session_start();
if (!isset($_SESSION['works']))
{	header('Location: index.php');
	exit();}

if (isset($_GET['id'])) {
	$id = $_GET['id'];
	if (($id == '') or (!is_numeric($id)) or ($id<1)){
		exit();}
	$result = $db->prepare("DELETE FROM news WHERE id = :id");
	$result->bindParam(':id',$id);
	$result->execute();
	header('Location: index.php');
	}
else
{header('Location: index.php'); $db = null; exit();}
?>