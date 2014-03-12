<?php
include './blocks/db.php';
session_start();
if (!isset($_SESSION['works']))
{
	header("location: index.php");
	exit();
}
if (isset($_SESSION['lang']))
  {$lang = $_SESSION['lang'];}
else
  {$lang = 'en';}
$result = $db->prepare('SELECT * FROM trans_news_new WHERE lang = :lang');
$result->bindParam(':lang',$lang);
$result->execute();
$row = $result->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head><meta content = "text/html" charset = "UTF-8">
<title><?php echo $row['addnews']; ?></title>
<link rel="stylesheet" type="text/css" href="style.css"><link rel="icon" type="image/jpg" href="favicon.jpg" /></head>

<body  >
<table border="1px" width="100%" bgcolor=#cccccc>
<?php include './blocks/langbar.php'; ?>
<tr>
<?php 
	include "./blocks/logmenu.php"; 
?>
<td>
 <table width="100%" bgcolor="#FFFFFF">
      <tr>
		<? include './blocks/menu.php'; ?>           
        <td valign="top">
        <form name="form1" method="post" action="news_add.php">
          <p>
            <label><?php echo $row['title'];?><br>
            <input type="text" name="title" id="title"></label>
          </p>
          <p>    
            <label><?php echo $row['date'];?><br>
            <input type="text" name="date" id="date" value=<?php echo date('Y-m-d')?>>
            </label>
          </p>
          <p>
            <label><?php echo $row['text_en'];?><br>
            <textarea name="text_en" id="text_en" cols="40" rows="20"></textarea>
            </label>
          </p>
          <p>
            <label><?php echo $row['text_ua'];?><br>
            <textarea name="text_ua" id="text_ua" cols="40" rows="20"></textarea>
            </label>
          </p>
          <p>
            <label><?php $row['author'];?><br>
            <input type="text" name="author" id="author" value=<?php echo $_SESSION['works']?>>
            </label>
          </p>
          <p>
            <label>
            <input type="submit" name="submit" id="submit" value="<?php echo $row['addit'];?>">
            </label>
          </p>
        </form></td></tr>
    </table>
</td></tr>

</table>
</body>
</html>