<?php
include './blocks/db.php';
session_start();
if (!isset($_SESSION['works']))
{
	header('location: index.php');
	exit();
}

if (isset($_POST['title'])) {
	$title = $_POST['title']; 
	if ($title == '') {unset($title);}}
if (isset($_POST['date'])) 	{
	$date = $_POST['date']; 
	if ($date == '') {unset($date);}}
if (isset($_POST['text'])) 	{
	$text = $_POST['text']; 
	if ($text == '') {unset($text);}}
if (isset($_POST['author'])){
	$author = $_POST['author']; 
	if ($author == '') {unset($author);}}

?>
<!DOCTYPE html>
<html>
<head><meta content = 'text/html' charset = 'UTF-8'>
<title>Adding...</title></head>

<body background='img/bg.gif'>

<table border='1px' width="100%" bgcolor=#cccccc>
<tr>
<?php 
	include './blocks/logmenu.php'; 
?>
<td valign = 'top'>
 <?php 
		if (isset($title,$text,$date,$author))
		{
		/*$result = mysql_query(
			"INSERT into news (title, author, date, text) 
			VALUES ('$title','$author','$date','$text')", $db) 
		or die(mysql_error());*/

		$result = $db->prepare("INSERT into news (title, author, date, text) 
			VALUES (:title,:author,:date,:text)");
		$result:bindParam(':title',$title);
		$result:bindParam(':author',$author);
		$result:bindParam(':date',$date);
		$result:bindParam(':text',$text);
		$result:execute();
		
		if ($result) {
			echo 'Successfuly added.'; 
			$res = $db->prepare("SELECT * FROM news WHERE title = :title
				and author = :author and date = :date and text=:text");
			$res:bindParam(':title',$title);
			$res:bindParam(':author',$author);
			$res:bindParam(':date',$date);
			$res:bindParam(':text',$text);
			$res:execute();
			
			$lastid = $res->fetch(PDO::FETCH_ASSOC);
			$idlast = $lastid['id'];
			echo "You'll be redirected in few seconds";
			echo 'If not - click <a href = "news_view.php?id=$idlast">here</a>';
			header("Location:news_view.php?id=$idlast"); 
			exit();
			}
		else
		{echo 'Sorry. We got some problems.';}
		}
		else
		{echo 'Sorry. Not all fields are filled.';}
		?>
</td>
</tr>
</table>

</body>

</html>