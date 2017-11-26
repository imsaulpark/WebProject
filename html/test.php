<html>
<head>
	
</head>

<body>
<?php

session_start();

$dsn = "mysql:host=localhost;port=3306;dbname=bookchef;charset=utf8"; 
try { 
	$db = new PDO($dsn, "root", "qkrtmddn"); 
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

	$id = "saulpark";
	
	$query = "SELECT * FROM keyword WHERE ID = ?";

	$stmt = $db->prepare($query);
	$stmt->execute(array($id));
	$result = $stmt->fetchAll(PDO::FETCH_NUM);

	for($i = 0 ; $i < count($result) ; $i++){
		printf("%s's keyword : ",$result[0][0]);
		for($j = 1;$j < 7 ; $j++){
			if($result[0][$j]!=NULL)
				printf("%s  ",$result[0][$j]);
		}
	echo "<br/>";
	}

	$_SESSION["id"] = "saulpark";

echo "<a href='./test2.php'>test2 page</a>";

 
}
catch(PDOException $e) { echo $e->getMessage(); }
?>
</body>
</html>
