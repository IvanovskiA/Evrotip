<?php
require_once("db_conn.php");
$_SESSION = [];
session_unset();
session_destroy();
header("Location: login.php");
