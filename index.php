<html>
<head>
    <link rel="stylesheet" href="includes/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="includes/css/bootstrap.min.css">
    <link rel="stylesheet" href="Stylesheets/stylesheet.css">
    <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>

</head>
<body id="login_page" style="font-family: 'Lobster', cursive !important;">
<div class="welcome">
    <a href="#" data-toggle="modal" data-target="#login"><img src="img/welcome.png" id="welcome_img"></a>


    <!-- Modal -->
    <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="width: 75%">
                <div class="modal-body">
                    <h4 class="modal-title" id="myModalLabel" style="margin-bottom: 10px">Holla..!!</h4>

                    <form class="form-inline" action="user_auth.php" method="post">
                        <div class="form-group">
                            <label class="sr-only" for="Email">Email address</label>
                            <input type="email" name="email" placeholder="Email" required="" class="form-control"
                                   id="Email3">
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="Password">Password</label>
                            <input type="password" class="form-control" id="Password" name="password" required=""
                                   placeholder="Password">
                        </div>
                        <div class="row">
                            <div class="form-group col-md-offset-4" style="margin-top: 10px; text-align: right">
                                <input type="checkbox" value="1" name="remember">Remember me
                                <button type="submit" class="btn btn-default" style="margin-left: 20px;">Sign in
                                </button>
                                <a href="#" data-toggle="modal" data-target="#register" class="btn btn-default">New
                                    User</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="width: 90%; padding: 5px">
                <h4 class="modal-title" id="myModalLabel" style="margin: 10px;">New User...??</h4>

                <div class="modal-body">
                    <form method="post" action="add_user.php">
                        <div class="form-group form-inline">
                            <label>Name</label>
                            <br>
                            <input type="text" name="firstName" placeholder="First" class="form-control" required="">
                            <input type="text" name="lastName" placeholder="Last" class="form-control" required=""
                                   style="margin-left: 80px">
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
                                if (isset($gender) && $gender == "Male") {
                                    echo "Male";
                                }
                                ?>
                                >Male
                            <input type="radio" name="gender" value="Female"
                                <?php
                                if (isset($gender) && $gender == "Female") {
                                    echo "Female";
                                }
                                ?>
                                >Female
                            <input type="radio" name="gender" value="Others"
                                <?php
                                if (isset($gender) && $gender == "Others") {
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
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="includes/js/bootstrap.min.js"></script>
</body>
</html>