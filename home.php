<html>
<head>
    <link rel="stylesheet" href="../includes/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="../includes/css/bootstrap.min.css">
    <link rel="stylesheet" href="Stylesheets/stylesheet.css">
    <link href='http://fonts.googleapis.com/css?family=Slabo+27px' rel='stylesheet' type='text/css'>
    <?php
    include "connect.php";
    session_start();
    include "scrapy.php";
    include "meta_scraping.php";
    $user_id=$_SESSION['id'];
    $user_query = $conn ->query("select * from user_info where id = $user_id");
    $user_row = $user_query->fetch();
    $dp_query = $conn->query("select * from display_pic where user_id = $user_id");
    $dp_row = $dp_query->fetch();
    ?>

</head>
<body>
<!--<img id="para-image" src="img/Digit%20(16).jpg">-->
<div class="container-fluid" style="margin-top: 20px">

<!--    off canvas menu-->
    <div class="friends sidebar">
            <div class="side-option"><a href="#"><img src="img/logo.png" class="logo" style="margin-left: 10px"></a></div>
<!--    home button-->
            <div class="sidebar_option"><a href="home.php" class="side-option">Home</a></div>

        <div class="sidebar_option"><a href="aboutu.php" class="side-option"><?php

                echo $user_row['firstname']; ?></a></div>
<!--    number of friends-->
        <?php
        $un = true;
        $kn = true;
        $ad = true;
        $wl = true;
        $friend = 0;
        $request = 0;
        //friend list
        $query = $conn->query("select * from user_info");
        while($row = $query->fetch()) {
            $get_id = $row['id'];
            if ($get_id != $user_id) {
                $count_query = $conn->query("select count(*) from friends where user_id = $user_id and friend_id = $get_id");
                $row = $count_query->fetchColumn();
                if($row == 1){
                    $f_query = $conn->query("select * from friends where user_id = $get_id and friend_id = $user_id");
                    $r_query = $conn->query("select * from friends where user_id = $user_id and friend_id = $get_id");
                    $f_row = $f_query->fetch();
                    $r_row = $r_query->fetch();

                    if ($f_row['accepted'] == 1 && $r_row['accepted'] == 1) {
                        if ($kn) {
                            $kn = false;
                        }
                        $friend++;
                    }
                }
            }
        }
        ?>
            <div class="sidebar_option"><a href="friend_list.php" class="side-option">Friends<span class="badge"><?php echo $friend; ?></span></a></div>

<!--        pending requests count-->
        <?php
        $query = $conn->query("select * from user_info");
        while($row = $query->fetch()) {
            $get_id = $row['id'];
            if ($get_id != $user_id) {
                $count_query = $conn->query("select count(*) from friends where user_id = $user_id and friend_id = $get_id");
                $row = $count_query->fetchColumn();
                if($row == 1){
                    $f_query = $conn->query("select * from friends where user_id = $get_id and friend_id = $user_id");
                    $r_query = $conn->query("select * from friends where user_id = $user_id and friend_id = $get_id");
                    $f_row = $f_query->fetch();
                    $r_row = $r_query->fetch();

                    if ($r_row['accepted'] == 0 && $f_row['accepted'] == 1) {
                        if ($ad) {
                            $ad = false;
                        }
                        $request++;
                    }
                }
            }
        }
        ?>
        <div class="sidebar_option"><a href="friend_list.php" class="side-option">Pending<span class="badge"><?php echo $request; ?></span></a></div>
        <div class="sidebar_option"><a href="settings.php" class="side-option">Settings</a></div>
        <div class="sidebar_option">
        <?php
        if(isset($_SESSION['id']) && $_SESSION['start']== true){
            echo '<a href="logout.php" class="side-option">Logout</a>';
        }
        else{
            echo '<a href="index.php" class="side-option">Login</a>';
        }
        ?>
        </div>
        </div>
