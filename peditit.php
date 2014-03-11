<?php
include './blocks/db.php';
session_start();
if (!isset($_SESSION['works']))
{
	header('Location: index.php');
	exit();
}
if ((!empty($_GET['p'])) and (!empty($_GET['l'])))
{$tablo = $_GET['p']; $tr_lang = $_GET['l'];}
else
{
	header('Location: '.$_SERVER['HTTP_REFERER']);
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
<title><?php echo $row['translation'];?></title></head>

<body background="img/bg.gif">
<table border="1px" width="100%" bgcolor=#cccccc>
<?php include './blocks/langbar.php'; ?>
<tr>
<?php include 'blocks/logmenu.php';?>
<td><h3><?php echo $row['translation']; ?></h3>
	<table>
	<?php
	$query = $db->prepare("SHOW COLUMNS FROM $tablo");
	$query->execute();
	$query2 = $db->prepare("SELECT * FROM $tablo WHERE lang=:lang");
	$query2->bindParam(':lang',$tr_lang);
	$query2->execute();
	$langs = $query2->fetch();
	$i=0;
	echo "<form method = 'post' action = 'pupd.php?t=$tablo'>";
	while ($myrow = $query->fetch())
		{
			echo "<tr><th align = 'left'>$tablo.$myrow[0]</th>";
			echo "<td><input type = 'text' name = 'val$i' id = '$i' 
			value ='$langs[$i]'></td></tr>";	
			$i++;
		}
		if ($i>0)
		{
			echo "<tr><td colspan = '2'><input type = 'hidden' name = 'tablo' id = 'tablo'
			value = '$tablo'></td></tr>";
			echo "<tr><td colspan = '2'><input type = 'hidden' name ='id_count' id ='id_count'
			value = '$i'></td></tr>";
			echo "<tr><td colspan = '2'><input type = 'hidden' name ='lang' id = 'lang'
			value = '$tr_lang'></td></tr>";
			echo "<tr><td colspan = '2' align = 'right'><input type = 'submit' name = 'submit' 
			id = 'submit' value = '".$row['updateme']."'></td></tr>";
		}
		else
		{
			echo "Current table is empty.";
		}
	?>
	</table>
</td>
</tr>
</table>
</body>
</html>