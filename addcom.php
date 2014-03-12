<?php
include './blocks/db.php';
session_start();
if (!isset($_SESSION['works']))
{
	header('Location: index.php');
	exit();
}
$langs = '';
if ((isset($_POST['theme'])) and ($_POST['theme'] != '')) {
	$theme = $_POST['theme']; 
	}
	else
		if ($_POST['text']!='')
		{
			if (strlen($_POST['text'])>15)
			{$theme = substr($_POST['text'], 0, strpos($_POST['text'], " ", 15));}
			else
			{$theme = $_POST['text'];}
		}
if ((isset($_POST['postnumb'])) and ($_POST['postnumb'] != '')) {
	$postnumb = $_POST['postnumb']; 
	}
if ((isset($_POST['text'])) and ($_POST['text']!='')) {
	$text = $_POST['text']; 
	}
if (isset($_SESSION['lang']))
	{$lang = $_SESSION['lang'];}
else
	{$lang = 'en';}
$result = $db->prepare('SELECT * FROM trans_addcom WHERE lang = :lang');
$result->bindParam(':lang',$lang);
$result->execute();
$row = $result->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head><meta content = 'text/html' charset = 'UTF-8'>
<title><?php echo $row['adding'];?></title>
<link rel="stylesheet" type="text/css" href="style.css">
<link rel="icon" type="image/jpg" href="favicon.jpg" /></head>

<body  >

<table border='1px' width="100%" bgcolor=#cccccc>
<?php include './blocks/langbar.php'; ?>
<tr>
<?php 
	include './blocks/logmenu.php'; 
?>
<td valign = 'top'>
 <?php 
		if (isset($postnumb,$text)) {
		$result = $db->prepare('INSERT into comments (postnumb,login,date,theme,langs,text)
			VALUES (:val1,:val2,:val3,:val4,:val5,:val6)');
		$result->bindParam(':val1',$postnumb);
		$result->bindParam(':val2',$_SESSION['works']);
		$result->bindParam(':val3',date('Y-m-d'));
		$result->bindParam(':val4',$theme);
		$result->bindParam(':val5',$_SESSION['lang']);
		$result->bindParam(':val6',$text);
		$result->execute();
		if ($result) {
			echo $row['redirect'];
			echo $row['ifnotclick']."<a href = 'news_view.php?id=".$postnumb."'>".$row['here']."</a>";
			header('Location: news_view.php?id='.$postnumb); 
			exit();
			}
		else
		{echo $row['someproblems'];}
		}
		else
		{echo $row['notfilled'];}
		?>
</td>
</tr>
</table>

</body>

</html>