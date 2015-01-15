<html>
<head>
    <link rel="stylesheet" href="../includes/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="../includes/css/bootstrap.min.css">
    <script src="../includes/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="stylesheet.css">
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
    <div class="col-md-5">
    <form method="post" action="add_user.php">
        <div class="form-group form-inline">
            <label>Name</label>
            <br>
            <input type="text" name="firstName" placeholder="First" class="form-control" required="">
            <input type="text" name="lastName" placeholder="Last" class="form-control" required="">
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
                ?>>Female
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
</body>
</html>