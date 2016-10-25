<?php

// config|_override.php
if(is_file('../../../config.php')) {
    require_once('../../../config.php');
}

// load up the config_override.php file.  This is used to provide default user settings
if(is_file('../../../config_override.php')) {
    require_once('../../../config_override.php');
}

if(!isset($sugar_config['theme_settings']['Suite7'])) return;

//set file type back to css from php
header("Content-type: text/css; charset: UTF-8");

?>

/*custom colour css*/

#header {
    background: #<?php echo $sugar_config['theme_settings']['Suite7']['menu']; ?>;
    background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iIzMzMzMzMyIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiMxMjEyMTIiIHN0b3Atb3BhY2l0eT0iMSIvPgogIDwvbGluZWFyR3JhZGllbnQ+CiAgPHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjEiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+);
    background: -moz-linear-gradient(top,  #<?php echo $sugar_config['theme_settings']['Suite7']['menuto']; ?> 0%, #<?php echo $sugar_config['theme_settings']['Suite7']['menufrom']; ?> 100%); /* FF3.6+ */
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#<?php echo $sugar_config['theme_settings']['Suite7']['menuto']; ?>), color-stop(100%,#<?php echo $sugar_config['theme_settings']['Suite7']['menufrom']; ?>)); /* Chrome,Safari4+ */
    background: -webkit-linear-gradient(top,  #<?php echo $sugar_config['theme_settings']['Suite7']['menuto']; ?> 0%,#<?php echo $sugar_config['theme_settings']['Suite7']['menufrom']; ?> 100%); /* Chrome10+,Safari5.1+ */
    background: -o-linear-gradient(top,  #<?php echo $sugar_config['theme_settings']['Suite7']['menuto']; ?> 0%,#<?php echo $sugar_config['theme_settings']['Suite7']['menufrom']; ?> 100%); /* Opera 11.10+ */
    background: -ms-linear-gradient(top,  #<?php echo $sugar_config['theme_settings']['Suite7']['menuto']; ?> 0%,#<?php echo $sugar_config['theme_settings']['Suite7']['menufrom']; ?> 100%); /* IE10+ */
    background: linear-gradient(to bottom,  #<?php echo $sugar_config['theme_settings']['Suite7']['menuto']; ?> 0%,#<?php echo $sugar_config['theme_settings']['Suite7']['menufrom']; ?> 100%); /* W3C */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#<?php echo $sugar_config['theme_settings']['Suite7']['menuto']; ?>', endColorstr='#<?php echo $sugar_config['theme_settings']['Suite7']['menufrom']; ?>',GradientType=0 ); /* IE6-8 */
    border-bottom:2px solid #<?php echo $sugar_config['theme_settings']['Suite7']['menubrd']; ?>;
}

h1, h2, h3, h4 {color: #<?php echo $sugar_config['theme_settings']['Suite7']['pageheader']; ?>;}

.email-address-add-button,
.email-address-remove-button,
input[type=button],
input[type=submit],
input[type=reset],
.button {
background: #<?php echo $sugar_config['theme_settings']['Suite7']['button1']; ?>; /* Old browsers */
/* IE9 SVG, needs conditional override of 'filter' to 'none' */
background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iI2ZmZmZmZiIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjUwJSIgc3RvcC1jb2xvcj0iI2YzZjNmMyIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjUxJSIgc3RvcC1jb2xvcj0iI2VkZWRlZCIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiNmZmZmZmYiIHN0b3Atb3BhY2l0eT0iMSIvPgogIDwvbGluZWFyR3JhZGllbnQ+CiAgPHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjEiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+);
background: -moz-linear-gradient(top,  #<?php echo $sugar_config['theme_settings']['Suite7']['buttontop']; ?> 0%,#<?php echo $sugar_config['theme_settings']['Suite7']['buttonmid']; ?> 51%, #<?php echo $sugar_config['theme_settings']['Suite7']['buttonbottom']; ?> 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,<?php echo $sugar_config['theme_settings']['Suite7']['buttontop']; ?>), color-stop(50%,#<?php echo $sugar_config['theme_settings']['Suite7']['buttonmid']; ?>), color-stop(51%,#<?php echo $sugar_config['theme_settings']['Suite7']['buttonbottom']; ?>), color-stop(100%,#<?php echo $sugar_config['theme_settings']['Suite7']['button4']; ?>)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #<?php echo $sugar_config['theme_settings']['Suite7']['buttontop']; ?> 0%,#<?php echo $sugar_config['theme_settings']['Suite7']['buttonmid']; ?> 51%,#<?php echo $sugar_config['theme_settings']['Suite7']['buttonbottom']; ?> 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #<?php echo $sugar_config['theme_settings']['Suite7']['buttontop']; ?> 0%,#<?php echo $sugar_config['theme_settings']['Suite7']['buttonmid']; ?> 51%,#<?php echo $sugar_config['theme_settings']['Suite7']['buttonbottom']; ?> 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #<?php echo $sugar_config['theme_settings']['Suite7']['buttontop']; ?> 0%,#<?php echo $sugar_config['theme_settings']['Suite7']['buttonmid']; ?> 51%,#<?php echo $sugar_config['theme_settings']['Suite7']['buttonbottom']; ?> 100%); /* IE10+ */
background: linear-gradient(to bottom,  #<?php echo $sugar_config['theme_settings']['Suite7']['buttontop']; ?> 0%,#<?php echo $sugar_config['theme_settings']['Suite7']['buttonmid']; ?> 51%,#<?php echo $sugar_config['theme_settings']['Suite7']['buttonbottom']; ?> 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#<?php echo $sugar_config['theme_settings']['Suite7']['buttontop']; ?>', endColorstr='#<?php echo $sugar_config['theme_settings']['Suite7']['buttonbottom']; ?>',GradientType=0 ); /* IE6-8 */
filter:none !important;
}

.email-address-add-button,
.email-address-remove-button,
input[type=button]:hover,
input[type=submit]:hover,
input[type=reset]:hover {
filter:none !important;
background: #<?php echo $sugar_config['theme_settings']['Suite7']['button_hover']; ?>;
border:1px solid #999;
}

.dashletPanel .h3Row {

background: #<?php echo $sugar_config['theme_settings']['Suite7']['dashlet']; ?>;

}

/* Top navigation CSS */

#moduleList ul li a:link {
background:none;
color:#<?php echo $sugar_config['theme_settings']['Suite7']['modlink']; ?>;
}

#moduleList ul li a:visited {
background:none;
color:#<?php echo $sugar_config['theme_settings']['Suite7']['modlink']; ?>;
}

#moduleList ul li:hover {
background:#<?php echo $sugar_config['theme_settings']['Suite7']['modlisthover']; ?>;
}

#moduleList ul li a:hover {
background:none;
color:#<?php echo $sugar_config['theme_settings']['Suite7']['modlinkhover']; ?>;
}

#moduleList ul li ul.cssmenu {
background:#<?php echo $sugar_config['theme_settings']['Suite7']['cssmenu']; ?>;
}

#moduleList ul li ul.cssmenu li a {
color:#<?php echo $sugar_config['theme_settings']['Suite7']['cssmenulink']; ?>;
}



/* popup colors */

.yui-module .hd, .yui-panel .hd {
background-color: #<?php echo $sugar_config['theme_settings']['Suite7']['suggestion_popup_from']; ?>;
background: #<?php echo $sugar_config['theme_settings']['Suite7']['suggestion_popup_from']; ?> none repeat scroll 0 0;
}

/* suggestion box and popup */


#suggestion_box table {
color: #<?php echo $sugar_config['theme_settings']['Suite7']['page_link']; ?>;
}
.qtip-tipped .qtip-titlebar {
    background-color: #<?php echo $sugar_config['theme_settings']['Suite7']['suggestion_popup_from']; ?>;
    background-image: -webkit-gradient(linear,left top,left bottom,from(#<?php echo $sugar_config['theme_settings']['Suite7']['suggestion_popup_from']; ?>),to(#<?php echo $sugar_config['theme_settings']['Suite7']['suggestion_popup_to']; ?>));
    background-image: -webkit-linear-gradient(top,#<?php echo $sugar_config['theme_settings']['Suite7']['suggestion_popup_from']; ?>,#<?php echo $sugar_config['theme_settings']['Suite7']['suggestion_popup_to']; ?>);
}