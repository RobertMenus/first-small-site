<?php 
include './blocks/db.php';
session_start();
if (isset($_SESSION['lang']))
  {$lang = $_SESSION['lang'];}
else
  {$lang = 'en';}
$result = $db->prepare('SELECT * FROM trans_prof_view WHERE lang = :lang');
$result->bindParam(':lang',$lang);
$result->execute();
$row = $result->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head><meta content = "text/html" charset = "UTF-8">
<title><?php echo $row['profile'];?></title></head>

<body background="img/bg.gif">

<table border="1px" width="100%" bgcolor=#cccccc>
<?php include './blocks/langbar.php'; ?>
<tr>
<?php 
	include './blocks/logmenu.php'; 
?>
<td valign = top>
	<h3><?php echo $row['profile'];?></h3>
	<?php 
	$result = $db->prepare("SELECT * FROM users WHERE 
		(id=:id or login = :l)");
	$result->bindParam(':id',$_GET['id']);
	$result->bindParam(':l',$_GET['l']);
	$result->execute();
	$ne_row = $result->fetch(PDO::FETCH_ASSOC);
  if ($ne_row['login'] == '')
  {
    echo "<p>".$row['error']."</p>";
  }
  else
	{
    echo "<table><tr><td width = '150'></td><td align = 'right' width='300'>";
    if ($_SESSION['works'] != ''){
        echo "<a href = 'userdelete.php?l=".$ne_row['login']."'>".$row['remove']." </a><br>
              <a href = 'editme.php?id=".$ne_row['id']."'>".$row['edit']."</a>";
      }
    echo "</td></tr></table>";
    echo "<img src =";
    if ($ne_row['ava'] != '') {echo "'".$ne_row['ava']."'";}
            else {echo "'img/unknown.jpg'";}
    echo "/>
          <table>
          <tr><td width = '200'>".$row['login']."</td><td>".$ne_row['login']."</td></tr>
          <tr><td>".$row['email']."</td><td>";

    if (isset($_SESSION['works']))
          {
          	echo $ne_row['email'];
          }
        else{
          	echo "<i>".$row['onlyreg']."</i>";}
    echo "</td></tr>
          <tr><td width = '150'>".$row['class']."</td><td>".$ne_row['class']."</td></tr>
          <tr><td width = '150'>".$row['surname']."</td><td>".$ne_row['surname']."</td></tr>
          <tr><td width = '150'>".$row['name']."</td><td>".$ne_row['name']."</td></tr>
          <tr><td width = '150'>".$row['date_of_registration']."</td><td>".$ne_row['registr']."</td></tr>
          <tr><td width = '150'>".$row['date_of_last_visit']."</td><td>".$ne_row['lastlog']."</td></tr>
          </table><p>&nbsp</p></td></tr></table>";
}?>
</body>
</html>