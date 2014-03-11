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
if (isset($_SESSION['lang']))
  {$lang = $_SESSION['lang'];}
else
  {$lang = 'en';}
$result = $db->prepare("SELECT 
    trans_prof_edit.editing,
    trans_news_new.title,
    trans_news_new.date,
    trans_news_new.text_en,
    trans_news_new.text_ua,
    trans_news_new.author,
    trans_prof_edit.update
  FROM trans_news_new,trans_prof_edit WHERE trans_news_new.lang = :lang and trans_prof_edit.lang = :lang");
$result->bindParam(':lang',$lang);
$result->execute();
$row = $result->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head><meta content = "text/html" charset = "UTF-8">
<title><?php echo $row['editing'];?></title></head>

<body background="img/bg.gif">
<table border="1px" width="100%" bgcolor=#cccccc>
<?php include './blocks/langbar.php'; ?>
<tr>
<?php 
	include './blocks/logmenu.php'; 
?>
<td valign = top>
<form name="upd_form" method="post" action="news_upd.php">
 <p>
            <label><?php echo $row['title'];?><br>
            <input type="text" name="title" id="title" value = "<?php echo $ne_row['title']; ?>"	></label>
          </p>
          <p>    
            <label><?php echo $row['date'];?><br>
            <input type="text" name="date" id="date" value="<?php echo $ne_row['date'];?>">
            </label>
          </p>
          <p>
            <label><?php echo $row['text_en'];?><br>
            <textarea name="text_en" id="text_en" cols="60" rows="20"><?php echo $ne_row['text_en']; ?></textarea>
            </label>
          </p>
          <p>
            <label><?php echo $row['text_ua'];?><br>
            <textarea name="text_ua" id="text_ua" cols="60" rows="20"><?php echo $ne_row['text_ua']; ?></textarea>
            </label>
          </p>
          <p>
            <label><?php echo $row['author'];?><br>
            <input type="text" name="author" id="author" value="<?php echo $ne_row['author']; ?>">
            </label>
          </p>
          <p>
            <label>
            <input type="submit" name="submit" id="submit" value="<?php echo $row['update'];?>">
            </label>
          </p>
        </form>
 <p>&nbsp</p>
</td>
</tr>

</table>

</body>

</html>