<?php
session_start();
if (!isset($_SESSION['works']))
{
	header('Location: index.php');
	exit();
}
include './blocks/db.php';
if (isset($_SESSION['lang']))
	{$lang = $_SESSION['lang'];}
else
	{$lang = 'en';}
$result = $db->prepare('SELECT editpages, selectpage FROM trans_pages_editor WHERE lang = :lang');
$result->bindParam(':lang',$lang);
$result->execute();
$row = $result->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head><meta content = "text/html" charset = "UTF-8">
<title><?php echo $row['editpages']; ?></title>
<link rel="stylesheet" type="text/css" href="style.css"><link rel="icon" type="image/jpg" href="favicon.jpg" /></head>

<body  >
<table border="1px" width="100%" bgcolor=#cccccc>
<?php include './blocks/langbar.php'; ?>
<tr>
<?php include 'blocks/logmenu.php';?>
<td><h3><?php echo $row['selectpage']; ?></h3>
	<table>
	<?php 
	$query = $db->prepare("SHOW TABLES LIKE 'trans_%'");
	$query->execute();
	while ($row = $query->fetch())
	{echo "<p><a href='pedit.php?p=".$row[0]."'>".$row[0]."</a></p>";}
		?>
	</table>
</td>
</tr>
</table>
</body>
</html>