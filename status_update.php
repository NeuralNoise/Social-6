<?php
include ("connect.php");
session_start();
$user_id = $_SESSION['id'];
$get_content = $_POST['status'];
$date_time =  date('m/d/Y h:i:s a', time());
$img = ""; $get_vid = "";
$fileName = $_FILES["file1"]["name"];
$fileTmpLoc = $_FILES["file1"]["tmp_name"];
$fileType = $_FILES["file1"]["type"];
$filesize = $_FILES["file1"]["size"];
$fileErrorMsg = $_FILES["file1"]["error"];
if(move_uploaded_file($fileTmpLoc, "img/$fileName")){
    $img = 'img/'.$fileName;
}
    if (preg_match('/^(http)/', $get_content)) {
        $get_vid = $get_content;
        $get_content = null;
    }

$query = $conn->query("insert into status_update (user_id, status, image, time, video_link) values ($user_id, '$get_content', '$img', '$date_time','$get_vid')");
header('Location:home.php?user='.$user_id.'');
?>