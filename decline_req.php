<?php
include "connect.php";
session_start();
$user_id = $_SESSION['id'];
$get_id = $_GET['id'];
echo "user".$user_id;
echo "friend".$get_id;
$query = $conn->query("delete from friends where user_id = $user_id and friend_id = $get_id");
$d_query = $conn->query("delete from friends where user_id = $get_id and friend_id = $user_id and accepted = 1");
echo "asd";
header('Location: user.php?id='.$get_id.'');
?>