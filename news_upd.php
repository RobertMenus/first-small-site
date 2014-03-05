<?php
include './blocks/db.php';
session_start();
if (!isset($_SESSION['works']))
{
	header('Location: index.php');
	exit();
}
if (isset($_POST['title'])) {
	$title = $_POST['title']; 
	if ($title == '') {$title = ' ';}}
if (isset($_POST['date'])) 	{
	$date = $_POST['date']; 
	if ($date == '') {$date = date('Y-m-d');}}
if (isset($_POST['text'])) 	{
	$text = $_POST['text']; 
	if ($text == '') {$text = ' ';}}
if (isset($_POST['author'])){
	$author = $_POST['author']; 
	if ($author == '') {$author = 'Anonymous';}}

$id = $_SESSION['cid'];
//if (!isset($id)) {header("Location: index.php"); exit(); }
//echo "<p>id = $id</p>";
?>
<!DOCTYPE html>
<html>
<head><meta content = "text/html" charset = "UTF-8">
<title>Editing</title></head>

<body background="img/bg.gif">

<table border="1px" width="100%" bgcolor=#cccccc>
<tr>
<?php 
	include './blocks/logmenu.php'; 
?>
<td valign = top>
<?php 
//$query = "UPDATE news SET title = '$title', date = '$date', text = '$text', author = '$author' WHERE id = $id";
//$result = mysql_query($query,$db) or die(mysql_error());
unset($_SESSION['cid']);
$result = $db->prepare("UPDATE news SET title = :title, date = :date, text = :text, author = :author WHERE id = :id");
$result->bindParam(':title',$title);
$result->bindParam(':date',$date);
$result->bindParam(':text',$text);
$result->bindParam(':author',$author);
$result->bindParam(':id',$id);
$result->execute();
if ($result == true)
{
	echo '<p>Successfully updated.</p>';
	echo "<p>Press <a href = 'news_view.php?id=$id'>here</a> to watch it.</p>";
	echo 'Or <a href = "news.php">here</a> to watch all news.';
}
else
{
	echo '<p>Something is wrong.</p>';
}
unset($id);
?>
</td>
</tr>
</table>
</body>
</html>