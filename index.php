<?php
include './blocks/db.php';
function get_pager($resulto,$val1,$val2,$lang)
{
	//$resulto - результат виконання запиту
	$table = "<table width = 100% align = center><tr><td><hr></td></tr>\n";
 	while ($getnews = $resulto->fetch(PDO::FETCH_ASSOC)) {
		$table .= "<tr>\n";
		$table .= "<td><h4><center><a href='news_view.php?id=".$getnews['id']."'>".$getnews['title']."</a></center></h4>\n";
		$table .= "<p align = 'right'>
		<a href='user_view.php?l=".$getnews['author']."'>
		<i>".$val1." ".$getnews['author']."</i></a></p>\n";
		$table .= "<p align = 'right'>".$getnews['date']."</p>\n";

	if (strlen($getnews['text_'.$lang])>150)
		{$text = substr($getnews['text_'.$lang], 0, strpos($getnews['text_'.$lang], " ", 150));
		$text = $text.'...';}
	else
		$text = $getnews['text_'.$lang];
		$table .= "<p>".$text."</p>\n";
		$table .= "<p align ='right'><a href = 'news_view.php?id=".$getnews['id'].
		"'>".$val2."</a></p>\n";
		$table .= "</td></tr>\n";
		$table .= "<tr><td><hr></td></tr>\n";
	}
	$table .= "</table>\n";
	echo $table;}

function pager_draw($count, $rpp, $p, $page)
{
	if ($count >$rpp)
	{
		echo'<center><table><tr>';
		for ($i=1; $i < ceil($count/$rpp)+1; $i++) { 
			if ($i == $p){
			echo "<td><b>$i</b></td>";}
			else
				{echo "<td><a href='$page?p=$i'>$i</a></td>";}
		}
		echo '</tr></table></center>';}}

session_start();
if (isset($_SESSION['lang']))
	{$lang = $_SESSION['lang'];}
else
	{$lang = 'en';}
$result = $db->prepare('SELECT * FROM trans_main WHERE lang = :lang');
$result->bindParam(':lang',$lang);
$result->execute();
$row = $result->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
<head><meta content = "text/html" charset = "UTF-8">
<title><?php echo $row['title'];?></title></head>
<body background="img/bg.gif">

<table border="1px" width="100%" bgcolor=#cccccc>
<?php include './blocks/langbar.php'; ?>
<tr>
<?php include './blocks/logmenu.php'; ?>
<td valign="top">
	<h1 halign = "center"><?php echo $row['news'].':';?></h1>
	<br>
	<?php

	$result = $db->query("SELECT COUNT(*) FROM news WHERE langs LIKE '%$lang%'");
	$error_array = $db->errorInfo();
 	
	if($db->errorCode() != 0000) echo "SQL error: " . $error_array[2] . '<br /><br />';
 	$tmp = $result->fetch();
 	$count = $tmp[0];
	$rpp = 5; //records per page

	if (isset($_GET['p'])) {
 	$p = $_GET['p'];
	if (($p == '') or (!is_numeric($p)) or ($p<1)){
		$p =1;}
	}
 	else {$p=1;}

 	if ($p > ceil($count/$rpp)) {
		$p = ceil($count/$rpp);
	}
	$showpage = ($p-1)*$rpp;

	if ($count > 0)
	{
	try
	{
		$result = $db->query("SELECT * FROM news WHERE langs LIKE '%$lang%' ORDER BY id DESC LIMIT $rpp OFFSET $showpage");
		$error_array = $db->errorInfo();
 
		if($db->errorCode() != 0000) echo "SQL error: " . $error_array[2] . '<br /><br />';
		get_pager($result,$row['byuser'],$row['readmore'],$lang);
	}
	catch (PDO_exception $e)
	{die ("Error:".$e->getMessage());}
	pager_draw($count, $rpp, $p, 'index.php');
	}
	else
		{
			echo $row['nonews'];
		}?>
</td>
</tr>
</table></body></html>