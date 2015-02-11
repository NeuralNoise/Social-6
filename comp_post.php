<html>
<head>
    <link rel="stylesheet" href="../includes/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="../includes/css/bootstrap.min.css">
    <link rel="stylesheet" href="Stylesheets/stylesheet.css">
    <link href='http://fonts.googleapis.com/css?family=Slabo+27px' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="menu-trans/assets/css/hmbrgr.min.css" />

    <?php
    include "connect.php";
    session_start();
    if(!$_COOKIE['userid'] && !$_SESSION['id']){
        header('Location:index.php?login=0');
    }
    include "scrapy.php";
    include "meta_scraping.php";
    $user_id = $_SESSION['id'];
    if(!$_SESSION['id']){
        $user_id = $_COOKIE['userid'];
    }
    echo $_COOKIE['userid'];
    $user_query = $conn ->query("select * from user_info where id = $user_id");
    $user_row = $user_query->fetch();
    $dp_query = $conn->query("select * from display_pic where user_id = $user_id");
    $dp_row = $dp_query->fetch();

    ?>

</head>
<body>
<!--<img src="img/Wallpaper%20(13).jpg" style="position:fixed;">-->
<!--<img id="para-image" src="img/Digit%20(16).jpg">-->
<div class="container-fluid" style="padding-top: 20px">
    <!--    off canvas menu-->
    <div class="friends sidebar">
        <div class="sidebar_option"><a href="#"><img src="img/logo.png" class="logo" style="margin-left: 10px"></a></div>
        <!--    home button-->
        <div class="sidebar_option"><a href="home.php" class="side-option"><span><img src="img/home.png"></span>Home</a></div>

        <div class="sidebar_option"><a href="aboutu.php" class="side-option"><?php
                echo '<span><img src="'.$dp_row['dp'].'" class="user_dp"></span>';
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
        <div class="sidebar_option"><a href="friend_list.php" class="side-option"><span><img src="img/friends-icon.png"></span>Friends<span class="badge"><?php echo $friend; ?></span></a></div>

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
        if(!$ad){
            echo '<div class="sidebar_option"><a href="friend_list.php" class="side-option">Pending<span class="badge"><?php echo $request; ?></span></a></div>';
        }
        ?>

        <div class="sidebar_option"><a href="settings.php" class="side-option"><span><img src="img/settings.png"></span>Settings</a></div>
        <div class="sidebar_option">
            <?php
            if(isset($_SESSION['id']) && $_SESSION['start']== true){
                echo '<a href="logout.php" class="side-option"><span><img src="img/logout.png"></span>Logout</a>';
            }
            ?>
        </div>
    </div>
    <!--user info -img, name and status update-->
    <div class="main_content">
        <div class="row about_status">
            <div class="col-md-1" style="text-align: center">
                <a href="#" class="menu_toggle hmbrgr" ></a>
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
    echo '<div class="col-md-6">';
    //            user content

    echo '<a href="comp_post.php?id=' . $post_row['id'] . '" class="prev_posts"><h4>'.$post_row['title'].'</h4><img src="' . $post_row['image'] . '" class="post_img">';
    echo '<p class="post_txt">' . $post_row['status_post'] . '</p></a>';

    echo '</div></div>';
    echo '<div class="col-md-offset-2 col-md-6">';
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
    <a href="#" class="scrollToTop"><img src="img/to_top.png"></a>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="menu-trans/assets/js/jquery.hmbrgr.min.js"></script>
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
        $('.hmbrgr').hmbrgr({
            width     : 50, 		// optional - set hamburger width
            height    : 30, 		// optional - set hamburger height
            speed     : 200,		// optional - set animation speed
            barHeight : 4,			// optional - set bars height
            barRadius : 0,			// optional - set bars border radius
            barColor  : '#000000'	// optional - set bars color
        });
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
            //Check to see if the window is top if not then display button
            $(window).scroll(function(){
                if ($(this).scrollTop() > 100) {
                    $('.scrollToTop').fadeIn();
                } else {
                    $('.scrollToTop').fadeOut();
                }
            });

            //Click event to scroll to top
            $('.scrollToTop').click(function(){
                $('html, body').animate({scrollTop : 0},800);
                return false;
            });

        });
    </script>
</body>
</html>