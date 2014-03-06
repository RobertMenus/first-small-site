<?php
include './blocks/db.php';

function get_pager($resulto)
{
	//$resulto - результат виконання запиту

	$table = "<table width = 100% align = center><tr><td><hr></td></tr>\n";
 	while ($getnews = $resulto->fetch(PDO::FETCH_ASSOC)) {
		$table .= "<tr>\n";
		$table .= "<td><h4><center><a href='news_view.php?id=".$getnews['id']."'>".$getnews['title']."</a></center></h4>\n";
		$table .= "<p align = 'right'>
		<a href='user_view.php?l=".$getnews['author']."'>
		<i>by ".$getnews['author']."</i></a></p>\n";
		$table .= "<p align = 'right'>".$getnews['date']."</p>\n";

	if (strlen($getnews['text'])>150)
		{$text = substr($getnews['text'], 0, strpos($getnews['text'], " ", 150));
		$text = $text.'...';}
	else
		$text = $getnews['text'];
		$table .= "<p>".$text."</p>\n";
		$table .= "<p align ='right'><a href = 'news_view.php?id=".$getnews['id']."'>read more</a></p>\n";
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
		echo '</tr></table></center>';}}?>
<!DOCTYPE html>
<html>
<head><meta content = "text/html" charset = "UTF-8">
<title>Main page</title></head>
<body background="img/bg.gif">

<table border="1px" width="100%" bgcolor=#cccccc>
<tr>
<?php include './blocks/logmenu.php'; ?>
<td valign="top">
	<h1 halign = "center">News:</h1>
	<br>
	<?php
	/*$result = mysql_query ("SELECT * FROM news") or die(mysql_error());
	$count = mysql_num_rows($result);*/
////////////////////////////////////////
	$result = $db->query("SELECT COUNT(*) FROM news");
	$error_array = $db->errorInfo();
 
	if($db->errorCode() != 0000) echo "SQL error: " . $error_array[2] . '<br /><br />';
 	$tmp = $result->fetch();
 	$count = $tmp[0];
////////////////////////////////////////
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
	try
	{
		$result = $db->query("SELECT * FROM news LIMIT $rpp OFFSET $showpage");
		$error_array = $db->errorInfo();
 
		if($db->errorCode() != 0000) echo "SQL error: " . $error_array[2] . '<br /><br />';

//описати функцію типу get_pager(array(),5);
		get_pager($result);
//-------------------------------------------------------\/
	/*$table = "<table width = 100% align = center><tr><td><hr></td></tr>\n";
	while ($getnews = $result->fetch(PDO::FETCH_ASSOC)) {
		$table .= "<tr>\n";
		$table .= "<td><h4><center><a href='news_view.php?id=".$getnews['id']."'>".$getnews['title']."</a></center></h4>\n";
		$table .= "<p align = 'right'><i>by ".$getnews['author']."</i></p>\n";
		$table .= "<p align = 'right'>".$getnews['date']."</p>\n";

	if (strlen($getnews['text'])>150)
		{$text = substr($getnews['text'], 0, strpos($getnews['text'], " ", 150));
		$text .= '...';}
	else
		$text = $getnews['text'];

		$table .= "<p>".$getnews['text']."</p>\n";
		$table .= "<p align ='right'><a href = 'news_view.php?id=".$getnews['id']."'>read more</a></p>\n";	
		$table .= "</td></tr>\n";
		$table .= "<tr><td><hr></td></tr>\n";
	}
		$table .= "</table>\n";
		echo $table;*/
//------------------------------------------------------------------/\
	}
	catch (PDO_exception $e)
	{die ("Error:".$e->getMessage());}
	$db = null;
	pager_draw($count, $rpp, $p, 'index.php');?>
</td>
</tr>
</table></body></html>