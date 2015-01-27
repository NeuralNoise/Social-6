<?php
session_start();
include ("connect.php");
$user_id = $_SESSION['id'];
$fileName = $_FILES["file1"]["name"];
$fileTmpLoc = $_FILES["file1"]["tmp_name"];
$fileType = $_FILES["file1"]["type"];
$filesize = $_FILES["file1"]["size"];
$fileErrorMsg = $_FILES["file1"]["error"];
if(!$fileTmpLoc)
{
    header('Location:dp_change?user='.$user_id.'&img=0');
}
if(move_uploaded_file($fileTmpLoc, "img/$fileName")){
    chmod("img/$fileName", 0755);
    $img = "img/".$fileName;
}
echo $user_id;
$dp_query = $conn->query("update display_pic set dp = '$img' where user_id = $user_id");
header('Location:home.php?user='.$user_id.'');
?>