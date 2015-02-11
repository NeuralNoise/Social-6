<?php
include "connect.php";
session_start();
$user_id = $_SESSION['id'];
$get_id = $_GET['id'];

$query = $conn->query("delete from friends where user_id = $user_id and friend_id = $get_id and accepted = 0");
$d_query = $conn->query("delete from friends where user_id = $get_id and friend_id = $user_id and accepted = 1");
header('Location: user.php?id='.$get_id.'');
?>