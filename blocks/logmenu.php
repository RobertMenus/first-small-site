<td width="200px" valign="top">
	<div>
		<a href = 'index.php'>Main</a><br>
	</div>	
	<?php 
	session_start();
	if (isset($_SESSION['works'])) {
		
		echo "<a href = 'news_new.php'>Add news</a><br>";
		
		echo "<p>Hello, ".$_SESSION['works']."!</p>";
		echo "<p><a href = 'blocks/logout.php'>Say bye!</a></p>";
		
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
	}
	?>
</td>