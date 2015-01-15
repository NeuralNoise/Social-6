<html>
<head>
    <link rel="stylesheet" href="../includes/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="../includes/css/bootstrap.min.css">
    <script src="../includes/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="stylesheet.css">
    <?php
    include "connect.php";
    //Your php code goes here
    ?>
</head>
<header>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <?php
                session_start();
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

    ?>
    <form action="add_comment.php" method="post">
        <label>Comments</label>
        <textarea rows="5" class="form-control" name="comment"></textarea>
        <input type="file" id="file1" name="file1">
        <?php
        echo '<input type="hidden" value="'.$img_row['id'].'" name="cont_id">';
        ?>
        <input type="submit" class="btn btn-default">
    </form>
</div>
</body>
</html>