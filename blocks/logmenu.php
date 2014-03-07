<td width="200px" valign="top">
	<div>
		<a href = 'index.php'>Main</a><br>
	</div>	
	<?php 
	session_start();
	if (isset($_SESSION['works'])) {
		if (($_SESSION['class'] == 'admin') or ($_SESSION['class'] == 'editor')){
		echo "<a href = 'news_new.php'>Add news</a><br>";}
		echo "<p>Hello, ".$_SESSION['works']."!</p>";
		$id_1 = $_SESSION['id'];
		echo "<p><a href = 'user_view.php?id=$id_1'>View profile</a><br>";
		echo "<a href = 'editme.php?id=$id_1'>Edit profile</a><br>";
		unset($id_1);
		echo "<a href = 'blocks/logout.php'>Say bye!</a></p>";
		if ($_SESSION['class'] == 'admin')
		{echo "<p><a href = 'userlist.php'>User list</a></	p>";}
	} else {
		echo '<p>You have to log in</p>';
		echo '<form method = "post" action = "blocks/auth.php">';
		echo '<table>';
		echo '<tr><td>Login/Email:<br>';
		echo '<input type = "text" name = "login" maxlength = 64 size = 15></td></tr>';
		echo '<tr><td>Pass:<br>';
		echo '<input type = "password" name = "pass" maxlength = 64 size = 15></td></tr>';
		echo '<tr><td align = "right">
		<input type = "submit" value = "Enter"></td></tr>';
		echo '</table></form>';
		echo "<p><a href='reg.php'>Isn't registered?</a></p>";
	}
	?>
</td>