<html>
<head>
    <link rel="stylesheet" href="../includes/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="../includes/css/bootstrap.min.css">
    <script src="../includes/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="Stylesheets/stylesheet.css">
    <?php
    session_start();
    include('connect.php');
    $id = $_GET['user'];
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
    $query = $conn ->query("select * from display_pic where user_id = $id");
    $row = $query->fetch();
    echo '<img style="width:600px" src="'.$row['dp'].'" class="">';
    ?>

    <form id="upload_form" action="image_uploader.php" method="post" enctype="multipart/form-data">
        <h3>Select file to upload:</h3>
        <div class="fileUpload btn btn-primary">
            <span>Add<span class="glyphicon glyphicon-picture" aria-hidden="true" style="padding-left: 5px"></span></span>
        <input type="file" name="file1" id="file1" value="Add" class="upload">
            </div>
        <input type="submit" value="Update" class="btn btn-default">
    </form>
</div>

</body>
</html>