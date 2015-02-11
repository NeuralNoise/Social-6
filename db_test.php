<?php

include "connect.php";
include "meta_scraping.php";
include "scrapy.php";

$img = ""; $get_vid = "";
$time = date('m/d/Y h:i:s a', time());

$get_content = $_POST['status'];

$fileName = $_FILES["file"]["name"];
$fileTmpLoc = $_FILES["file"]["tmp_name"];
$fileType = $_FILES["file"]["type"];
$filesize = $_FILES["file"]["size"];
$fileErrorMsg = $_FILES["file"]["error"];

if (move_uploaded_file($fileTmpLoc, "img/$fileName")) {
    chmod("img/$fileName", 0777);
    $img = "img/".$fileName;

}

if (preg_match('/^(http)/', $get_content)) {
    $get_vid = preg_replace('/\s+/', '', $get_content);
    if(strpos($get_vid, 'youtube') > 0 ){
        $get_content = null;
    }
    if(strpos($get_vid, 'vimeo') > 0){
        $get_content = null;
    }
    else if(!(strpos($get_vid, 'youtube') > 0 || strpos($get_vid, 'vimeo') > 0)) {
        $output = meta_scrap($get_vid);
        $title = $output->title;
        $img = $output->image[0]->url;
        $get_content = $output->description;
    }
}
$query = $conn->query("insert into status_update (status_post, image, video_link, title, event_time ) values ('$get_content', '$img','$get_vid', '$title','$time' )");
$id_query = $conn ->query("select * from status_update where event_time = '$time'");
//$row = $id_query->fetch();

$data = array('status'=> $get_content, 'image' => $img, 'link' => $get_vid, 'time'=> $time, 'title' => $title , 'id'=>$row['id']);
echo json_encode($data);
