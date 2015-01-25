<html>
<head>
    <link rel="stylesheet" href="../includes/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="../includes/css/bootstrap.min.css">
    <link rel="stylesheet" href="Stylesheets/stylesheet.css">
    <?php
    include "connect.php";
    session_start();
    include 'scrapy.php';
    include 'meta_scraping.php';
    $user_id=$_SESSION['id'];
    ?>
</head>
<body>
<img id="para-image" src="img/Digit%20(16).jpg">
<div class="container-fluid" id="content">

<!--    off canvas menu-->

    <div class="friends sidebar">
<!--    home button-->
            <a href="home.php" class="side-option">Home</a>
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
            <a href="friend_list.php" class="side-option">Friends<span class="badge"><?php echo $friend; ?></span></a>

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
        <a href="friend_list.php" class="side-option">Pending<span class="badge"><?php echo $request; ?></span></a>

        <?php
        if(isset($_SESSION['id']) && $_SESSION['start']== true){
            echo '<a href="index.php" class="btn cred">Logout</a>';
        }
        else{
            echo '<a href="logout.php" class="btn cred">Login</a>';
        }
        ?>
    </div>
<!--user info -img, name and status update-->
    <div class="main_content">

        <div class="row about_status">
            <div class="col-md-1">
                <a class="menu-toggle"><img src="img/menu-icon.png" class="menu-img"></a>
            </div>
            <?php
            $user_query = $conn ->query("select * from user_info where id = $user_id");
            $user_row = $user_query->fetch();
            echo '<div class="col-md-2 dp_box">';
                echo '<a href="dp_change.php?user='.$user_id.'"><img src="img/img1.jpg" class="user_dp"></a>';
            echo '</div>';
            echo '<div class="col-md-9">';
                echo '<p id="hi">Hi, '.$user_row['firstname'];
            ?>
            <p>How u doin...</p>
                <form action="status_update.php" method="post" enctype="multipart/form-data">
                    <textarea class="form-control" rows="2" wrap="hard" name="status"></textarea>
                    <input type="file" id="file1" name="file1">
                    <input type="submit" value="Submit" class="btn btn-default">
                </form>
            </div>
        </div>
<!--    All posts-->
        <div class="prev_content">
            <?php

            include "connect.php";
            $post_query = $conn->query("select * from status_update where user_id = $user_id");
            while($post_row = $post_query->fetch()) {
                echo '<div class="row post">';
                echo '<div class="col-md-offset-2 col-md-10">';
                echo '<div class="row">';
                echo '<div class="col-md-1 dp_box">';
//            user image
                echo '<a href="#"><img src="img/img1.jpg" class="user_dp"></a>';
                echo '</div>';
                echo '<div class="col-md-10">';
//            user content
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
                    else{
                        if($return = meta_scrap($url)) {
                            $url = $return->url;
                            $title = $return->title;
                            $image = $return->image[0]->url;
                            $description = $return->description;
                        }
                        else{
                            $curl = curl($url);
                        }
                    }
                }
                echo '<p class="post_txt">' . $post_row['status'] . '</p></a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            ?>

        </div>
    </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="../includes/js/bootstrap.min.js"></script>
<!--off canvas menu-->
<script type="text/javascript">
    $(document).ready(function(){
        var menu = "close";
        $('.menu-toggle').click(function () {
            if(menu == "close"){
                var pos = window.pageYOffset;
                $('.sidebar').css('-webkit-transform', 'translate(0, 0)');
                $('.main_content').css('-webkit-transform', 'translate(10%,0)');
                menu = "open";
            }
            else{
                $('.sidebar').css('-webkit-transform', 'translate(-100%,0)');
                $('.main_content').css('-webkit-transform', 'translate(0,0)');
                menu = "close";
            }
        });
    });
</script>
parallax effect
<script type="text/javascript">
    var ypos, image;
    var limit = Math.max( document.body.scrollHeight, document.body.offsetHeight,
        document.documentElement.clientHeight, document.documentElement.scrollHeight, document.documentElement.offsetHeight );
    function parallax(){
        ypos = window.pageYOffset;
        image = document.getElementById('para-image');
        image.style.top = ypos * 1 +'px';
    }
    window.addEventListener('scroll', parallax);
</script>
</body>
</html>