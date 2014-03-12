<?php 
include './blocks/db.php';
session_start();
if (!isset($_SESSION['works']))
{
	header('Location: index.php');
	exit();
}
if (isset($_SESSION['lang']))
	{$lang = $_SESSION['lang'];}
else
	{$lang = 'en';}
$result = $db->prepare('SELECT * FROM trans_pages_editor WHERE lang = :lang');
$result->bindParam(':lang',$lang);
$result->execute();
$row = $result->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head><meta content = "text/html" charset = "UTF-8">
<title><?php echo $row['translation']; ?></title>
<link rel="stylesheet" type="text/css" href="style.css"><link rel="icon" type="image/jpg" href="favicon.jpg" /></head>

<body  >
<table border="1px" width="100%" bgcolor=#cccccc>
<?php include './blocks/langbar.php'; ?>
<tr>
<?php include 'blocks/logmenu.php';?>
<td>
<?php
$tablo = $_POST['tablo'];
$query = "UPDATE $tablo SET ";
$newq = $db->prepare("SHOW COLUMNS FROM $tablo");
$newq->execute();
$myrow = $newq->fetch();
$i = 1;
while ($myrow = $newq->fetch())
{
			$query .= $myrow[0]."= :val".$i.",";
			$i++;
}
$query = substr($query, 0, strlen($query)-1);
$query .= " WHERE lang = :lang";
try
{
$result = $db->prepare($query);
for ($i=1; $i < $_POST['id_count']; $i++) {
	$result->bindParam(":val$i",$_POST["val".$i]);
}
$result->bindParam(':lang',$_POST['lang']);
$result->execute();
}
catch (PDO_exception $e)
{die ("Error:".$e->getMessage());}
if ($result)
{
	echo "<p>".$row['success']."</p>";
	echo "<p><a href = 'index.php'>".$row['presshere']."</a> ".$row['goout'].".</p>";
}
else
{
	echo "<p>".$row['wrong']."</p>";
}
?>
</td>
</tr>
</table>
</body>
</html>