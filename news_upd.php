<?php
include './blocks/db.php';
session_start();
if (!isset($_SESSION['works']))
{
	header('Location: index.php');
	exit();
}
$langs = '';
if ((isset($_POST['title'])) and ($_POST['title'] <> '')) {
	$title = $_POST['title']; 
	}
if ((isset($_POST['date'])) and ($_POST['date'] <> '')) {
	$date = $_POST['date']; 
	}
if ((isset($_POST['text_en'])) and (!empty($_POST['text_en']))) {
	$langs .= 'en;';
	$text_en = $_POST['text_en']; 
	}
	else
		{$text_en = '';}
if ((isset($_POST['text_ua'])) and (!empty($_POST['text_ua']))) {
	$langs .= 'ua;';
	$text_ua = $_POST['text_ua']; 
	}
	else
		{$text_ua = '';}
if ((isset($_POST['author'])) and ($_POST['author'] <> '')) {
	$author = $_POST['author']; 
	}

$id = $_SESSION['cid'];
unset($_SESSION['cid']);

if (isset($_SESSION['lang']))
	{$lang = $_SESSION['lang'];}
else
	{$lang = 'en';}
$result = $db->prepare('SELECT * FROM trans_news_upd WHERE lang = :lang');
$result->bindParam(':lang',$lang);
$result->execute();
$row = $result->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head><meta content = "text/html" charset = "UTF-8">
<title><?php echo $row['updating'];?></title>
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
$result = $db->prepare("UPDATE news SET title = :title, date = :date, text_ua = :textua, 
	text_en = :texten, author = :author, langs = :langs WHERE id = :id");
$result->bindParam(':title',$title);
$result->bindParam(':date',$date);
$result->bindParam(':texten',$text_en);
$result->bindParam(':textua',$text_ua);
$result->bindParam(':author',$author);
$result->bindParam(':langs',$langs);
$result->bindParam(':id',$id);
$result->execute();
if ($result)
{
	echo "<p>".$row['success']."</p>";
	echo "<p><a href = 'news_view.php?id=$id'>".$row['presshere']."</a> ".$row['towatchit']."</p>";
	echo "<a href = 'index.php'>".$row["orhere"]."</a> ".$row['allnews'];
}
else
{
	echo "<p>".$row['smthwrong']."</p>";
}
unset($id);
?>
</td>
</tr>
</table>
</body>
</html>