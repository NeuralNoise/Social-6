<html>
<head>
    <link rel="stylesheet" href="../includes/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="../includes/css/bootstrap.min.css">
    <script src="../includes/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="Stylesheets/stylesheet.css">
    <?php
    session_start();
    include "connect.php";
    $user_id = $_SESSION['id'];
    //Your php code goes here
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
<div class="container">
    <?php
    $post_id = $_GET['id'];
    $post_query = $conn->query("select * from status_update where id = $post_id");
    $post_row = $post_query->fetch();
    echo '<div class="row">';
    echo '<div class="col-md-2">';
    //            user image
    echo '<a href="dp_change.php?user=' . $user_id . '"><img src="img/img1.jpg" class="post_dp"></a>';
    echo '</div>';
    echo '<div class="col-md-10">';
    //            user content
    echo '<img src="' . $post_row['image'] . '" class="post_img">';
    echo '<p class="post_txt">' . $post_row['status'] . '</p>';

    echo '</div>';
    echo '</div>';
    echo '<div class="col-md-offset-2">';
    $com_query = $conn ->query("select * from comments where post_id = $post_id");
    while($com_row = $com_query->fetch()){
        echo '<div class="row">';
        echo '<div class="col-md-1">';
        $user_id = $com_row['user_id'];
//        user image
        echo '</div>';
        echo '<div class="col-md-11">';
        echo '<div class=""><img src="'.$com_row['image'].'" class="comment_img"><p>'.$com_row['comment'].'</p></div>';
        echo '</div>';
    }
    ?>
    <form action="add_comment.php" method="post" enctype="multipart/form-data">
        <label>Comments</label>
        <textarea rows="5" class="form-control" name="comment"></textarea>
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
</body>
</html>