<?php
include("db_conn.php");
if (!empty($_SESSION["iduser"])) {
	$userid = $_SESSION["iduser"];
	$result = mysqli_query($connection, "SELECT * FROM users WHERE id = $userid");
	$row = mysqli_fetch_assoc($result);
	$userRole = $row["role"];
	if ($userRole === "Admin") {
		header("Location: indexAdmin.php");
	} else {
		header("Location: index.php");
	}
} else {
	header("Location: login.php");
}
$id = $_GET['id'];
$query = "DELETE FROM users WHERE id = $id";
$result = mysqli_query($connection, $query);
if ($result) {
	header("Location: indexAdmin.php?msg=User deleted successfylly");
} else {
	echo "Failed: " . mysqli_error($connection);
}
