/**
 * Created by ian on 14/01/14.
 */

$(function() {
    //create new subpanel for social feeds



        //Ajax Call
        username = $("#facebook_user_c").text();
        if(username){
             module = $("#formDetailView input[name=module]").val();
             record = $("input[name=record]").val();
             social = "facebook";
             url = document.URL;

             $.ajax({
                 type: "POST",
                 url: "index.php?entryPoint=social&social=facebook&username=" + username + "&module=" + module + "&record=" + record,
                 data: { username: username, social: "facebook", url:url }
             })
             .done(function( msg ) {
                $("#facebook_feed").html( msg );
             });
         }
});




