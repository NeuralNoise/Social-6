$(document).ready(function (e) {
    $("#status_post").on('submit',(function(e) {
        e.preventDefault();
        $("#message").css('opacity','1');
        $.ajax({
            url: "status_update.php", // Url to which the request is send
            type: "POST",             // Type of request to be send, called as method
            data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData:false,        // To send DOMDocument or non processed data file it is set to false
            success: function(data)   // A function to be called if request succeeds
            {
                var title = ' ';
                $("#message").css('opacity', '0');
                var json = JSON.parse(data);
                if (json.title == null) {
                    title = ' ';
                }
                else {
                    title = json.title;
                }

                console.log(data);
                $('ul').prepend('<li><div class="row post"><div class="col-md-2 text-center">' +
                '<a href="user.php?id=' + json.user_id + '"><img src="' + json.dp + '" class="post_dp"/></a></div>' +
                '<div class="col-md-6">' +
                '<a href="comp_post.php?id=' + json.id + '" class="prev_post"><h4>' + title + '</h4>' +
                '<img src="' + json.image + '" class="post_img"/>' +
                '<p class="post_text">' + json.status_post + '</p></a>' +
                '<div class="comment_link"><div>' +
                '<a href="comp_post.php?id=' + json.id + '#comment" data-toogle="tooltip" data-placement="right" title="Comments" onclick="comments_field();">' +
                '<img src="img/comment.png" class="post_links"></a>' +
                '<a href="' + json.video_link + '" target="_blank" data-toogle="tooltip" data-placement="right" title="Link"><img src="img/external_link.png" class="post_links"></a>' +
                '</div></div>' +
                '</div>' +
                '</div></li>');
               document.getElementById('status_post').reset();
            }
        });
    }));
});