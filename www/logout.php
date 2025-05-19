<?php
session_start();
$_SESSION = [];
setcookie($_COOKIE['usercookie'], '', time() - 3600, '/');
session_destroy();
header("Location: index1.php");
exit();
?>