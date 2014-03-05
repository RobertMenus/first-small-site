<?php
include './blocks/db.php';
session_start();
if (!isset($_SESSION['works']))
{
	header('Location: index.php');
	exit();
}
if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$result = $db->prepare("SELECT * FROM news WHERE id= :id");
  $result->bindParam(':id',$id);
  $result->execute();

	$ne_row = $result->fetch(PDO::FETCH_ASSOC);
  //cid = change id:)
  $_SESSION['cid'] = $id;
}
else
{
	header('Location: index.php');
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
<form name="upd_form" method="post" action="news_upd.php">
 <p>
            <label>Title<br>
            <input type="text" name="title" id="title" value = "<?php echo $ne_row['title']; ?>"	></label>
          </p>
          <p>    
            <label>Date<br>
            <input type="text" name="date" id="date" value="<?php echo $ne_row['date'];?>">
            </label>
          </p>
          <p>
            <label>Text<br>
            <textarea name="text" id="text" cols="60" rows="20"><?php echo $ne_row['text']; ?></textarea>
            </label>
          </p>
          <p>
            <label>Author<br>
            <input type="text" name="author" id="author" value="<?php echo $ne_row['author']; ?>">
            </label>
          </p>
          <p>
            <label>
            <input type="submit" name="submit" id="submit" value="Update it">
            </label>
          </p>
        </form>
 <p>&nbsp</p>
</td>
</tr>

</table>

</body>

</html>