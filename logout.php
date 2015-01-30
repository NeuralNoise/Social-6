<?php

$_SESSION['start']=false;
$_SESSION['id'] = 0;
unset($_SESSION['id']);

session_destroy();
session_commit();
setcookie("user", "", time() - 3600);
header('Location: index.php');
exit();