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
  if (($id != $_SESSION['id']) && $_SESSION['class']!='admin') {
    $id = $_SESSION['id'];
  }
	$result = $db->prepare("SELECT * FROM users WHERE id= :id");
  $result->bindParam(':id',$id);
  $result->execute();

	$ne_row = $result->fetch(PDO::FETCH_ASSOC);  
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
$result = $db->prepare('SELECT * FROM trans_prof_edit WHERE lang = :lang');
$result->bindParam(':lang',$lang);
$result->execute();
$row = $result->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head><meta content = "text/html" charset = "UTF-8">
<title><?php echo $ne_row['login'].":".$row['editing'];?></title>
<link rel="stylesheet" type="text/css" href="style.css"><link rel="icon" type="image/jpg" href="favicon.jpg" /></head>

<body  >

<table border="1px" width="100%" bgcolor=#cccccc>
<?php include './blocks/langbar.php'; ?>
<tr>
<?php 
	include './blocks/logmenu.php'; 
?>
<td valign = top>
<form name="upd_user" method="post" action="user_upd.php" enctype="multipart/form-data">
          <table>
          <tr><td align = center>
          <img src =
          <?php 
            if ($ne_row['ava'] != '') {
            echo $ne_row['ava']; }
            else
            {echo "'img/unknown.jpg'";}
            ?>
            />
          </td><td width="200">
          <input type = "hidden" name = "id" id="id" value=<?php echo $ne_row['id']; ?>>
          <input type="file" name="ava" id="ava">
            </td></tr>
          <tr><td><?php echo $row['login'];?></td><td>
          <?php echo $ne_row['login'];?>
          <input type = "hidden" name = "login" value="<?php echo $ne_row['login'];?>">
            </td></tr>
          <tr><td><?php echo $row['email'];?></td>
            <td><input type="text" name="mail" id="mail" value="<?php echo $ne_row['email'];?>">
            </td></tr>
          <tr><td><?php echo $row['surname'];?></td><td>
            <input type="text" name="surname" id="surname" value="<?php echo $ne_row['surname'];?>">
            </td></tr>
          <tr><td><?php echo $row['name'];?></td><td>
            <input type="text" name="name" id="name" value="<?php echo $ne_row['name'];?>">
            </td></tr>
          <?php 
            if ($_SESSION['class'] == 'admin'){
            echo "<tr><td>".$row['class']."</td><td>";
            echo "<select name = 'class'>";
            $classes = array('banned','user','editor','admin');
            for ($i=0; $i < 4; $i++) { 
              $str = "<option ";
              $str .= ($ne_row['class'] == $classes[$i]) ? "selected " : "";
              $str .= "value ='".$classes[$i]."'>".$classes[$i]."</option>";
              echo $str;
            }
            echo "</select>";
            echo "</td></tr>";}
            else
            {
              echo "<tr><td></td>
                    <td><input type = 'hidden' name = 'class' value =".$ne_row['class'].">
                    </td></tr>";
            }
            ?>
          <tr><td><?php echo $row['newpassword'];?></td><td>
            <input type="text" name="pass" id="pass" value="">
            </td></tr>
          <tr><td><?php echo $row['reenter'];?></td><td>
            <input type="text" name="pass2" id="pass2" value="">
            </td></tr>
          <tr><td><?php echo $row['enterold'];?><br>
              <i><?php echo $row['eo_tip'];?></i></td><td>
            <input type="password" name="oldpass" id="oldpass"></td></tr>
          <tr><td></td>
            <td align = "right">
            <input type="submit" name="submit" id="submit" value="<?php echo $row['update']?>">
            </td></tr>
          </table>
          <?php 
          //не введено старий пароль
          switch ($_GET['e']) {
            case 1: echo "<p><font color = 'red'>Old password wasn't entered!</font></p>";
                    break;
            case 2: echo "<p><font color = 'red'>Passwords do not match!</font></p>";
                    break;
            case 3: echo "<p><font color = 'red'>Current password is wrong!</font></p>";
                    break;
            }?>
        </form>
 <p>&nbsp</p>
</td>
</tr>

</table>

</body>

</html>