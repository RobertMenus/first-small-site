<?php
 session_start();
include './blocks/db.php';
if (isset($_GET['id'])) {$id = $_GET['id'];}
if (($id == '') or (!is_numeric($id)) or ($id<1)){
		unset($id);
		header('Location: index.php');}

if (isset($_SESSION['lang']))
	{$lang = $_SESSION['lang'];}
else
	{$lang = 'en';}
$result = $db->prepare('SELECT * FROM trans_news_view WHERE lang = :lang');
$result->bindParam(':lang',$lang);
$result->execute();
$row = $result->fetch(PDO::FETCH_ASSOC);

$result = $db->prepare("SELECT * FROM news WHERE id= :id");
$result->bindParam(':id',$id,PDO::PARAM_INT);
$result->execute();
$my_row = $result->fetch(PDO::FETCH_ASSOC);?>
<!DOCTYPE html>
<html>
<head><meta content = "text/html" charset = "UTF-8">
<title><?php echo $my_row['title']; ?></title>
<link rel="stylesheet" type="text/css" href="style.css"><link rel="icon" type="image/jpg" href="favicon.jpg" /></head>

<body  >

<table border="1px" width="100%" bgcolor=#cccccc>
<?php include './blocks/langbar.php'; ?>
<tr>
<?php 
	include './blocks/logmenu.php'; 
