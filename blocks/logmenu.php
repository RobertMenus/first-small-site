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
<td width="200px" valign="top">
	<div>
		<a href = 'index.php'><?php echo $mas["main"]; ?></a><br>
	</div>	
	<?php 
	session_start();
	if (isset($_SESSION['works'])) {
		if (($_SESSION['class'] == 'admin') or ($_SESSION['class'] == 'editor')){
		echo "<a href = 'news_new.php'>".$mas['add_news']."</a><br>";}
		if ($_SESSION['class'] == 'admin') {
		echo "<a href = 'ped.php'>".$mas['pageeditor']."</a><br>";}
		echo "<p>".$mas['hello'].$_SESSION['works']."!</p>";
		$id_1 = $_SESSION['id'];
		echo "<p><a href = 'user_view.php?id=$id_1'>".$mas['viewprof']."</a><br>";
		echo "<a href = 'editme.php?id=$id_1'>".$mas['editprof']."</a><br>";
		unset($id_1);
		echo "<a href = 'blocks/logout.php'>".$mas['saybye']."</a></p>";
		if ($_SESSION['class'] == 'admin')
		{echo "<p><a href = 'userlist.php'>".$mas['userlist']."</a></p>";}
	} else {
		echo '<p>'.$mas["youhaveto"].'</p>';
		echo '<form method = "post" action = "blocks/auth.php">';
		echo '<table>';
		echo '<tr><td>'.$mas["loginemail"].':<br>';
		echo '<input type = "text" name = "login" maxlength = 64 size = 15></td></tr>';
		echo '<tr><td>'.$mas["pass"].':<br>';
		echo '<input type = "password" name = "pass" maxlength = 64 size = 15></td></tr>';
		echo '<tr><td align = "right">
		<input type = "submit" value = "'.$mas["enter"].'"></td></tr>';
		echo '</table></form>';
		echo "<p><a href='reg.php'>".$mas['isntregistered']."</a></p>";
	}
	?>
</td>