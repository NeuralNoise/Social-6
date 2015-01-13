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
    $user_query = $conn ->query("select * from user_info where id = $user_id");
    $user_row = $user_query->fetch();
    $img_query = $conn ->query("select * from images where user_id = $user_id");
    $frnd_query = $conn ->query("select * from friends where user_id = $user_id");
    ?>
</head>
<header>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <?php

                if(isset($_SESSION['id']) && $_SESSION['start']== true){
                    echo "logged in";
                    echo "  user id".$user_id;
                }
                else{
                    echo "logged out";
                }
                ?>
                <a class="navbar-brand">
                    <img src="">
                </a>
            </div>
        </div>
    </nav>
</header>
<body>
<div class="container-fluid">
    <div class="col-md-2 friends">
        <h3>Friends list</h3>
        <?php
        $friends = array();
        $n = 0;
        while($frnd_row = $frnd_query->fetch()){
                $frnd_id = $frnd_row['friend_id'];
                $list_query = $conn->query("select * from user_info where id = $frnd_id");
            if($frnd_row['accepted'] == 1){
                $list_row = $list_query->fetch();
                $friends[$n] = $list_row['id'];
                echo '<a href="user.php?id='.$list_row['id'].'"><p class="name">'.$list_row['firstname'].' '.$list_row['lastname'].'</p></a>';
                echo '<p class="">'.$list_row['email'].'</p>';
            }
            else if($frnd_row['recieved']== 1 && $frnd_row['accepted'] == 0){
                echo '<h3>Request recieved</h3>';
                    $list_row = $list_query->fetch();
                    $friends[$n] = $list_row['id'];
                    echo '<a href="user.php?id='.$list_row['id'].'"><p class="name">'.$list_row['firstname'].' '.$list_row['lastname'].'</p></a>';
                    echo '<p class="">'.$list_row['email'].'</p>';
                }
            else if($frnd_row['sent']== 1 && $frnd_row['accepted'] == 0){
                echo '<h3>Request Sent</h3>';
                $list_row = $list_query->fetch();
                $friends[$n] = $list_row['id'];
                echo '<a href="user.php?id='.$list_row['id'].'"><p class="name">'.$list_row['firstname'].' '.$list_row['lastname'].'</p></a>';
                echo '<p class="">'.$list_row['email'].'</p>';
            }
            $n++;
        }
        ?>

        <h3>People you may know</h3>
        <?php
        $query = $conn ->query("select * from user_info");
        while($row =$query->fetch()) {
            $f = 0;
            $id = $row['id'];
            if ($id != $user_id) {
                for ($i = 0; $i < $n; $i++) {
                    if ($id != $friends[$i]) {
                        $f++;
                    }
                }
                if($f >= $n ){
                    $user_query = $conn ->query("select * from user_info where id = $id");
                    $user_row = $user_query->fetch();
                    echo '<a href="user.php?id='.$user_row['id'].'"><p class="name">'.$user_row['firstname'].' '.$user_row['lastname'].'</p></a>';
                    echo '<p class="">'.$user_row['email'].'</p>';
                }
            }

        }
        ?>
    </div>
<!--    All display content -->
    <div class="col-md-10">
        <div class="row">

            <?php
            echo '<div class="col-md-2 dp_box">';
                echo '<a href="dp_change.php?user='.$user_id.'"><img src="img/img1.jpg" class="user_dp"></a>';
            echo '</div>';
            echo '<div class="col-md-10">';
                echo '<p>Hi, '.$user_row['firstname'];
            echo '</div>';
            ?>
        </div>
        <div class="row">
            <div class="col-md-offset-2 col-md-8">
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
</div>
</body>
</html>