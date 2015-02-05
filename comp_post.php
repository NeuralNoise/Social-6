<html>
<head>
    <link rel="stylesheet" href="../includes/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="../includes/css/bootstrap.min.css">
    <script src="../includes/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="Stylesheets/stylesheet.css">
    <?php
    session_start();
    if(!$_COOKIE['userid'] && !$_SESSION['id']){
        header('Location:index.php?login=0');
    }
    include "connect.php";
    $user_id = $_SESSION['id'];
    //Your php code goes here
    include 'scrapy.php';
    include 'meta_scraping.php';
    if(!$_SESSION['id']){
        $user_id = $_COOKIE['userid'];
    }
    ?>
</head>
<body>
<div class="container-fluid" style="margin-top: 20px">
<!--    off canvas menu-->
<div class="friends sidebar">
    <!--    home button-->
    <div class="sidebar_option"><a href="home.php" class="side-option">Home</a></div>
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
    <div class="sidebar_option">
        <?php
        if(isset($_SESSION['id']) && $_SESSION['start']== true){
            echo '<a href="index.php" class="side-option">Logout</a>';
        }
        else{
            echo '<a href="logout.php" class="side-option">Login</a>';
        }
        ?>
    </div>
</div>
<div class="main_content container">
    <div class="row">
    <div class="col-md-1" style="text-align: center">
        <a class="menu_toggle"><img src="img/menu-icon.png" class="menu-img"></a>
    </div>
    <?php
    $post_id = $_GET['id'];
    $dp_query = $conn->query("select * from display_pic where user_id = $user_id");
    $dp_row = $dp_query->fetch();
    $post_query = $conn->query("select * from status_update where id = $post_id");
    $post_row = $post_query->fetch();

    echo '<div class="col-md-1">';
    //            user image
    echo '<a href="home.php?user='.$user_id.'"><img src="'.$dp_row['dp'].'" class="post_dp"></a>';
    echo '</div>';
    echo '<div class="col-md-9">';
    //            user content
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
            echo '<div class="scrap">';
            echo '<p>'.$title.'</p>';
            echo '<img src="'.$image.'" >';
            echo '<p class="description">'.$description.'</p>';
            echo '</div>';
        }
    }
    echo '</div></div>';
    echo '<div class="col-md-offset-2 col-md-8">';
    $com_query = $conn ->query("select * from comments where post_id = $post_id");
    while($com_row = $com_query->fetch()){
        echo '<div class="row" style="padding: 10px 0">';
        echo '<div class="col-md-2" style="text-align: center;">';
        $comment_by = $com_row['user_id'];
        $dp_query = $conn->query("select * from display_pic where user_id = $comment_by");
        $dp_row = $dp_query->fetch();
        $user_query = $conn->query("select * from user_info where id = $comment_by");
        $user_row = $user_query->fetch();
        echo '<a href="user.php?id='.$comment_by.'"><img src="'.$dp_row['dp'].'" class="comment_dp">';
        echo '</div>';
        echo '<div class="col-md-10">';
        echo '<p>'.$user_row['firstname'].$user_row['lastname'].'</p></a>';
        if($com_row['image'] != null) {
            echo '<div class=""><img src="' . $com_row['image'] . '" class="comment_img">';
        }
        echo '<p>' . $com_row['post_comment'] . '</p></div>';
        echo '</div>';
    }
    ?>
    <form action="add_comment.php" method="post" enctype="multipart/form-data" style="padding-top: 20px">
        <label>Comments</label>
        <textarea rows="5" class="form-control" name="comment" id="comment" style="margin-bottom: 10px"></textarea>
        <div class="fileupload btn btn-primary">
            <span>Upload</span>
            <input type="file" id="file1" name="file1" style="padding: 5px 0; display: inline-block" class="upload">
        </div>
        <?php
        echo '<input type="hidden" value="'.$post_id.'" name="post_id">';
        ?>
        <input type="submit" value="Submit" class="btn btn-default">
    </form>
</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="../includes/js/bootstrap.min.js"></script>
<!--off canvas menu-->
<script type="text/javascript">
    $(document).ready(function(){
        var menu = "close";
        $('.menu_toggle').click(function () {
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
</body>
</html>