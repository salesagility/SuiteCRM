$(document).ready(function(){
 $('[data-action=emails-compose]').click(function(){
   alert('compose email placeholder');
 });

 $('[data-action=emails-configure]').click(function(){
   alert('configure email placeholder');
 });

 $('[data-action=emails-check-new-email]').click(function(){
   alert('check new email placeholder');
 });

 $('[data-action=emails-open-folder]').click(function(){
   alert('open folder email placeholder');
 });

 // look for new
  $('.email-indicator .email-new').each(function(i, v){
    $(this).parents('tr').addClass('email-new-record');
  });
});