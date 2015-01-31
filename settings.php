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
    if(!$_SESSION['id']){
        $user_id = $_COOKIE['userid'];
    }
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
    <div class="main_content container">
        <div class="row about_status">
            <div class="col-md-1" style="text-align: center">
                <a class="menu_toggle"><img src="img/menu-icon.png" class="menu-img"></a>
            </div>
            <div class="col-md-10">
                <p style="font-size: 40px">Settings</p>
                <p style="font-size: 30px">Update Login Info</p>
                <div class="row">
                <div class="col-md-8">
                    <form action="update_info.php" method="post">
                    <?php
                    echo '<img src="'.$dp_row['dp'].'" style="max-width:100%;" id="pre">';
                    ?>
                        <div class="fileUpload btn btn-primary">
                            <span>Add<span class="glyphicon glyphicon-picture" aria-hidden="true" style="padding-left: 5px"></span></span>
                            <input type="file" name="file1" id="file1" value="Add" class="upload">
                        </div>
                        <input type="submit" name="submit" value="Update" class="btn btn-primary">
                </div>
                <div class="col-md-4">

                        <?php echo $user_row['firstname']; ?><input type="text" class="form-control" placeholder="First Name" name="firstname">
                        <?php echo $user_row['lastname']; ?><input type="text" class="form-control" placeholder="Last Name" name="lastname">
                        <?php echo $user_row['birth']; ?><input type="date" class="form-control" placeholder="Birthday" name="birth">
                        <?php echo $user_row['email']; ?><input type="email" class="form-control" placeholder="Email" name="email">
                        Password<input type="password" class="form-control" placeholder="Password" name="password">
                        Confirm Password<input type="password" class="form-control" placeholder="Confirm Password" name="c_password">

                    </form>
                    <?php
                    $err = $_GET['err'];
                    if($err == 999){
                        echo '<p>Please enter the same password</p>';
                    }

                    ?>
                </div>
            </div>
            </div>
            </div>
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
        });
    </script>
</body>
</html>