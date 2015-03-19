or<?php
include "connect.php";
session_start();
$comment = $_POST['comment'];
$get_id = $_POST['post_id'];
$user_id = $_SESSION['id'];
$img = "";
$fileName = $_FILES["file1"]["name"];
$fileTmpLoc = $_FILES["file1"]["tmp_name"];
$fileType = $_FILES["file1"]["type"];
$filesize = $_FILES["file1"]["size"];
$fileErrorMsg = $_FILES["file1"]["error"];
if(move_uploaded_file($fileTmpLoc, "img/$fileName")){
    $img = 'img/'.$fileName;
}

$query = $conn->query("insert into comments (user_id, post_id, post_comment,image) values ($user_id,$get_id,'$comment','$img')");
header('Location:comp_post.php?id='.$get_id.'');
?>