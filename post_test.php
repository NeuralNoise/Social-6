<html>
<head>
    <link rel="stylesheet" href="../includes/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="../includes/css/bootstrap.min.css">
    <link rel="stylesheet" href="Stylesheets/stylesheet.css">
    <link href='http://fonts.googleapis.com/css?family=Slabo+27px' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="menu-trans/assets/css/hmbrgr.min.css" />
</head>
<body>
<form action="" method="post" enctype="multipart/form-data" id="status_post">
    <textarea class="form-control post_textbox" rows="4" wrap="hard" name="status" required="" style="width: 50%" id="textbox_post"></textarea>
    <div class="" style="padding: 10px 10px 10px 0;">
        <div class="preview">
            <img id="pre" style="width: 200px; height: auto; border: 0">
        </div>
        <div class="fileUpload btn btn-primary" style="float: left; margin-right: 10px">
            <span>Add<span class="glyphicon glyphicon-picture" aria-hidden="true" style="padding-left: 5px"></span></span>
            <input type="file" id="file" name="file" style="padding: 5px 0; display: inline-block" class="upload">
        </div>
        <input type="submit" value="Submit" class="btn btn-default submit" style=" display: inline;" >
    </div>
</form>
<?php
include "connect.php";
$query = $conn ->query("select * from status_update");
while($row = $query->fetch()){
    echo '<a href="'.$row['video_link'].'"><h2>'.$row['title'].'</h2>';
    echo '<div><img src="'.$row['image'].'" style="width:400px; height:auto"></div>';
    echo '<div>'.$row['status_post'].'</div>';
    echo '</a>';
}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="ajax.js"></script>
<script type="text/javascript">
    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#pre').attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#file").change(function(){
        readURL(this);
    });
</script>
</body>
</html>