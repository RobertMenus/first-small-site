<?php
 session_start();
include './blocks/db.php';
if (isset($_GET['id'])) {$id = $_GET['id'];}
if (($id == '') or (!is_numeric($id)) or ($id<1)){
		unset($id);
		header('Location: index.php');}

if (isset($_SESSION['lang']))
	{$lang = $_SESSION['lang'];}
else
	{$lang = 'en';}
$result = $db->prepare('SELECT * FROM trans_news_view WHERE lang = :lang');
$result->bindParam(':lang',$lang);
$result->execute();
$row = $result->fetch(PDO::FETCH_ASSOC);

$result = $db->prepare("SELECT * FROM news WHERE id= :id");
$result->bindParam(':id',$id,PDO::PARAM_INT);
$result->execute();
$my_row = $result->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
<head><meta content = "text/html" charset = "UTF-8">
<title><?php echo $my_row['title']; ?></title></head>

<body background="img/bg.gif">

<table border="1px" width="100%" bgcolor=#cccccc>
<?php include './blocks/langbar.php'; ?>
<tr>
<?php 
	include './blocks/logmenu.php'; 
?>
<td valign = top>
 <p align = 'right'>
 <?php
 if ($_SESSION['works']){
 echo "<a href = 'news_edit.php?id=$id'>".$row['edit me']."</a>&nbsp &nbsp
 <a href = 'news_delete.php?id=$id'>".$row['delete me']."</a></p>";}
 ?>
 <h1 align = 'center'><?php echo $my_row['title']; ?></h1>
 <p align = 'right'><i>
 	<?php 
 	echo "<a href='user_view.php?l=".$my_row['author']."'>".$my_row['author']."</a>"; 
 	?></i><br>
 	<?php echo $my_row['date']; ?></p>
 <p><?php echo $my_row['text_'.$lang]; ?></p>
 <p>&nbsp</p>
 <form method = 'post' action = 'addcom.php'>
 <center>
 <table width="400" border = '1'>
 		<tr><td><?php echo $row['theme'];?>:</td> 
            <td><input type="text" name="theme" id="theme"></td></tr>
        <tr><td><?php echo $row['date'];?>:</td>
            <td>[<?php echo date('Y-m-d')?>]</td></tr>
        <tr><td><?php echo $row['text'];?></td>
            <td><textarea name="text" id="text" cols="31"></textarea>
            <input type="hidden" value = "<?php echo $id; ?>" name= 'postnumb' id= 'postnumb'>
            </td></tr>
        <tr><td><?php echo $row['author'];?>:</td>
            <td><i><?php echo $_SESSION['works']?></i></td></tr>
        <tr><td colspan = '2' align="right">
            <input type="submit" name="submit" id="submit" value="<?php echo $row['addit'];?>">
        </td></tr>
 </form>
 <?php 
 
 ?>
</td></tr>
</table></center>

</body>

</html>