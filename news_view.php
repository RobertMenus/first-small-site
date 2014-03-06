<?php
include './blocks/db.php';
if (isset($_GET['id'])) {$id = $_GET['id'];}
if (($id == '') or (!is_numeric($id)) or ($id<1)){
		unset($id);
		header('Location: index.php');}
$result = $db->prepare("SELECT * FROM news WHERE id= :id");
$result->bindParam(':id',$id,PDO::PARAM_INT);
$result->execute();

$my_row = $result->fetch(PDO::FETCH_ASSOC);
$db = null;
?>
<!DOCTYPE html>
<html>
<head><meta content = "text/html" charset = "UTF-8">
<title><?php echo $my_row['title']; ?></title></head>

<body background="img/bg.gif">

<table border="1px" width="100%" bgcolor=#cccccc>
<tr>
<?php 
	include './blocks/logmenu.php'; 
?>
<td valign = top>
 <p align = 'right'>
 <?php
 session_start();
 if ($_SESSION['works']){
 echo "<a href = 'news_edit.php?id=$id'>Edit me</a>&nbsp &nbsp
 <a href = 'news_delete.php?id=$id'>Delete me</a></p>";}
 ?>
 <h1 align = 'center'><?php echo $my_row['title']; ?></h1>
 <p align = 'right'><i>
 	<?php 
 	echo "<a href='user_view.php?l=".$my_row['author']."'>".$my_row['author']."</a>"; 
 	?></i><br>
 	<?php echo $my_row['date']; ?></p>
 <p><?php echo $my_row['text']; ?></p>
 <p>&nbsp</p>
</td>
</tr>

</table>

</body>

</html>