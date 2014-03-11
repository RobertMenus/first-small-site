<?php 
include './blocks/db.php';
$query = $db->prepare("SHOW TABLES LIKE 'trans_%'");
$query->execute();
while ($row = $query->fetch())
{echo $row[0]."<br/>";}
?>