<?php
try
{
	//connect
	$db = new PDO('mysql:host=localhost;dbname=site1','root','root');
	//SELECT and show
	$result = $db->query("SELECT * FROM news LIMIT 2");
	$error_array = $db->errorInfo();
 
	if($db->errorCode() != 0000)
 	echo "SQL ошибка: " . $error_array[2] . '<br /><br />';
 
	// теперь получаем данные из класса PDOStatement
 
	while($row = $result->fetch(PDO::FETCH_ASSOC))
	{print_r($row);}
	
	//
	$rows = $db->exec("INSERT INTO `testing` VALUES
		(null, 'Ivan', 'ivan@test.com'),
		(null, 'Petr', 'petr@test.com'),
		(null, 'Vasiliy', 'vasiliy@test.com')
	");

	//PREPARED STATEMENTS
	# именные placeholders 
	$sth3 = $db->prepare("SELECT * FROM `testing` WHERE id=:id");
	$sth3->bindParam(':id',$id);
	$sth3->execute();

}
catch (PDO_exception $e)
{die ("Error:".$e->getMessage());}


?>