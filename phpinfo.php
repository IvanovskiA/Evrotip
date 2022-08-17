<?php
require_once("dataBase/db_conn.php");
$query = "SELECT * FROM slotpersons where ReferenceNo = 'GS02606/22'AND PersonObjectId='1812987414012' AND TransactionDate='2022-06-26' LIMIT 1";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);
print_r($row);
