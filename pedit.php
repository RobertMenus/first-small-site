<?php
session_start();
if (!isset($_SESSION['works']))
{
	header('Location: index.php');
	exit();
}
include './blocks/db.php';
if (!empty($_GET['p']))
{
	$tablo = $_GET['p'];
}
else
{
	header('Location: '.$_SERVER['HTTP_REFERER']);
	exit();
}
if (isset($_SESSION['lang']))
	{$lang = $_SESSION['lang'];}
else
	{$lang = 'en';}
$result = $db->prepare('SELECT selectlang,availablelang FROM trans_pages_editor WHERE lang = :lang');
$result->bindParam(':lang',$lang);
$result->execute();
$row = $result->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head><meta content = "text/html" charset = "UTF-8">
<title><?php echo $row['selectlang'];?></title></head>

<body background="img/bg.gif">
<table border="1px" width="100%" bgcolor=#cccccc>
<?php include './blocks/langbar.php'; ?>
<tr>
<?php include 'blocks/logmenu.php';?>
<td><h3><?php echo $row['availablelang']." ".$tablo;?></h3>
	<table>
	<?php
	$query = $db->prepare("SELECT lang FROM $tablo");
	$query->execute();
	while ($langs = $query->fetch())
	{
		echo "<tr><td><a href = 'peditit.php?p=$tablo&l=$langs[0]'>$langs[0]</a></td></tr>";
	}
	?>
	</table>
</td>
</tr>
</table>
</body>
</html>