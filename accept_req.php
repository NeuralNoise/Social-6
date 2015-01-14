<?php
include "connect.php";
session_start();
$user_id = $_SESSION['id'];
$get_id = $_GET['id'];
echo "user".$user_id;
echo "friend".$get_id;
$query = $conn->query("update friends set accepted = 1 where user_id = $user_id and friend_id = $get_id");
echo "asd";
header('Location: user.php?id='.$get_id.'');
?>