<?php
include "connect.php";
$f_name = $_POST['firstName'];
$l_name = $_POST['lastName'];
$email = $_POST['email'];
$password = $_POST['password'];
$b_day = $_POST['birthday'];
$gender = $_POST['gender'];
$dp = 'img/default.jpg';
$query = $conn->query("insert into user_info (firstname, lastname, email, password, birth, gender) values ('$f_name', '$l_name', '$email','$password', '$b_day', '$gender') ");

//display pic default
$id_query = $conn ->query("select * from user_info where email = '$email'");
$id_row = $id_query->fetch();
$get_id = $id_row['id'];
echo $get_id;
echo $dp;
$dp_query = $conn->query("insert into display_pic (user_id, dp) values ($get_id, '$dp')");

header('Location:index.php?reg=1');

// sending verification email

//while($row = $id_query->fetch()) {
//    $get_id = $row['id'];
//}
//$info_query = $conn->query("select * from user_info where id = $get_id");
//$info_row = $info_query->fetch();
//    $r_name = $info_row['firstname'];
//    $r_email = $info_row['email'];
//    $r_password = $info_row['password'];
//
//echo $r_name;
//echo $r_email;
//echo $r_password;

//    $mail = new PHPMailer();
//    $mail->IsSMTP();
//    $mail->SMTPDebug = 1;
//    $mail->SMTPAuth = true;
//    $mail->SMTPSecure = 'ssl';
//    $mail->Host = "smtp.gmail.com";
//    $mail->Port = 465;
//    $mail->From = 'moid.tnt@gmail.com';
//    $mail->FromName = 'togetherUS';
//    $mail->Username = "moid.tnt@gmail.com";
//    $mail->Password = "Desertrose!@#";
//    $mail->IsHTML(true);
//    $mail->Subject = "Thanx for signing up";
//    $mail->Body = "first mail";
//    $mail->AddAddress("$r_email");
//    $mail->Body="";
//    if (!$mail->Send()) {
//        echo "Mailer Error:" . $mail->ErrorInfo;
//    } else {
//        echo "email sent successfully";
//    }
