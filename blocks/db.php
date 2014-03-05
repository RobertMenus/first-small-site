<?php
try
{
	$db = new PDO('mysql:host=localhost;dbname=site1','root','root');
}
catch (PDO_exception $e)
{die ("Error:".$e->getMessage());}
/*$db = mysql_connect("localhost","root","root") or die(mysql_error());
mysql_select_db("site1");*/
?>