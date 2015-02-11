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

//image upload
$type = $_GET['img'];

$user_id = $_SESSION['id'];
$fileName = $_FILES["file1"]["name"];
$fileTmpLoc = $_FILES["file1"]["tmp_name"];
$fileType = $_FILES["file1"]["type"];
$filesize = $_FILES["file1"]["size"];
$fileErrorMsg = $_FILES["file1"]["error"];

if (move_uploaded_file($fileTmpLoc, "img/$fileName")) {
    chmod("img/$fileName", 0755);
    $img = "img/" . $fileName;
}
if (!$fileName) {
    $img = "img/default.jpg";
    $dp_query = $conn->query("update display_pic set dp = '$img', if_default = 1 where user_id = $user_id");
} else {
    $dp_query = $conn->query("update display_pic set dp = '$img', if_default = 0 where user_id = $user_id");
}

if($new_password === $con_password){
    $update_query = $conn->query("update user_info set firstname = '$new_fn', lastname = '$new_ln', birth = $new_birth, email = '$new_email', password = '$new_password' where user_id = $user_id ");
    header('Location:home.php');
}
else{
    header('Location:header.php?err=999');
}