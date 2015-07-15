<html>
<head>
    <link rel="stylesheet" href="includes/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="includes/css/bootstrap.min.css">
    <link rel="stylesheet" href="Stylesheets/stylesheet.css">
    <link href='http://fonts.googleapis.com/css?family=Slabo+27px' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="menu-trans/assets/css/hmbrgr.min.css"/>

    <?php
    include "connect.php";
    session_start();
    if (!$_COOKIE['userid'] && !$_SESSION['id']) {
        header('Location:index.php?login=0');
    }
    include "scrapy.php";
    include "meta_scraping.php";
    $user_id = $_SESSION['id'];
    if (!$_SESSION['id']) {
        $user_id = $_COOKIE['userid'];
    }
    $user_query = $conn->query("select * from user_info where id = $user_id");
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
        <div class="sidebar_option"><a href="#"><img src="img/logo.png" class="logo" style="margin-left: 10px"></a>
        </div>
        <!--    home button-->
        <div class="sidebar_option"><a href="home.php" class="side-option"><span><img src="img/home.png"></span>Home</a>
        </div>

        <div class="sidebar_option"><a href="aboutu.php" class="side-option"><?php
                echo '<span><img src="' . $dp_row['dp'] . '" class="user_dp"></span>';
                echo $user_row['firstname']; ?></a></div>
        <!--    number of friends-->
        <?php
        $un = true;
        $kn = true;
        $ad = true;
        $wl = true;
        $friend = 0;
        $request = 0;
        //        friend list
        $query = $conn->query("select * from user_info");
        while ($row = $query->fetch()) {
            $get_id = $row['id'];
            if ($get_id != $user_id) {
                $count_query = $conn->query("select count(*) from friends where user_id = $user_id and friend_id = $get_id");
                $row = $count_query->fetchColumn();
                if ($row == 1) {
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
        <div class="sidebar_option"><a href="friend_list.php" class="side-option"><span><img src="img/friends-icon.png"></span>Friends<span
                    class="badge"><?php echo $friend; ?></span></a></div>

        <!--        pending requests count-->
        <?php
        $query = $conn->query("select * from user_info");
        while ($row = $query->fetch()) {
            $get_id = $row['id'];
            if ($get_id != $user_id) {
                $count_query = $conn->query("select count(*) from friends where user_id = $user_id and friend_id = $get_id");
                $row = $count_query->fetchColumn();
                if ($row == 1) {
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
        if (!$ad) {
            echo '<div class="sidebar_option"><a href="friend_list.php" class="side-option"><span><img src="img/received.png"></span>Pending<span class="badge"><?php echo $request; ?></span></a></div>';
        }
        ?>
        <!--Settings-->
        <div class="sidebar_option"><a href="settings.php" class="side-option"><span><img src="img/settings.png"></span>Settings</a>
        </div>
        <div class="sidebar_option">
            <?php
            if (isset($_SESSION['id']) && $_SESSION['start'] == true) {
                echo '<a href="logout.php" class="side-option"><span><img src="img/logout.png"></span>Logout</a>';
            }
            ?>
        </div>
    </div>
    <!--user info -img, name and status update-->
    <div class="main_content">
        <div class="row about_status">
            <div class="col-md-1" style="text-align: center">
                <a href="#" class="menu_toggle hmbrgr"></a>
            </div>
            <?php

            echo '<div class="col-md-2 dp_box">';
            echo '<a href="dp_change.php?user=' . $user_id . '"><img src="' . $dp_row['dp'] . '" class="user_dp"></a>';
            echo '</div>';
            echo '<div class="col-md-6">';
            echo '<p id="hi">Hi, ' . $user_row['firstname'];
            ?>
            <!--            Status update form-->
            <p>How u doin...</p>

            <form action="" method="post" enctype="multipart/form-data" id="status_post">
                <textarea class="form-control post_textbox" rows="4" wrap="hard" name="status" required=""
                          placeholder=""></textarea>

                <div class="" style="padding: 10px 10px 10px 0;">
                    <div class="preview">
                        <img id="pre" style="width: 200px; height: auto; border: 0">
                    </div>
                    <div class="fileUpload btn btn-primary" style="float: left; margin-right: 10px">
                        <span>Add<span class="glyphicon glyphicon-picture" aria-hidden="true"
                                       style="padding-left: 5px"></span></span>
                        <input type="file" id="file1" name="file1" style="padding: 5px 0; display: inline-block"
                               class="upload">
                    </div>
                    <input type="submit" value="Submit" class="btn btn-default submit" style=" display: inline;">
                </div>
            </form>
            <div style="text-align: center"><img id="message" src="img/loading.GIF" style="opacity: 0; width: 50px">
            </div>
        </div>
    </div>
    <!--    All posts preview-->
    <div class="prev_content  col-md-offset-2">
        <ul>
            <?php
            echo '<li>';
            $post_query = $conn->query("select * from status_update order by event_time desc");
            while ($post_row = $post_query->fetch()) {

                $get_id = $post_row['user_id'];
                $id = $post_row['id'];
                $post_id = 0;
                if ($get_id == $user_id) {
                    $post_id = $get_id;
                } else {
//                    check for friend
                    $my_query = $conn->query("select * from friends where user_id = $user_id and friend_id = $get_id");
                    $frnd_query = $conn->query("select * from friends where user_id = $get_id and friend_id = $user_id");
                    $my_row = $my_query->fetch();
                    $frnd_row = $frnd_query->fetch();
                    if ($my_row['accepted'] == 1 & $frnd_row['accepted'] == 1) {
                        $post_id = $get_id;
                    }
                }
                if (!$post_id) {
                    continue;
                } else {

                    $dp_query = $conn->query("select * from display_pic where user_id = $get_id");
                    $dp_row = $dp_query->fetch();
                    echo '<div class="row post">';
                    echo '<div class="col-md-2 text-center">';
//user image
                    echo '<a href="user.php?id=' . $get_id . '"><img src="' . $dp_row['dp'] . '" class="post_dp"></a>';
                    echo '</div>';
                    echo '<div class="col-md-6">';
//user post
                    echo '<a href="comp_post.php?id=' . $post_row['id'] . '" class="prev_posts"><p style="font-size:20px">' . $post_row['title'] . '</p><img src="' . $post_row['image'] . '" class="post_img">';
                    echo '<p class="post_txt">' . $post_row['status_post'] . '</p></a>';

                    echo '<div class="comments_link" >';
                    echo '<div>';
                    echo '<a href="comp_post.php?id=' . $post_row['id'] . '#comment" data-toogle="tooltip" data-placement="right" title="Comments" onclick="comments_field();"><img src="img/comment.png" class="post_links"></a>';
                    if ($post_row['video_link']) {
                        echo '<a href="' . $post_row['video_link'] . '" target="_blank" data-toogle="tooltip" data-placement="right" title="Link"><img src="img/external_link.png" class="post_links"></a>';
                    }
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';


                }
                echo '</div>';
                echo '</li>';
            }
            ?>
        </ul>
    </div>
    <!--Scroll to top button-->
    <a href="#" class="scrollToTop"><img src="img/to_top.png"></a>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="menu-trans/assets/js/jquery.hmbrgr.min.js"></script>
    <script src="includes/js/bootstrap.min.js"></script>
    <script src="ajax.js" type="application/javascript"></script>
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

        $("#file1").change(function () {
            readURL(this);
        });
    </script>
    <!--    Hamburger-->
    <script type="text/javascript">
        $('.hmbrgr').hmbrgr({
            width: 50, 		// optional - set hamburger width
            height: 30, 		// optional - set hamburger height
            speed: 200,		// optional - set animation speed
            barHeight: 4,			// optional - set bars height
            barRadius: 0,			// optional - set bars border radius
            barColor: '#000000'	// optional - set bars color
        });
        //    Off canvas menu
        $(document).ready(function () {
            var menu = "close";
            $('.menu_toggle').click(function () {
                if (menu == "close") {
                    var pos = window.pageYOffset;
                    $('.sidebar').css('-webkit-transform', 'translate(0, 0)');
                    $('.main_content').css('-webkit-transform', 'translate(15%,0)');
                    $('.menu-img').attr('src', 'img/back.png');
                    menu = "open";
                }
                else {
                    $('.sidebar').css('-webkit-transform', 'translate(-100%,0)');
                    $('.main_content').css('-webkit-transform', 'translate(0,0)');
                    $('.menu-img').attr('src', 'img/menu-icon.png');
                    menu = "close";
                }
            });
            //Check to see if the window is top if not then display button
            $(window).scroll(function () {
                if ($(this).scrollTop() > 100) {
                    $('.scrollToTop').fadeIn();
                } else {
                    $('.scrollToTop').fadeOut();
                }
            });

            //Click event to scroll to top
            $('.scrollToTop').click(function () {
                $('html, body').animate({scrollTop: 0}, 800);
                return false;
            });

        });
    </script>
</body>
</html>