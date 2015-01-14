<html>
<head>
    <link rel="stylesheet" href="../includes/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="../includes/css/bootstrap.min.css">
    <script src="../includes/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="stylesheet.css">
    <?php
    session_start();
    //Your php code goes here
    include "connect.php";
    $get_id = $_GET['id'];
    $user_id = $_SESSION['id'];
    $info_query = $conn->query("select * from user_info where id = $get_id");
    $dp_query = $conn ->query("select * from images where user_id = $get_id");
    $info_row = $info_query->fetch();
    $img_row = $dp_query->fetch();

    ?>
</head>
<header>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <?php

                if(isset($_SESSION['id']) && $_SESSION['start']== true){
                    echo '<a href="index.php" class="btn cred">Logout</a>';
                }
                else{
                    echo '<a href="logout.php" class="btn cred">Login</a>';
                }
                ?>
                <a class="navbar-brand">
                    <a href="home.php"  class="btn home">Home</a>
                </a>
            </div>
        </div>
    </nav>
</header>
<body>
<div class="container-fluid">
    <!--     Your html code goes here-->
    <div class="col-md-2"></div>
    <div class="col-md-10">
        <div class="row">
            <div class="col-md-2 dp_box">

                <!--dp in php-->
                <img src="img/img1.jpg" class="user_dp">
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
                    echo '<a href="add_friends.php"><p>add friends</p></a>'; //if no row exists
                }
                else{ //if row exists
                    $f_query = $conn->query("select * from friends where user_id = $get_id and friend_id = $user_id");
                    $f_row = $f_query->fetch();
                    if($f_row['accepted'] == 1){
                        echo '<p>Friends</p>';
                    }
                    else{
                        echo '<a><p>Request sent</p></a>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>