<?php 
include './blocks/db.php';
session_start();
if ($_SESSION['class']!=="admin")
{
	header('Location:index.php');
	exit();
}
if (isset($_SESSION['lang']))
     {$lang = $_SESSION['lang'];}
else
     {$lang = 'en';}
$result = $db->prepare('SELECT * FROM trans_userlist WHERE lang = :lang');
$result->bindParam(':lang',$lang);
$result->execute();
$row = $result->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
<head><meta content = "text/html" charset = "UTF-8">
<title><?php echo $row['userlist'];?></title></head>

<body background="img/bg.gif">

<table border="1px" width="100%" bgcolor=#cccccc>
<?php include './blocks/langbar.php'; ?>
<tr>
<?php 
	include './blocks/logmenu.php'; 
?>
<td valign = top>
	<h3><?php echo $row['userlist'];?></h3>
          <table border="1px">
          <tr><th width = '300'><?php echo $row['name'];?></th><th width = '100'></th><th width="100"></th></tr>
          <?php 
          $result = $db->query("SELECT id, login FROM users");
          while ($ne_row = $result->fetch(PDO::FETCH_ASSOC))
          {
          	echo "<tr><td><a href ='user_view.php?l=".$ne_row['login']."'>".$ne_row['login']."</td>";
          	echo "<td align = 'center'><a href = 'editme.php?id=".$ne_row['id']."'>".$row['edit']."</td>";
          	echo "<td align = 'center'><a href = 'userdelete.php?l=".$ne_row['login']."'>".$row['remove']."</a></td>";
          	echo "</tr>";
          }?>
          </table>
 <p>&nbsp</p>
</td></tr>
</table>
</body>
</html>