$(function() {

    var twitter_user = $( "#twitter_user_c" ).text();

    if(twitter_user){

        $.ajax({
            type: "POST",
            url: "index.php?entryPoint=social",
            data: { twitter_user: twitter_user, social: "twitter"}
        })
            .done(function( msg ) {
                $("#twitter_feed").html(' ');
                $("#twitter_feed").html( msg + $("#twitter_feed").html() );
            });

    }else{
        return false;
    }


});