<?php
include ("connect.php");
$upload = '';
$fileName = $_FILES["file1"]["name"];
$fileTmpLoc = $_FILES["file1"]["tmp_name"];
$fileType = $_FILES["file1"]["type"];
$filesize = $_FILES["file1"]["size"];
$fileErrorMsg = $_FILES["file1"]["error"];
print_r($_FILES);
if(!$fileName)
{
    echo '<h3>error, please browse for file</h3>';
    exit();
}
if(move_uploaded_file($fileName, "img/$fileName")){
    echo "$fileName".'<h3>successfully added to your gallery</h3>';
}
else{
    echo "<h3>upload failed</h3>";
}
//$query = $conn->query("insert into images (display_pic) values ('$fileName')");
?>