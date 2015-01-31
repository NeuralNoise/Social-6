<?php
include "connect.php";
session_start();
$user_id = $_SESSION['id'];

$new_fn = $_POST['firstname'];
$new_ln = $_POST['lastname'];
$new_email = $_POST['email'];
$new_birth = $_POST['birth'];
$new_password = $_POST['password'];
$con_password = $_POST['c_password'];

if($new_password === $con_password){
    $update_query = $conn->query("update user_info set firstname = '$new_fn', lastname = '$new_ln', birth = $new_birth, email = '$new_email', password = '$new_password' where user_id = $user_id ");
}
else{
    header('Location:header.php?err=999');
}