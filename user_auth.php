<?php

include('connect.php');
$get_email = $_POST['email'];
$get_password = $_POST['password'];
if($get_password && $get_email) {
    $query = $conn -> query("SELECT * FROM user_info WHERE email = '$get_email'");
    $row = $query -> fetch();
    if($row['password'] == $get_password){
        $id = $row['id'];
        echo $id;
        echo 'logged in';
        $_SESSION['start']=true;
        $_SESSION['id']=$id;
        echo "logged in";
        header('Location: home.php');
        exit();
    }
    else{
        echo "Invalid Username or Password! Try again";
        header('Location: signin.php?err=403');
        exit();
    }
}
?>