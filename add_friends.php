<?php
include "connect.php";
session_start();
$userid = $_SESSION['id'];
$get_id = $_GET['id'];
$add_query = $conn ->query("insert into friends (user_id, friend_id, accepted) values ($userid, $get_id, 0)");
header("Location:user.php?id=$get_id");
?>