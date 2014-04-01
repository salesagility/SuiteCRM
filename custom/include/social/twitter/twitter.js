/*
 * @author Salesagility Ltd <support@salesagility.com>
 * Date: 15/01/14
 * Time: 09:14
 */

$(function () {

    //Grab the twitter user name field.

    var twitter_user = $("#twitter_user_c").text();

    // If twitter user in not blank run the Ajax Call to the entry point to start processing.
    if (twitter_user != '') {

        if (twitter_user) {

            $.ajax({
                type: "POST",
                url: "index.php?entryPoint=social",
                data: { twitter_user: twitter_user, social: "twitter"}
            })
                .done(function (msg) {
                    $("#feed").html(' ');
                    $("#feed").html(msg + $("#feed").html());
                });

        } else {
            return false;
        }

    }
});