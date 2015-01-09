<html>
<head>
    <link rel="stylesheet" href="../includes/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="../includes/css/bootstrap.min.css">
    <script src="../includes/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="stylesheet.css">
    <?php
    include "connect.php";
    //Your php code goes here
    $img_id = $_GET['id'];
    $img_query = $conn ->query("select * from images where user_id = $img_id");
    $comm_query = $conn ->query("select * from comments where user_id = $img_id");
    ?>
</head>
<header>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <?php
                session_start();
                if(isset($_SESSION['id']) && $_SESSION['start']== true){
                    echo "log out";
                }
                else{
                    echo "log in";
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
<div class="container">
    <?php

    $img_row = $img_query->fetch();
    echo '<img src="img/'.$img_row['gallery'].'">';
    echo '<p>'.$img_row['tags'].'</p>';
    while($comm_row = $comm_query->fetch()){
        echo '<p>'.$comm_row['comment'].'</p>';
    }
    ?>
    <form action="add_comment.php" method="post">
        <label>Comments</label>
        <textarea rows="2" class="form-control"></textarea>
        <input type="file">
        <?php
        echo '<input type="hidden" value="'.$img_row['id'].'" name="cont_id">'
        ?>
        <input type="submit" class="btn btn-default">
    </form>
</div>
</body>
</html>