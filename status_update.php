<?php
include ("connect.php");
session_start();
$user_id = $_SESSION['id'];
$status = $_POST['status'];
$date_time =  date('m/d/Y h:i:s a', time());
$img = "";
$fileName = $_FILES["file1"]["name"];
$fileTmpLoc = $_FILES["file1"]["tmp_name"];
$fileType = $_FILES["file1"]["type"];
$filesize = $_FILES["file1"]["size"];
$fileErrorMsg = $_FILES["file1"]["error"];
if(move_uploaded_file($fileTmpLoc, "img/$fileName")){
    $img = 'img/'.$fileName;
}
$query = $conn->query("insert into status_update (user_id, status, image, time) values ($user_id, '$status', '$img', '$date_time')");
header('Location:home.php?user='.$user_id.'');
?>