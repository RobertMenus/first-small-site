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
	$result = $db->prepare("SELECT login, email, surname, name FROM users WHERE 
		(id=:id or login = :l)");
	$result->bindParam(':id',$_GET['id']);
	$result->bindParam(':l',$_GET['l']);
	$result->execute();
	$ne_row = $result->fetch(PDO::FETCH_ASSOC);
	?>
          <table>
          <tr><td width = '150'>Login</td><td><?php echo $ne_row['login'];?></td></tr>
          <tr><td width = '150'>E-mail</td><td><?php 
          		    if (isset($_SESSION['works']))
          		    	{
          		    		echo $ne_row['email'];
          		    	}
          		    	else{
          		    		echo "<i>Only for registered users</i>";}
          		    ?></td></tr>
          <tr><td width = '150'>Surname</td><td><?php echo $ne_row['surname'];?></td></tr>
          <tr><td width = '150'>Name</td><td><?php echo $ne_row['name'];?></td></tr>
          </table>
 <p>&nbsp</p>
</td></tr>
</table>
</body>
</html>