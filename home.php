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
        <h3>List</h3>
        <?php
        $query = $conn ->query("select * from user_info");
        while($row =$query->fetch()) {
            if($row['id'] != $user_id){
                echo '<a href="user.php?id='.$row['id'].'"><p class="name">'.$row['firstname'].' '.$row['lastname'].'</p></a>';
                echo '<p class="">'.$row['email'].'</p>';
            }
        }
//        $r_query = $conn ->query("select * from friends where user_id = $user_id and accepted = 0");
//        while($r_row = $r_query->fetch()){
//            $r_id = $r_row['friend_id'];
//            $user_query = $conn ->query("select * from user_info where id = $r_id");
//            $user_row = $user_query->fetch();
//            echo '<a><p>Request received from'.$user_row['firstname'].'</p></a>';
//        }

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