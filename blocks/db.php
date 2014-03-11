<?php
try
{
	$db = new PDO('mysql:host=localhost;dbname=site1;charset=utf8','root','root');
}
catch (PDO_exception $e)
{die ("Error:".$e->getMessage());}
?>