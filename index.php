<html>
<head>
    <link rel="stylesheet" href="../includes/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="../includes/css/bootstrap.min.css">
    <script src="../includes/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
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
<div class="container login_box">
    <form method="post" action="user_auth.php" class="form-horizontal">
        <div class="form-group">
            <label class="col-md-2">Email</label>
            <div class="col-md-10">
                <input type="email" name="email" placeholder="Email" required="" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2">Password</label>
            <div class="col-md-10">
                <input type="password" name="password" required="" placeholder="Password" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-md-10">
                <input type="submit" value="Sign in" class="btn btn-default">
                <a href="register.php" class="btn btn-default pull-right">Sign up</a>
            </div>
        </div>
    </form>
</div>
</body>
</html>