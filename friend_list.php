<html>
<head></head>
<body>

<?php
include 'connect.php';
session_start();
$user_id = $_SESSION['id'];
$un = true;
$kn = true;
$ad = true;
$wl = true;
//friend list
$query = $conn->query("select * from user_info");
while($row = $query->fetch()) {
    $get_id = $row['id'];
    if ($get_id != $user_id) {
        $count_query = $conn->query("select count(*) from friends where user_id = $user_id and friend_id = $get_id");
        $row = $count_query->fetchColumn();
        if($row == 1){
            $f_query = $conn->query("select * from friends where user_id = $get_id and friend_id = $user_id");
            $r_query = $conn->query("select * from friends where user_id = $user_id and friend_id = $get_id");
            $f_row = $f_query->fetch();
            $r_row = $r_query->fetch();

            if ($f_row['accepted'] == 1 && $r_row['accepted'] == 1) {
                if ($kn) {
                    echo '<h3>Friends</h3>';
                    $kn = false;
                }
                $user_query = $conn->query("select * from user_info where id = $get_id");
                $user_row = $user_query->fetch();
                echo '<a href="user.php?id=' . $user_row['id'] . '"><p class="name">' . $user_row['firstname'] . ' ' . $user_row['lastname'] . '</p></a>';
                echo '<p class="">' . $user_row['email'] . '</p>';
            }
        }
    }
}
// pending requests
$query = $conn->query("select * from user_info");
while($row = $query->fetch()) {
    $get_id = $row['id'];
    if ($get_id != $user_id) {
        $count_query = $conn->query("select count(*) from friends where user_id = $user_id and friend_id = $get_id");
        $row = $count_query->fetchColumn();
        if($row == 1){
            $f_query = $conn->query("select * from friends where user_id = $get_id and friend_id = $user_id");
            $r_query = $conn->query("select * from friends where user_id = $user_id and friend_id = $get_id");
            $f_row = $f_query->fetch();
            $r_row = $r_query->fetch();

            if ($r_row['accepted'] == 0 && $f_row['accepted'] == 1) {
                if ($ad) {
                    echo '<h3>Request received</h3>';
                    $ad = false;
                }
                $user_query = $conn->query("select * from user_info where id = $get_id");
                $user_row = $user_query->fetch();
                echo '<a href="user.php?id=' . $user_row['id'] . '"><p class="name">' . $user_row['firstname'] . ' ' . $user_row['lastname'] . '</p></a>';
                echo '<p class="">' . $user_row['email'] . '</p>';
            }
        }
    }
}
//People you may know
$query = $conn->query("select * from user_info");
while($row = $query->fetch()) {
    $get_id = $row['id'];
    if ($get_id != $user_id) {
        $count_query = $conn->query("select count(*) from friends where user_id = $user_id and friend_id = $get_id");
        $row = $count_query->fetchColumn();
        if ($row == 0) {
            if ($un) {
                echo '<h3>People you may know</h3>';
                $un = false;
            }
            $user_query = $conn->query("select * from user_info where id = $get_id");
            $user_row = $user_query->fetch();
            echo '<a href="user.php?id=' . $user_row['id'] . '"><p class="name">' . $user_row['firstname'] . ' ' . $user_row['lastname'] . '</p></a>';
            echo '<p class="">' . $user_row['email'] . '</p>';
            //if no row exists
        }
        else if($row == 1){
            $f_query = $conn->query("select * from friends where user_id = $get_id and friend_id = $user_id");
            $r_query = $conn->query("select * from friends where user_id = $user_id and friend_id = $get_id");
            $f_row = $f_query->fetch();
            $r_row = $r_query->fetch();

            if ($r_row['accepted'] == 1 && $f_row['accepted'] == 0) {
                $user_query = $conn->query("select * from user_info where id = $get_id");
                $user_row = $user_query->fetch();
                echo '<a href="user.php?id=' . $user_row['id'] . '"><p class="name">' . $user_row['firstname'] . ' ' . $user_row['lastname'] . '</p></a>';
                echo '<p class="">' . $user_row['email'] . '</p>';
            }
        }
    }
}

?>

</body>
</html>