/* Stop IE flicker */
if ($.browser.msie == true) document.execCommand('BackgroundImageCache', false, true);
ChiliBook.recipeFolder     = "js/chili/";
ChiliBook.stylesheetFolder = "js/chili/"

jQuery.fn.antispam = function() {
  return this.each(function(){
	var email = $(this).text().toLowerCase().replace(/\sdot/g,'.').replace(/\sat/g,'@').replace(/\s+/g,'');
	var URI = "mailto:" + email;
	$(this).hide().before(
		$("<a></a>").attr("href",URI).addClass("external").text(email)
	);
  });
};


$(function() {
	$("pre.javascript").chili();
	$("pre.html").chili();
	$("pre.css").chili();
	$("a.external").each(function() {this.target = '_new'});	
	$("span.email").antispam();
});