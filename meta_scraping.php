<?php
function meta_scrap($url){
    $link = 'https://graph.facebook.com/?id='.$url.'&scrape=true&method=post';
    $ch = curl($link);
    return json_decode($ch);
}
