<?php
function meta_scrap($url){

    $link = 'https://graph.facebook.com/?id='.$url.'&scrape=true&method=post';
    $html = curl($link);
    return json_decode($html);
}
?>