<!--user info -img, name and status update-->
    <div class="main_content container">
        <div class="row about_status">
            <div class="col-md-1" style="text-align: center">
                <a class="menu_toggle"><img src="img/menu-icon.png" class="menu-img"></a>
            </div>
            <?php

            echo '<div class="col-md-2 dp_box">';
                echo '<a href="dp_change.php?user='.$user_id.'"><img src="'.$dp_row['dp'].'" class="user_dp"></a>';
            echo '</div>';
            echo '<div class="col-md-8">';
                echo '<p id="hi">Hi, '.$user_row['firstname'];
            echo $_COOKIE['userid'];
            ?>
            <p>How u doin...</p>
                <form action="status_update.php" method="post" enctype="multipart/form-data">
                    <textarea class="form-control post_textbox" rows="4" wrap="hard" name="status" required=""></textarea>
                    <div class="" style="padding: 10px 10px 10px 0;">
                        <div class="preview">
                            <img id="pre" style="width: 200px; height: auto; border: 0">
                        </div>
                        <div class="fileUpload btn btn-primary" style="float: left; margin-right: 10px">
                            <span>Add<span class="glyphicon glyphicon-picture" aria-hidden="true" style="padding-left: 5px"></span></span>
                        <input type="file" id="file1" name="file1" style="padding: 5px 0; display: inline-block" class="upload">
                            </div>

                        <input type="submit" value="Submit" class="btn btn-default" style=" display: inline;" >
                    </div>
                </form>
            </div>
</div>
<!--    All posts-->
        <div class="prev_content  col-md-offset-2">

            <?php
//
            $post_query = $conn->query("select * from status_update order by event_time desc");
            while($post_row = $post_query->fetch()) {
                $get_id = $post_row['user_id'];
                $id = $post_row['id'];
                $post_id = 0;
                if ($get_id == $user_id) {
                    $post_id = $get_id;
//                    print status update
                } else {
//                    check for friend
                    $my_query = $conn->query("select * from friends where user_id = $user_id and friend_id = $get_id");
                    $frnd_query = $conn->query("select * from friends where user_id = $get_id and friend_id = $user_id");
                    $my_row = $my_query->fetch();
                    $frnd_row = $frnd_query->fetch();
                    if ($my_row['accepted'] & $frnd_row['accepted']) {
                        $post_id = $get_id;
                    }
                }
                if (!$post_id) {
                    continue;
                } else {

                    $dp_query = $conn->query("select * from display_pic where user_id = $get_id");
                    $dp_row = $dp_query->fetch();
//                    $ind_query = $conn->query("select * from status_update where user_id = $get_id");
//                    $post_row = $ind_query->fetch();
                    echo '<div class="row post">';
                    echo '<div class="col-md-2 text-center">';
//user image
                    echo '<a><img src="'.$dp_row['dp'].'" class="post_dp"></a>';
                    echo '</div>';
                    echo '<div class="col-md-10">';
//user post
                    if($post_row['status_post'] || $post_row['image']) {
                        echo '<a href="comp_post.php?id=' . $post_row['id'] . '" class="prev_posts"><img src="' . $post_row['image'] . '" class="post_img">';
                        echo '<p class="post_txt">' . $post_row['status_post'] . '</p></a>';
                    }
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
                        else if(!(strpos($url, 'vimeo') > 0) && !(strpos($url, 'youtube') > 0) ){
                            $output = meta_scrap($url);
                            $title = $output->title;
                            $image = $output->image[0]->url;
                            $description = $output->description;
                            $url = $output->url;
                            echo '<div class="scrap"><a href="comp_post.php?id=' . $post_row['id'] . '">';
                            echo '<p>'.$title.'</p>';
                            echo '<img src="'.$image.'" >';
                            echo '<p class="description">'.$description.'</p>';
                            echo '</a>';
                            echo '</div>';
                        }
                    }
                    echo '<div class="list-inline post_link_box">';
                    echo '<a href="comp_post.php?id=' . $post_row['id'] . '#comment"><img src="img/comments.png" class="post_links"></a>';
                    echo '<div id="like"><img src="img/like.png" class="post_links"><img src="img/like_done.png" class="post_links" style="display: none"></div>';
                    echo '<a href="'.$url.'" target="_blank"><img src="img/external_link.png" class="post_links"></a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';

                }
            }
            ?>

        </div>
    <a href="#" class="scrollToTop"><img src="" </a>
    </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="../includes/js/bootstrap.min.js"></script>
<!--off canvas menu-->
<script type="text/javascript">
    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#pre').attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#file1").change(function(){
        readURL(this);
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        var menu = "close";
        $('.menu_toggle').click(function () {
            if(menu == "close"){
                var pos = window.pageYOffset;
                $('.sidebar').css('-webkit-transform', 'translate(0, 0)');
                $('.main_content').css('-webkit-transform', 'translate(15%,0)');
                $('.menu-img').attr('src','img/back.png');
                menu = "open";
            }
            else{
                $('.sidebar').css('-webkit-transform', 'translate(-100%,0)');
                $('.main_content').css('-webkit-transform', 'translate(0,0)');
                $('.menu-img').attr('src','img/menu-icon.png');
                menu = "close";
            }
        });
        $('#like').click(function(){
            $(this).find('img').toggle();
        });

    });
</script>
</body>
</html>