?>
<td valign = top>
 <p align = 'right'>
 <?php
 if ($_SESSION['works']){
 echo "<a href = 'news_edit.php?id=$id'>".$row['edit me']."</a>&nbsp &nbsp
 <a href = 'news_delete.php?id=$id'>".$row['delete me']."</a></p>";}
 ?>
 <h1 align = 'center'><?php echo $my_row['title']; ?></h1>
 <?php
  $query = $db->prepare('SELECT COUNT(mark),AVG(mark) FROM marks WHERE id=:id');
  $query->bindParam(':id',$id);
  $query->execute();
  $tmp = $query->fetch();
  $mark = $tmp[1];
  $count = $tmp[0];
  echo "<p align = 'center'>";
  if ($count == 0)
  {echo "<i>".$row['nomarks']."</i>";}
  else
    {   for ($i=0; $i < $mark; $i++) {
        echo "<img src = './img/mark.jpg' title = '".$row['average'].$mark.$row['voted'].$count."'.>";}
    }
    echo "</p>";
 if (isset($_SESSION['works']))
 {
  $query = $db->prepare('SELECT COUNT(*) FROM marks WHERE id=:id and login=:login');
  $query->bindParam(':id',$id);
  $query->bindParam(':login',$_SESSION['works']);
  $query->execute();
  $tmp = $query->fetch();
  $count = $tmp[0];
  if (!empty($count)) 
    {if (is_numeric($count)) 
  {
    $query = $db->prepare('SELECT mark FROM marks WHERE id = :id AND login = :login');
    $query->bindParam(':id',$id);
    $query->bindParam(':login',$_SESSION['works']);
    $query->execute();
    $tmp = $query->fetch();
    $mymark = $tmp[0];
        echo "<center><form method='post' action='delvote.php'>
              <i>".$row['votedmark']." ".$mymark."</i>
              <input type = 'submit' name = 'submit' id='submit' value='".$row['delete it']."'>";
              echo "<input type = 'hidden' name = 'comm' value='$id'></form></center>";
    if ($_GET['mes']==1) {echo '<p align ="center">'.$row['thanx'].'</p>';}
        if ($_SESSION['class']=='admin'){
                echo "<center><form method = 'post' action = 'delall.php'>";
                echo "<input type = 'hidden' name = 'comm' value = '$id'>";
                echo "<input type = 'submit' name = 'submit' value='".$row['deleteall']."'>";
                echo "</form></center>";
            }
    }
  }
  else
  {
    echo "<form method = 'post' action = 'vote.php'";
    echo "<center>";
    echo "<table width = '450px' border='1px' align='center'>";
    echo "<tr><td><input type='radio' name='mark' value='1'>1
                  <input type='radio' name='mark' value='2'>2
                  <input type='radio' name='mark' value='3'>3
                  <input type='radio' name='mark' value='4'>4
                  <input type='radio' name='mark' value='5'>5
                  <input type='radio' name='mark' value='6'>6
                  <input type='radio' name='mark' value='7'>7
                  <input type='radio' name='mark' value='8'>8
                  <input type='radio' name='mark' value='9'>9 ";
    echo "<input type= 'submit' name= 'submit' id='submit' value ='".$row['vote']."'>";
    echo "<input type= 'hidden' name='comm' value ='$id'";
    echo "</td></tr>";
    echo "</table></center></form>";
  }
}
 ?>
 <p align = 'right'><i>
 	<?php 
 	echo "<a href='user_view.php?l=".$my_row['author']."'>".$my_row['author']."</a>"; 
 	?></i><br>
 	<?php echo $my_row['date']; ?></p>
 <p><?php echo $my_row['text_'.$lang]; ?></p>
 <p>&nbsp</p>
 <?php 
 if (isset($_SESSION['works']))
    {
    echo "<form method = 'post' action = 'addcom.php'>";
    echo "<center>";
    echo "<table width='400px' border = '1'>";
 	echo "<tr><td>".$row['theme'].":</td>";
    echo "<td><input type='text' name='theme' id='theme'></td></tr>";
    echo "<tr><td>".$row['date'].":</td>";
    echo "<td>[".date('Y-m-d')."]</td></tr>";
    echo "<tr><td>".$row['text']."</td>";
    echo "<td><textarea name='text' id='text' cols='31'></textarea>";
    echo "<input type='hidden' value = '$id' name= 'postnumb' id= 'postnumb'>";
    echo "</td></tr>";
    echo "<tr><td>".$row['author'].":</td>";
    echo "<td><i>".$_SESSION['works']."</i></td></tr>";
    echo "<tr><td colspan = '2' align='right'>";
    echo "<input type='submit' name='submit' id='submit' value='".$row['addit']."'>";
    echo "</td></tr>";
    echo "</form>";
    }
 ?>
 <?php 
    $result = $db->prepare("SELECT COUNT(*) FROM comments WHERE (postnumb=:id AND langs LIKE '%$lang%')");
    $result->bindParam(':id',$id);
    $result->execute();
    $error_array = $db->errorInfo();
    
    if($db->errorCode() != 0000) echo "SQL error: " . $error_array[2] . '<br /><br />';
    $tmp = $result->fetch();
    $count = $tmp[0];
    $cpp = 5; //comments per page

    if (isset($_GET['p'])) {
    $p = $_GET['p'];
    if (($p == '') or (!is_numeric($p)) or ($p<1))
        {$p =1;}}
    else {$p=1;}
    if ($p > ceil($count/$cpp)) {$p = ceil($count/$cpp);}
    $showpage = ($p-1)*$cpp;
    if ($count > 0){
    try
    {
        $result = $db->prepare("SELECT * FROM comments WHERE postnumb =:id AND langs LIKE '%$lang%' ORDER BY date DESC LIMIT $cpp OFFSET $showpage");
        $result->bindParam(':id',$id);
        $result->execute();
        $error_array = $db->errorInfo();
        if($db->errorCode() != 0000) echo "SQL error: " . $error_array[2] . '<br /><br />';
        
        $table = "<table width = '100%' align = 'center'><tr><td><hr></td></tr>\n";
        while ($getcoms = $result->fetch(PDO::FETCH_ASSOC)) 
        {
        $table .= "<tr>\n";
        $table .= "<td><h4>".$getcoms['theme']."</h4>\n";
        if (strlen($getcoms['text'])>150)
        {$text = substr($getcoms['text'], 0, strpos($getcoms['text'], " ", 150));
        $text .= '...';}
        else
        $text = $getcoms['text'];
        $table .= "<p>".$text."</p>\n";
        $table .= "<p align = 'right'>
        <a href='user_view.php?l=".$getcoms['login']."'>
        <i>".$getcoms['login']."</i></a> [".$getcoms['date']."]</p>\n";
        if ($_SESSION['class'] == 'admin')
        {
        $table .= "<p align = 'right'><a href = 'delcom.php?id=".$getcoms['id']."'>Delete comment</a></p>\n";
        }
        $table .= "</td></tr>\n";
        $table .= "<tr><td><hr></td></tr>\n";
        }
        $table .= "</table>\n";
        echo $table;    
}
    catch (PDO_exception $e)
    {die ("Error:".$e->getMessage());}
    if ($count >$cpp)
    {
        echo'<center><table><tr>';
        for ($i=1; $i < ceil($count/$cpp)+1; $i++) { 
            if ($i == $p){
            echo "<td><b>$i</b></td>";}
            else
                {echo "<td><a href='news_view.php?id=$id&p=$i'>$i</a></td>";}
        }
        echo '</tr></table></center>';}
    }
 ?>
</td></tr>
</table></center>

</body>

</html>