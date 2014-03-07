<?php 
include './blocks/db.php';
session_start();
?>
<!DOCTYPE html>
<html>
<head><meta content = "text/html" charset = "UTF-8">
<title>Profile</title></head>

<body background="img/bg.gif">

<table border="1px" width="100%" bgcolor=#cccccc>
<tr>
<?php 
	include './blocks/logmenu.php'; 
?>
<td valign = top>
	<h3>Profile</h3>
	<?php 
	$result = $db->prepare("SELECT * FROM users WHERE 
		(id=:id or login = :l)");
	$result->bindParam(':id',$_GET['id']);
	$result->bindParam(':l',$_GET['l']);
	$result->execute();
	$ne_row = $result->fetch(PDO::FETCH_ASSOC);
  if ($ne_row['login'] == '')
  {
    echo "<p>This user doesn't exist.</p>";
  }
  else
	{
    echo "<table><tr><td width = '150'></td><td align = 'right' width='300'>";
    if ($_SESSION['works'] != ''){
        echo "<a href = 'userdelete.php?l=".$ne_row['login']."'>Remove </a><br>
              <a href = 'editme.php?id=".$ne_row['id']."'>Edit</a>";
      }
    echo "</td></tr></table>";
    echo "<img src =";
    if ($ne_row['ava'] != '') {echo "'".$ne_row['ava']."'";}
            else {echo "'img/unknown.jpg'";}
    echo "/>
          <table>
          <tr><td width = '150'>Login</td><td>".$ne_row['login']."</td></tr>
          <tr><td width = '150'>E-mail</td><td>";

    if (isset($_SESSION['works']))
          {
          	echo $ne_row['email'];
          }
        else{
          	echo "<i>Only for registered users</i>";}
    echo "</td></tr>
          <tr><td width = '150'>Class</td><td>".$ne_row['class']."</td></tr>
          <tr><td width = '150'>Surname</td><td>".$ne_row['surname']."</td></tr>
          <tr><td width = '150'>Name</td><td>".$ne_row['name']."</td></tr>
          <tr><td width = '150'>Date of registration</td><td>".$ne_row['registr']."</td></tr>
          <tr><td width = '150'>Date of last visit</td><td>".$ne_row['lastlog']."</td></tr>
          </table><p>&nbsp</p></td></tr></table>";
}?>
</body>
</html>