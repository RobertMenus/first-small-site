<?php
include './blocks/db.php';
session_start();
if (!isset($_SESSION['works']))
{
	header('Location: index.php');
	exit();
}
if (empty($_POST['login'])) {
	header('Location: index.php');
	exit();
}
$id = $_POST['id'];
if ($_SESSION['class'] != 'admin')
{
$result=$db->prepare("SELECT pass FROM users WHERE id = :id");
$result->bindParam(':id',$id);
$result->execute();
$row = $result->fetch(PDO::FETCH_ASSOC);
$oldpass = $_POST['oldpass'];
if ($oldpass == '') {
	header("Location: editme.php?id=$id&e=1");
	exit();}
if ($oldpass != $row['pass']) {
	header("Location: editme.php?id=$id&e=3");
	exit();}
}
$pass1=$_POST['pass'];
$pass2=$_POST['pass2'];
if ($pass1 != $pass2) {
	header("Location: editme.php?id=$id&e=2");
	exit();}
?>
<!DOCTYPE html>
<html>
<head><meta content = "text/html" charset = "UTF-8">
<title>Editing</title>
<link rel="stylesheet" type="text/css" href="style.css"><link rel="icon" type="image/jpg" href="favicon.jpg" /></head>

<body  >

<table border="1px" width="100%" bgcolor=#cccccc>
<?php include './blocks/langbar.php'; ?>
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
$class = $_POST['class'];
$temp = explode(".", $_FILES["ava"]["name"]);
$ext = end($temp);

if (!empty($_FILES['ava']['name']))
{
if ($_FILES["ava"]["size"]>1024*1024)
{
	echo "Too big file. 1 Mb is the max size.";
	echo "<br>Press <a href='editme.php?id=$id'>here </a> to go back";
	exit();
}
$files = array('image/jpeg', 'image/jpg', 'image/gif');
if (!in_array($_FILES["ava"]["type"], $files))
{
	echo "Unsupported file type";
	echo "<br>Press <a href='editme.php?id=$id'>here </a> to go back";
	exit();
}
if (is_uploaded_file($_FILES['ava']['tmp_name']))
{
	unlink($_SERVER['DOCUMENT_ROOT'].'/site1/avs/mini/'.$login.".".$ext);
	if (!move_uploaded_file($_FILES['ava']['tmp_name'], 
		$_SERVER['DOCUMENT_ROOT'].'/site1/avs/mini/'.$login.".".$ext)) 
	{
	echo "OOPS! Can't load new picture"; 
	echo "<br>Press <a href='editme.php?id=$id'>here </a> to go back";
}
	$size = getimagesize($_SERVER['DOCUMENT_ROOT'].'/site1/avs/mini/'.$login.".".$ext);
	if (($size[0]>150) or ($size[1]>150))
	{
		$image_p = imagecreatetruecolor(150, 150);
		switch ($ext) {
			case 'jpg': 
			$image = imagecreatefromjpeg($_SERVER['DOCUMENT_ROOT'].'/site1/avs/mini/'.$login.".jpg");
			break;
			case 'gif': 
			$image = imagecreatefromgif($_SERVER['DOCUMENT_ROOT'].'/site1/avs/mini/'.$login.".gif");
			break;
			case 'jpeg': 
			$image = imagecreatefromjpeg($_SERVER['DOCUMENT_ROOT'].'/site1/avs/mini/'.$login.".jpeg");
			break;
		}
		if (imagecopyresampled(
		$image_p, $image, 0, 0, 0, 0, 150, 150, $size[0], $size[1]))
			{
				unlink($_SERVER['DOCUMENT_ROOT'].'/site1/avs/'.$login.".".$ext);
				switch ($ext) {
					case 'jpeg':
						imagejpeg($image_p,$_SERVER['DOCUMENT_ROOT'].'/site1/avs/'.$login.".jpeg",100);
						break;
					case 'jpg':
						imagejpeg($image_p,$_SERVER['DOCUMENT_ROOT'].'/site1/avs/'.$login.".jpg",100);
						break;
					case 'gif':
						imagegif($image_p,$_SERVER['DOCUMENT_ROOT'].'/site1/avs/'.$login.".gif",100);
						break;
				}
			echo "success";
			};
		unlink($_SERVER['DOCUMENT_ROOT'].'/site1/avs/mini/'.$login.".".$ext);
		echo "stage2<br>";
		echo $_SERVER['DOCUMENT_ROOT'].'/site1/avs/mini/'.$login.".".$ext."<br/>";
		echo $_SERVER['DOCUMENT_ROOT'].'/site1/avs/'.$login.".".$ext."<br/>";
		echo "stage3<br>";	
	}
	else
	{
		rename(
			$_SERVER['DOCUMENT_ROOT'].'/site1/avs/mini/'.$login.".".$ext,
			$_SERVER['DOCUMENT_ROOT'].'/site1/avs/'.$login.".".$ext);
	}
	$path = "avs/".$login.".".$ext;
	echo "That is your new avatar:<br>";
	echo "<img src = '".$path."'/>";}
else
{
	echo "File uploading error.";
	echo "<br>Press <a href='editme.php?id=$id'>here </a> to go back";
	exit();}
}
else
		{$path = '';}

try{
if ($pass1 == ''){ 
	$result = $db->prepare("UPDATE users SET email = :mail, surname = :surname, name = :name, ava=:ava, class = :class WHERE id = :id");
}
else{$result = $db->prepare("UPDATE users SET email = :mail, pass = :pass, surname = :surname, name = :name, ava=:ava, class = :class WHERE id = :id");
$result->bindParam(":pass",$pass1);}
$result->bindParam(":mail",$mail);
$result->bindParam(":surname",$surname);
$result->bindParam(":name",$name);
$result->bindParam(":id",$id);
if (empty($path)) {
	$rest = $db->prepare("SELECT ava FROM users WHERE id = :id");
	$rest->bindParam(":id",$id);
	$rest->execute();
	$tmp = $rest->fetch(PDO::FETCH_ASSOC);
	$path = $tmp['ava'];
}
$result->bindParam(":ava",$path);
$result->bindParam(":class",$class);
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
	echo "<br>Press <a href='editme.php?id=$id'>here </a>to go back";
}
unset($id);
?>
</td>
</tr>
</table>
</body>
</html>