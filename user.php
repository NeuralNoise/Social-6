<html>
<head>
    <link rel="stylesheet" href="../includes/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="../includes/css/bootstrap.min.css">
    <script src="../includes/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="Stylesheets/stylesheet.css">
    <?php
    session_start();
    //Your php code goes here
    include "connect.php";
    $get_id = $_GET['id'];
    $user_id = $_SESSION['id'];
    $info_query = $conn->query("select * from user_info where id = $get_id");
    $dp_query = $conn ->query("select * from display_pic where user_id = $get_id");
    $info_row = $info_query->fetch();
    $dp_row = $dp_query->fetch();
    include 'scrapy.php';
    ?>
</head>

<body>
<div class="container-fluid">
    <!--     Your html code goes here-->

    <div class="col-md-2"></div>
    <div class="col-md-10">
        <div class="row">
            <div class="col-md-2 dp_box">

                <!--dp in php-->
                <img src="<?php echo $dp_row['dp'] ?>" class="user_dp">
            </div>
            <div class="col-md-8">
                <?php
                echo '<p>'.$info_row['firstname'].' '.$info_row['lastname'].'</p>';
                echo '<p>'.$info_row['gender'].'</p>';
                echo '<p>'.$info_row['birth'].'</p>';
                ?>
            </div>
            <div class="col-md-2">
                <?php
                //counting if any row exists
                $count_query = $conn->query("select count(*) from friends where user_id = $user_id and friend_id = $get_id");
                $row = $count_query->fetchColumn();
                if($row == 0){
                    echo '<a href="add_friends.php?id='.$get_id.'" ><p class="btn btn-info">add friends</p></a>'; //if no row exists
                }
                else{ //if row exists
                    $f_query = $conn->query("select * from friends where user_id = $get_id and friend_id = $user_id");
                    $r_query = $conn->query("select * from friends where user_id = $user_id and friend_id = $get_id");
                    $f_row = $f_query->fetch();
                    $r_row = $r_query->fetch();
                    if($f_row['accepted'] == 1 && $r_row['accepted'] == 1){
                        echo '<p class="btn btn-success">Friends</p>';
                        $friend = true;
                    }
                    else if($r_row['accepted'] == 1 && $f_row['accepted'] == 0){
                        echo '<p class="btn btn-default">Request sent</p>';
                    }
                    else if($r_row['accepted'] == 0 && $f_row['accepted'] == 1){
                        echo '<p class="btn btn-default">Request received</p>';
                        echo '<a href="accept_req.php?id='.$get_id.'"><p>Accept</p></a>';
                        echo '<a href="decline_req.php?id='.$get_id.'"><p>Decline</p></a>';
                    }
                }
                ?>
            </div>
        </div>
        <?php
        if($friend)
            $post_query = $conn->query("select * from status_update where user_id = $get_id");
        $dp_query = $conn ->query("select * from display_pic where user_id = $get_id");
        $dp_row = $dp_query->fetch();
        while($post_row = $post_query->fetch()) {
            echo '<div class="row post"><div class="col-md-offset-2 col-md-2">';
            echo '<img src="'.$dp_row['dp'].'" class="post_dp"></div>';
            echo '<div class="col-md-8">';
            echo '<a href="comp_post.php?id=' . $post_row['id'] . '"><img src="' . $post_row['image'] . '" class="post_img">';
            if($post_row['video_link']) {
                $url = $post_row['video_link'];
                if (strpos($url, 'youtube') > 0) {
                    $info = json_decode(curl("http://www.youtube.com/oembed?url=" . $url . "&format=json"));
                    echo '<a href="comp_post.php?id=' . $post_row['id'] . '"><p>' . $info->title . '</p></a>';
                    echo $info->html;
                }
                else if (strpos($url, 'vimeo') > 0) {
                    $info = json_decode(curl("http://vimeo.com/api/oembed.json?url=".$url."&maxwidth=480&maxheight=270"));
                    echo '<a href="comp_post.php?id=' . $post_row['id'] . '"><p>' . $info->title . '</p></a>';
                    echo $info->html;
                }
            }
            echo '<p class="post_txt">' . $post_row['status_post'] . '</p></a>';
            echo '</div></div>';
        }
        ?>

    </div>
</div>
</body>
</html>