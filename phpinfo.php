<?php
include("dataBase/db_conn.php");
$query = "SELECT * FROM users where id=50";
$statement = $connection->prepare($query);
$statement->execute();
$statement->setFetchMode(PDO::FETCH_ASSOC);
$row = $statement->fetch();
echo $row["password"];
