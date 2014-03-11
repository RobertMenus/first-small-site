<?php
include './blocks/db.php';
session_start();
if (!isset($_SESSION['works']) and ($_SESSION['class']!='admin' or $_SESSION['class']!='editor'))
{
	header('location: index.php');
	exit();
}
$langs = '';
if ((isset($_POST['title'])) and ($_POST['title'] <> '')) {
	$title = $_POST['title']; 
	}
if ((isset($_POST['date'])) and ($_POST['date'] <> '')) {
	$date = $_POST['date']; 
	}
if ((isset($_POST['text_en'])) and ($_POST['text_en']<>'')	{
	$langs .= 'en;';
	$text_en = $_POST['text_en']; 
	}
	else
		{$text_en = '';}
if ((isset($_POST['text_ua'])) and ($_POST['text_ua']<>'')	{
	$langs .= 'ua;';
	$text_ua = $_POST['text_ua']; 
	}
	else
		{$text_ua = '';}
if ((isset($_POST['author'])) and ($_POST['author'] <> '')) {
	$author = $_POST['author']; 
	}
if (isset($_SESSION['lang']))
	{$lang = $_SESSION['lang'];}
else
	{$lang = 'en';}
$result = $db->prepare('SELECT * FROM trans_news_add WHERE lang = :lang');
$result->bindParam(':lang',$lang);
$result->execute();
$row = $result->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head><meta content = 'text/html' charset = 'UTF-8'>
<title><?php echo $row['adding'];?></title></head>

<body background='img/bg.gif'>

<table border='1px' width="100%" bgcolor=#cccccc>
<?php include './blocks/langbar.php'; ?>
<tr>
<?php 
	include './blocks/logmenu.php'; 
?>
<td valign = 'top'>
 <?php 
		if (isset($title,$text,$date,$author))
		{

		$result = $db->prepare("INSERT into news (title, author, date, text) 
			VALUES (:title,:author,:date,:langs,:text_en,:text_ua)");
		$result:bindParam(':title',$title);
		$result:bindParam(':author',$author);
		$result:bindParam(':date',$date);
		$result:bindParam(':langs',$langs;
		$result:bindParam(':text_en',$text_en);
		$result:bindParam(':text_ua',$text_ua);
		$result:execute();
		
		if ($result) {
			echo $row['success']; 
			$res = $db->prepare("SELECT * FROM news WHERE title = :title
				and author = :author and date = :date and text_en=:text_en 
				and text_ua = :text_ua");
			$res:bindParam(':title',$title);
			$res:bindParam(':author',$author);
			$res:bindParam(':date',$date);
			$res:bindParam(':text_en',$text);
			$res:bindParam(':text_ua',$text);
			$res:execute();
			
			$lastid = $res->fetch(PDO::FETCH_ASSOC);
			$idlast = $lastid['id'];
			echo $row['redirect'];
			echo $row['ifnotclick'].'<a href = "news_view.php?id=$idlast">'.$row['here'].'</a>';
			header("Location:news_view.php?id=$idlast"); 
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