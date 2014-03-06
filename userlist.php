<?php 
include './blocks/db.php';
session_start();
if ($_SESSION['class']!=="admin")
{
	header('Location:index.php');
	exit();
}
?>
<!DOCTYPE html>
<html>
<head><meta content = "text/html" charset = "UTF-8">
<title>Editing</title></head>

<body background="img/bg.gif">

<table border="1px" width="100%" bgcolor=#cccccc>
<tr>
<?php 
	include './blocks/logmenu.php'; 
?>
<td valign = top>
	<h3>Profile</h3>
          <table border="1px">
          <tr><th width = '300'>Name</th><th width = '100'></th><th width="100"></th></tr>
          <?php 
          $result = $db->query("SELECT login FROM users");
          while ($ne_row = $result->fetch(PDO::FETCH_ASSOC))
          {
          	echo "<tr><td>".$ne_row['login']."</td>";
          	echo "<td align = 'center'>Edit</td>";
          	echo "<td align = 'center'><a href = 'userdelete.php?l=".$ne_row['login']."'>Remove</a></td>";
          	echo "</tr>";
          }?>
          </table>
 <p>&nbsp</p>
</td></tr>
</table>
</body>
</html>