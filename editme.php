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
?>
<!DOCTYPE html>
<html>
<head><meta content = "text/html" charset = "UTF-8">
<title><?php echo $ne_row['login'];?>:Editing</title></head>

<body background="img/bg.gif">

<table border="1px" width="100%" bgcolor=#cccccc>
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
          </td><td>
          <input type = "hidden" name = "id" id="id" value=<?php echo $ne_row['id']; ?>>
          <input type="file" name="ava" id="ava">
            </td></tr>
          <tr><td>Login</td><td>
          <input type="text" name="login" id="login" value = "<?php echo $ne_row['login'];?>">
            </td></tr>
          <tr><td>E-mail</td>
            <td><input type="text" name="mail" id="mail" value="<?php echo $ne_row['email'];?>">
            </td></tr>
          <tr><td>Surname</td><td>
            <input type="text" name="surname" id="surname" value="<?php echo $ne_row['surname'];?>">
            </td></tr>
          <tr><td>Name</td><td>
            <input type="text" name="name" id="name" value="<?php echo $ne_row['name'];?>">
            </td></tr>
          <?php 
            if ($_SESSION['class'] == 'admin'){
            echo "<tr><td>Class</td><td>";
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
          <tr><td>New password</td><td>
            <input type="text" name="pass" id="pass" value="">
            </td></tr>
          <tr><td>Reenter new password</td><td>
            <input type="text" name="pass2" id="pass2" value="">
            </td></tr>
          <tr><td>Enter your old password<br>
              <i>(type it if you wanna <br>change smth)</i></td><td>
            <input type="password" name="oldpass" id="oldpass"></td></tr>
          <tr><td></td>
            <td align = "right">
            <input type="submit" name="submit" id="submit" value="Update profile">
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