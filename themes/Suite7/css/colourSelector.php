<?php

// config|_override.php
if(is_file('../../../config.php')) {
    require_once('../../../config.php'); // provides $sugar_config
}

// load up the config_override.php file.  This is used to provide default user settings
if(is_file('../../../config_override.php')) {
    require_once('../../../config_override.php');
}

if(!isset($sugar_config['colourselector'])) return;

//set file type back to css from php
header("Content-type: text/css; charset: UTF-8");

?>

/*custom colour css*/

#header {
    background: #<?php echo $sugar_config['colourselector']['menu']; ?>;
    background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iIzMzMzMzMyIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiMxMjEyMTIiIHN0b3Atb3BhY2l0eT0iMSIvPgogIDwvbGluZWFyR3JhZGllbnQ+CiAgPHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjEiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+);
    background: -moz-linear-gradient(top,  #<?php echo $sugar_config['colourselector']['menuto']; ?> 0%, #<?php echo $sugar_config['colourselector']['menufrom']; ?> 100%); /* FF3.6+ */
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#<?php echo $sugar_config['colourselector']['menuto']; ?>), color-stop(100%,#<?php echo $sugar_config['colourselector']['menufrom']; ?>)); /* Chrome,Safari4+ */
    background: -webkit-linear-gradient(top,  #<?php echo $sugar_config['colourselector']['menuto']; ?> 0%,#<?php echo $sugar_config['colourselector']['menufrom']; ?> 100%); /* Chrome10+,Safari5.1+ */
    background: -o-linear-gradient(top,  #<?php echo $sugar_config['colourselector']['menuto']; ?> 0%,#<?php echo $sugar_config['colourselector']['menufrom']; ?> 100%); /* Opera 11.10+ */
    background: -ms-linear-gradient(top,  #<?php echo $sugar_config['colourselector']['menuto']; ?> 0%,#<?php echo $sugar_config['colourselector']['menufrom']; ?> 100%); /* IE10+ */
    background: linear-gradient(to bottom,  #<?php echo $sugar_config['colourselector']['menuto']; ?> 0%,#<?php echo $sugar_config['colourselector']['menufrom']; ?> 100%); /* W3C */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#<?php echo $sugar_config['colourselector']['menuto']; ?>', endColorstr='#<?php echo $sugar_config['colourselector']['menufrom']; ?>',GradientType=0 ); /* IE6-8 */
    border-bottom:2px solid #<?php echo $sugar_config['colourselector']['menubrd']; ?>;
}

h1, h2, h3, h4 {color: #<?php echo $sugar_config['colourselector']['pageheader']; ?>;}

input[type=button],
input[type=submit],
input[type=reset],
.button {
background: #<?php echo $sugar_config['colourselector']['button1']; ?>; /* Old browsers */
/* IE9 SVG, needs conditional override of 'filter' to 'none' */
background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iI2ZmZmZmZiIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjUwJSIgc3RvcC1jb2xvcj0iI2YzZjNmMyIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjUxJSIgc3RvcC1jb2xvcj0iI2VkZWRlZCIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiNmZmZmZmYiIHN0b3Atb3BhY2l0eT0iMSIvPgogIDwvbGluZWFyR3JhZGllbnQ+CiAgPHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjEiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+);
background: -moz-linear-gradient(top,  #<?php echo $sugar_config['colourselector']['button1']; ?> 0%, #<?php echo $sugar_config['colourselector']['button2']; ?> 50%, #<?php echo $sugar_config['colourselector']['button3']; ?> 51%, #<?php echo $sugar_config['colourselector']['button4']; ?> 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,<?php echo $sugar_config['colourselector']['button1']; ?>), color-stop(50%,#<?php echo $sugar_config['colourselector']['button2']; ?>), color-stop(51%,#<?php echo $sugar_config['colourselector']['button3']; ?>), color-stop(100%,#<?php echo $sugar_config['colourselector']['button4']; ?>)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #<?php echo $sugar_config['colourselector']['button1']; ?> 0%,#<?php echo $sugar_config['colourselector']['button2']; ?> 50%,#<?php echo $sugar_config['colourselector']['button3']; ?> 51%,#<?php echo $sugar_config['colourselector']['button4']; ?> 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #<?php echo $sugar_config['colourselector']['button1']; ?> 0%,#<?php echo $sugar_config['colourselector']['button2']; ?> 50%,#<?php echo $sugar_config['colourselector']['button3']; ?> 51%,#<?php echo $sugar_config['colourselector']['button4']; ?> 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #<?php echo $sugar_config['colourselector']['button1']; ?> 0%,#<?php echo $sugar_config['colourselector']['button2']; ?> 50%,#<?php echo $sugar_config['colourselector']['button3']; ?> 51%,#<?php echo $sugar_config['colourselector']['button4']; ?> 100%); /* IE10+ */
background: linear-gradient(to bottom,  #<?php echo $sugar_config['colourselector']['button1']; ?> 0%,#<?php echo $sugar_config['colourselector']['button2']; ?> 50%,#<?php echo $sugar_config['colourselector']['button3']; ?> 51%,#<?php echo $sugar_config['colourselector']['button4']; ?> 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#<?php echo $sugar_config['colourselector']['button1']; ?>', endColorstr='#<?php echo $sugar_config['colourselector']['button3']; ?>',GradientType=0 ); /* IE6-8 */
filter:none !important;
}

input[type=button]:hover,
input[type=submit]:hover,
input[type=reset]:hover {
filter:none !important;
background: #<?php echo $sugar_config['colourselector']['buttonhover']; ?>;
border:1px solid #999;
}

.dashletPanel .h3Row {

background: #<?php echo $sugar_config['colourselector']['dashlet']; ?>;

}

/* Top navigation CSS */

#moduleList ul li a:link {
background:none;
color:#<?php echo $sugar_config['colourselector']['modlink']; ?>;
}

#moduleList ul li a:visited {
background:none;
color:#<?php echo $sugar_config['colourselector']['modlinkvisited']; ?>;
}

#moduleList ul li:hover {
background:#<?php echo $sugar_config['colourselector']['modlisthover']; ?>;
}

#moduleList ul li a:hover {
background:none;
color:#<?php echo $sugar_config['colourselector']['modlinkhover']; ?>;
}

#moduleList ul li ul.cssmenu {
background:#<?php echo $sugar_config['colourselector']['cssmenu']; ?>;
}

#moduleList ul li ul.cssmenu li a {
color:#<?php echo $sugar_config['colourselector']['cssmenulink']; ?>;
}

<?php echo $sugar_config['colourselector']['custom']; ?>