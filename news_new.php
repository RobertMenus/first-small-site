<?php
session_start();
if (!isset($_SESSION['works']))
{
	header("location: index.php");
	exit();
}
?>

<!DOCTYPE html>
<html>
<head><meta content = "text/html" charset = "UTF-8">
<title>Add news</title></head>

<body background="img/bg.gif">

<table border="1px" width="100%" bgcolor=#cccccc>
<tr>
<?php 
	include ("blocks/logmenu.php"); 
?>
<td>
 <table width="100%" bgcolor="#FFFFFF">
      <tr>
		<? include ("blocks/menu.php") ?>           
        <td valign="top">
        <form name="form1" method="post" action="news_add.php">
          <p>
            <label>Title<br>
            <input type="text" name="title" id="title"></label>
          </p>
          <p>    
            <label>Date<br>
            <input type="text" name="date" id="date" value=<?php echo date('Y-m-d')?>>
            </label>
          </p>
          <p>
            <label>Text<br>
            <textarea name="text" id="text" cols="40" rows="20"></textarea>
            </label>
          </p>
          <p>
            <label>Author<br>
            <input type="text" name="author" id="author" value=<?php echo $_SESSION['works']?>>
            </label>
          </p>
          <p>
            <label>
            <input type="submit" name="submit" id="submit" value="Add it">
            </label>
          </p>
        </form></td></tr>
    </table>
</td></tr>

</table>
</body>
</html>