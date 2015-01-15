<html>
<head>
    <link rel="stylesheet" href="../includes/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="../includes/css/bootstrap.min.css">
    <script src="../includes/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="stylesheet.css">
    <?php

    include('connect.php');
    $id = $_GET['user'];
    $img_query = $conn->query("select * from images where user_id = $id");
    $img_row = $img_query->fetch();

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
    <img src="<?php echo $img_row['display_pic']; ?>" class="">
    <form id="upload_form" action="image_uploader.php" method="post" enctype="multipart/form-data">
        <h3>Select file to upload:</h3>
        <input type="file" name="file1" id="file1" value="Add">
        <input type="submit" value="Upload file" class="btn btn-default">
    </form>
</div>
</body>
</html>