<?php
session_start();
$_SESSION['start']=false;
session_unset();
unset($_SESSION['id']);
setcookie("userid", 0 , time()-7600, "/");
session_destroy();
header('Location: index.php');
die("Redirecting to login page..please wait");