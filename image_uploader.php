<?php
session_start();
include ("connect.php");
$type = $_GET['img'];

$user_id = $_SESSION['id'];
$fileName = $_FILES["file1"]["name"];
$fileTmpLoc = $_FILES["file1"]["tmp_name"];
$fileType = $_FILES["file1"]["type"];
$filesize = $_FILES["file1"]["size"];
$fileErrorMsg = $_FILES["file1"]["error"];

if($img == 1) {
    if (!$fileTmpLoc) {
        header('Location:dp_change?user=' . $user_id . '&img=0');
    }
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
    header('Location:home.php?user=' . $user_id . '');
}
else if($img == 2){
    if (!$fileTmpLoc) {
        header('Location:change_background?user=' . $user_id . '&img=0');
    }
    if (move_uploaded_file($fileTmpLoc, "img/$fileName")) {
        chmod("img/$fileName", 0755);
        $img = "img/" . $fileName;
    }
    if (!$fileName) {
        $img = "img/default.jpg";
        $dp_query = $conn->query("update display_pic set bg_img = '$img' where user_id = $user_id");
    } else {
        $dp_query = $conn->query("update display_pic set bg_img = '$img' where user_id = $user_id");
    }
    header('Location:home.php?user=' . $user_id . '');
}
?>