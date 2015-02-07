<html>
<head>
    <link rel="stylesheet" href="../includes/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="../includes/css/bootstrap.min.css">
    <link rel="stylesheet" href="Stylesheets/stylesheet.css">
    <link href='http://fonts.googleapis.com/css?family=Slabo+27px' rel='stylesheet' type='text/css'>
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
    $get_id = $_GET['id'];
    $user_query = $conn ->query("select * from user_info where id = $get_id");
    $user_row = $user_query->fetch();
    $dp_query = $conn->query("select * from display_pic where user_id = $get_id");
    $dp_row = $dp_query->fetch();

    ?>

</head>
<body>
<!--<img src="img/Wallpaper%20(13).jpg" style="position:fixed;">-->
<!--<img id="para-image" src="img/Digit%20(16).jpg">-->
<div class="container-fluid" style="padding-top: 20px">
    <div style="position: fixed; right: 0; " class="pull-right"><a href="change_background.php?user=<?php echo $user_id; ?> " class="add_image"><img src="img/add.png" style="width: 40px; height: 40px"></a></div>
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
    <div class="main_content">
        <div class="row about_status">
            <div class="col-md-1" style="text-align: center">
                <a class="menu_toggle"><img src="img/menu-icon.png" class="menu-img"></a>
            </div>
            <?php

            echo '<div class="col-md-2 dp_box">';
            echo '<a href="dp_change.php?user='.$user_id.'"><img src="'.$dp_row['dp'].'" class="user_dp"></a>';
            echo '</div>';
            echo '<div class="col-md-8">';
            echo '<p id="hi">'.$user_row['firstname'].' '.$user_row['lastname'];
            echo '<p>'.$user_row['birth'].'</p>';
            echo '<p>'.$user_row['email'].'</p>';
            ?>

        </div>
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
//        $('.row.post').addClass("hidden").viewportChecker({
//            classToAdd: 'visible animated fadeInDown', // Class to add to the elements when they are visible
//            offset: 10000
//        });
            var like = 0;
            $('#like').click(function (){
                if(like == 0){
                    $('.like img').attr('src', 'img/like.png');
                    like = 1;
                }
                else if(like == 1){
                    $('.like img').attr('src', 'img/like_done.png');
                    like = 0;
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