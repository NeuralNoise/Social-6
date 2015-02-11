<?php

include "connect.php";
include "scrapy.php";
include "meta_scraping.php";

session_start();
$time = date('m/d/Y h:i:s a', time());
$user_id = $_SESSION['id'];
$get_content = $_POST['status'];
//$date_time =  date('m/d/Y h:i:s a', time());
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
        $get_vid = preg_replace('/\s+/', '', $get_content);
        if(strpos($get_vid, 'youtube') > 0 ){
            $info = json_decode(curl("http://www.youtube.com/oembed?url=" . $get_vid . "&format=json"));
            $title = $info->title;
            $get_content = $info->html;
        }
        if(strpos($get_vid, 'vimeo') > 0){
            $info = json_decode(curl("http://vimeo.com/api/oembed.json?url=".$get_vid."&maxwidth=480&maxheight=270"));
            $title = $info->title;
            $get_content = $info->html;
        }
        else if(!(strpos($get_vid, 'youtube') > 0 || strpos($get_vid, 'vimeo') > 0)){
            $output = meta_scrap($get_vid);
            $title = $output->title;
            $img = $output->image[0]->url;
            $get_content = $output->description;
        }
    }


$query = $conn->query("insert into status_update (user_id, status_post, image, video_link, title, event_time) values ($user_id, '$get_content', '$img','$get_vid', '$title','$time' )");
$id_query = $conn ->query("select * from status_update where event_time = '$time'");
$row = $id_query->fetch();

$user_query = $conn->query("select * from display_pic where user_id = $user_id");
$user_row = $user_query->fetch();

$data = array('id'=> $row['id'], 'user_id'=>$user_id, 'dp'=> $user_row['dp'] ,'status_post'=>$get_content, 'image'=>$img, 'video_link'=>$get_vid, 'title'=>$title);
echo json_encode($data);
