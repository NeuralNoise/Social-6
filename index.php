<html>
<head>
    <link rel="stylesheet" href="../includes/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="../includes/css/bootstrap.min.css">
    <script src="../includes/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="Stylesheets/stylesheet.css">
</head>
<body>
<header>
    <div class="homepage">
        <div class="container">

<!--site logo -->
    <div class="col-md-2">
        <a href="#"><img src="img/logo.png" id="logo"></a>
    </div>

<!--login, sigin in -->
    <div class="col-md-10 login">
        <form class="form-inline" action="user_auth.php" method="post">
            <div class="form-group">
                <label class="sr-only" for="Email">Email address</label>
                <input type="email" name="email" placeholder="Email" required="" class="form-control" id="Email3">
            </div>
            <div class="form-group">
                <label class="sr-only" for="Password">Password</label>
                <input type="password" class="form-control" id="Password" name="password" required="" placeholder="Password">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-default">Sign in</button>
            </div>
        </form>
        <?php
        $err = $_GET['err'];
        if($err == 404){
            echo '<p style="color:white; float: none">*Invalid Credential</p>';
        }
        ?>
    </div>
    </div>
    </div>
</header>
<div class="content">
    <div class="container">
        <div class="col-md-7">
            <?php
            $reg = $_GET['reg'];
            if($reg == 1){
                echo '<h3 style="color: white">Successfully registered, Login to continue</h3>';
            }
            ?>
        </div>

<!-- registeration form-->
        <div class="col-md-5 register" style="color: white">
            <h2 style="padding-bottom: 10px; color: #3789C7">New User...Sign Up Now..!!</h2>
            <form method="post" action="add_user.php">
                <div class="form-group form-inline">
                    <label>Name</label>
                    <br>
                    <input type="text" name="firstName" placeholder="First" class="form-control" required="">
                    <input type="text" name="lastName" placeholder="Last" class="form-control" required="" style="margin-left: 80px">
                </div>
                <div class="form-group">
                    <label>Enter a valid email id</label>
                    <input type="email" name="email" class="form-control" required="">
                </div>
                <div class="form-group">
                    <label>Create a Password</label>
                    <input type="password" name="password" class="form-control" required="">
                </div>
                <div class="form-group">
                    <label>Birthday</label>
                    <input type="date" name="birthday" class="form-control" required="">
                </div>
                <div class="form-group">
                    <label>Gender</label>
                    <br>
                    <input type="radio" name="gender" value="Male"
                        <?php
                        if(isset($gender) && $gender == "Male"){
                            echo "Male";
                        }
                        ?>
                        >Male
                    <input type="radio" name="gender" value="Female"
                        <?php
                        if(isset($gender) && $gender == "Female"){
                            echo "Female";
                        }
                        ?>
                        >Female
                    <input type="radio" name="gender" value="Others"
                        <?php
                        if(isset($gender) && $gender == "Others"){
                            echo "Others";
                        }
                        ?>
                        >Others
                </div>
                <input type="submit" value="Submit" class="btn btn-default">
            </form>
        </div>
    </div>
</div>
<footer></footer>
</body>
</html>