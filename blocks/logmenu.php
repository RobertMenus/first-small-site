<?php 
if (isset($_SESSION['lang']))
	{$lang = $_SESSION['lang'];}
else
	{$lang = 'en';}
$result = $db->prepare('SELECT * FROM trans_menu WHERE lang = :lang');
$result->bindParam(':lang',$lang);
$result->execute();
$mas = $result->fetch(PDO::FETCH_ASSOC);
?>
<link rel="stylesheet" type="text/css" href="style.css">
<td width="200px" valign="top">
	<center><img src="./img/vault.jpg"></center>
	<div id='menu'>
		<p><a href = 'index.php'><?php echo $mas["main"]; ?></a></p>
	</div>	
	<?php 
	session_start();
	if (isset($_SESSION['works'])) {
		echo "<div id='menu'>";
		if (($_SESSION['class'] == 'admin') or ($_SESSION['class'] == 'editor')){
		echo "<p><a href = 'news_new.php'>".$mas['add_news']."</a></p>";}
		if ($_SESSION['class'] == 'admin') {
		echo "<p><a href = 'ped.php'>".$mas['pageeditor']."</a></p>";}
		echo "<p id = 'hello'>".$mas['hello'].$_SESSION['works']."!</p>";
		$id_1 = $_SESSION['id'];
		echo "<p><a href = 'user_view.php?id=$id_1'>".$mas['viewprof']."</a></p>";
		echo "<p><a href = 'editme.php?id=$id_1'>".$mas['editprof']."</a></p>";
		unset($id_1);
		echo "<p><a href = 'blocks/logout.php'>".$mas['saybye']."</a></p>";
		if ($_SESSION['class'] == 'admin')
		{echo "<p><a href = 'userlist.php'>".$mas['userlist']."</a></p>";}
		echo "</div>";
	} else {
		echo "<div id='menu'";
		echo '<p>'.$mas["youhaveto"].'</p>';
		echo '<form method = "post" action = "blocks/auth.php">';
		echo '<table id="menu">';
		echo '<tr><td>'.$mas["loginemail"].':<br>';
		echo '<input type = "text" name = "login" maxlength = 64 size = 15></td></tr>';
		echo '<tr><td>'.$mas["pass"].':<br>';
		echo '<input type = "password" name = "pass" maxlength = 64 size = 15></td></tr>';
		echo '<tr><td align = "right">
		<input type = "submit" value = "'.$mas["enter"].'"></td></tr>';
		echo '</table></form>';
		echo "<p><a href='reg.php'>".$mas['isntregistered']."</a></p>";
		echo "</div>";
	}
	?>
</td>