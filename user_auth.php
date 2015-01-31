<?php

include('connect.php');
$get_email = $_POST['email'];
$get_password = $_POST['password'];
$remember = $_POST['remember'];
if($get_password && $get_email) {
    $query = $conn -> query("SELECT * FROM user_info WHERE email = '$get_email'");
    $row = $query -> fetch();
    if($row['password'] == $get_password){
        session_start();
        echo 'logged in';
        $_SESSION['start']=true;
        $_SESSION['id']=$row['id'];

//        Remember me
          if($remember){
              setcookie("userid", $row['id'], time()+ 300,  "/");
          }
        header('Location: home.php#hi');
        exit();
    }
    else{
        echo "Invalid Username or Password! Try again";
        header('Location: index.php?err=404');
        exit();
    }
}
