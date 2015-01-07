<html>
<head>
    <link rel="stylesheet" href="../includes/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="../includes/css/bootstrap.min.css">
    <script src="../includes/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
<div class="container">
    <?php
    $error = $_GET['err'];
    if($error == 403){
        echo '<p>Invalid Credential, Please check your email and password and try again</p>';
        }
    ?>
    <form class="form-horizontal" action="user_auth.php" method="post">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control">
        </div>
            <input type="submit" class="btn btn-default" value="Sign in">
    </form>

</div>
</body>
</html>