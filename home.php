<html>
<head>
    <link rel="stylesheet" href="../includes/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="../includes/css/bootstrap.min.css">
    <script src="../includes/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="stylesheet.css">
    <?php
    include "connect.php";
    $user_id=$_GET['user'];
    $user_query = $conn ->query("select * from user_info where id = $user_id ");
    $user_row = $user_query->fetch();
    $img_query = $conn ->query("select * from images where user_id = $user_id");
    $img_row = $img_query->fetch();
    ?>
</head>
<header>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand">
                    <img src="">
                </a>
            </div>
        </div>
    </nav>
</header>
<body>
<div class="container-fluid">
    <div class="col-md-2">
    </div>
    <div class="col-md-10">
        <div class="row">
            <?php
            echo '<div class="col-md-2 dp_box">';
            echo '<a href="dp_change.php?user='.$user_id.'"><img src="'.$img_row['display_pic'].'" class="user_dp"></a>';
            echo '</div>';
            echo '<div class="col-md-10">';
            echo '<p>Hi, '.$user_row['firstname'];
            echo '</div>';
            ?>
        </div>
    </div>
</div>
</body>
</html>