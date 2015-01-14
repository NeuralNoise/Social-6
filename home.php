<html>
<head>
    <link rel="stylesheet" href="../includes/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="../includes/css/bootstrap.min.css">
    <script src="../includes/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="stylesheet.css">
    <?php
    include "connect.php";
    session_start();
    $user_id=$_SESSION['id'];

    $img_query = $conn ->query("select * from images where user_id = $user_id");
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
    <div class="col-md-2 friends">

        <?php
        //counting if any row exists

        $un = true;
        $kn = true;
        $ad = true;
        $wl = true;
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
                            echo '<h3>Friends</h3>';
                            $kn = false;
                        }
                        $user_query = $conn->query("select * from user_info where id = $get_id");
                        $user_row = $user_query->fetch();
                        echo '<a href="user.php?id=' . $user_row['id'] . '"><p class="name">' . $user_row['firstname'] . ' ' . $user_row['lastname'] . '</p></a>';
                        echo '<p class="">' . $user_row['email'] . '</p>';
                    }
                }
            }
        }
        // pending requests
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
                            echo '<h3>Request received</h3>';
                            $ad = false;
                        }
                        $user_query = $conn->query("select * from user_info where id = $get_id");
                        $user_row = $user_query->fetch();
                        echo '<a href="user.php?id=' . $user_row['id'] . '"><p class="name">' . $user_row['firstname'] . ' ' . $user_row['lastname'] . '</p></a>';
                        echo '<p class="">' . $user_row['email'] . '</p>';
                    }
                }
            }
        }
        //People you may know
        $query = $conn->query("select * from user_info");
        while($row = $query->fetch()) {
            $get_id = $row['id'];
            if ($get_id != $user_id) {
                $count_query = $conn->query("select count(*) from friends where user_id = $user_id and friend_id = $get_id");
                $row = $count_query->fetchColumn();
                if ($row == 0) {
                    if ($un) {
                        echo '<h3>People you may know</h3>';
                        $un = false;
                    }
                    $user_query = $conn->query("select * from user_info where id = $get_id");
                    $user_row = $user_query->fetch();
                    echo '<a href="user.php?id=' . $user_row['id'] . '"><p class="name">' . $user_row['firstname'] . ' ' . $user_row['lastname'] . '</p></a>';
                    echo '<p class="">' . $user_row['email'] . '</p>';
                    //if no row exists
                }
                else if($row == 1){
                    $f_query = $conn->query("select * from friends where user_id = $get_id and friend_id = $user_id");
                    $r_query = $conn->query("select * from friends where user_id = $user_id and friend_id = $get_id");
                    $f_row = $f_query->fetch();
                    $r_row = $r_query->fetch();

                    if ($r_row['accepted'] == 1 && $f_row['accepted'] == 0) {
                        $user_query = $conn->query("select * from user_info where id = $get_id");
                        $user_row = $user_query->fetch();
                        echo '<a href="user.php?id=' . $user_row['id'] . '"><p class="name">' . $user_row['firstname'] . ' ' . $user_row['lastname'] . '</p></a>';
                        echo '<p class="">' . $user_row['email'] . '</p>';
                    }
                }
            }
        }

        ?>
    </div>
<!--    All display content -->
    <div class="col-md-10">
        <div class="row">

            <?php
            $user_query = $conn ->query("select * from user_info where id = $user_id");
            $user_row = $user_query->fetch();
            echo '<div class="col-md-2 dp_box">';
                echo '<a href="dp_change.php?user='.$user_id.'"><img src="img/img1.jpg" class="user_dp"></a>';
            echo '</div>';
            echo '<div class="col-md-10">';
                echo '<p>Hi, '.$user_row['firstname'];
            ?>
            <p>How u doin...</p>
                <form action="" method="post" enctype="multipart/form-data">
                    <textarea class="form-control" rows="2" wrap="hard" name="status"></textarea>
                    <input type="file" id="file1" name="file1">
                    <input type="submit" value="Submit" class="btn btn-default">
                </form>
            </div>
        </div>
        <div class="prev_content">
            <?php
            include "connect.php";
            while($img_row = $img_query->fetch())
            echo '<div class="row">';
                echo '<div class="col-md-offset-2 col-md-10">';
                    echo '<a href="comp_post.php?id='.$user_id.'"><img src="img/'.$img_row['gallery'].'" class="status_img"></a>';
                    echo '<p>'.$img_row['status'].'</p>';
                echo '</div>';
            echo '</div>';
            ?>
        </div>
    </div>
</body>
</html>