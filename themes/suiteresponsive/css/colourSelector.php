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

/* Header CSS */

h1, h2, h3, h4 {
color: #<?php echo $sugar_config['colourselector']['pageheader']; ?>;

}

/* Pagelink CSS */

a, a:link, a:visited{
color: #<?php echo $sugar_config['colourselector']['pagelink']; ?>;
}

/* Dashlet CSS */

.dashletPanel .h3Row{

background: #<?php echo $sugar_config['colourselector']['dashlet']; ?>;

}

/* Top navigation bar CSS */

.navbar-inverse {
    background:#<?php echo $sugar_config['colourselector']['navbar'];?> !important;
}

.headerlinks a:link, .headerlinks a:visited, .navbar-inverse .navbar-brand, .moremenu a, {
background:none;
color:#<?php echo $sugar_config['colourselector']['navbarfont']; ?>;
}

@media(max-width:979px){
ul.navbar-nav li a,.navbar-inverse .navbar-nav .open .dropdown-menu > li > a, .moremenu ul li a {
color:#<?php echo $sugar_config['colourselector']['navbarfont']; ?>; !important;
}
}

ul.topnav li:hover, .dropdown-menu li a:hover, li#usermenu:hover, .moremenu ul li:hover,ul.navbar-nav li:hover, .bigmenu li a:hover  {
background:#<?php echo $sugar_config['colourselector']['navbarlihover']; ?> !important;
}

.headerlinks a:hover, .navbar-inverse .navbar-brand:hover, .moremenu a:hover {
color:#<?php echo $sugar_config['colourselector']['navbarlinkhover']; ?>;
}

/* Drop down menu CSS */

.dropdown-menu {
background:#<?php echo $sugar_config['colourselector']['dropdownmenu']; ?>;
}

.dropdown-menu li a, .dropdown-menu em a, #moremenu ul li a {
color:#<?php echo $sugar_config['colourselector']['dropdownmenulink']; ?>;
}

/* Button and action menu CSS */

.btn, .btn-success, .btn-primary, .button, input[type=submit], input[type=button], a#create_link.utilsLink, .btn-group a, ul.clickMenu>li, ul.SugarActionMenuIESub li, ul.SugarActionMenuIESub li a,
ul.clickMenu li a, .list tr.pagination td.buttons ul.clickMenu > li > a:link, .list tr.pagination td.buttons ul.clickMenu > li > a {
    background:#<?php echo $sugar_config['colourselector']['button1']; ?>;
    color:#<?php echo $sugar_config['colourselector']['buttoncolour']; ?>;
}

.btn:hover, .btn-success:hover, .btn-primary:hover, .button:hover, input[type=submit]:hover, input[type=button]:hover, a#create_link.utilsLink:hover, .btn-group a:hover, #globalLinksModule ul.clickMenu.SugarActionMenu li a:hover,
#globalLinksModule ul.clickMenu li:hover span,
ul.SugarActionMenuIESub li a:hover, ul.clickMenu.SugarActionMenu li a:hover, ul.clickMenu.SugarActionMenu li span.subhover:hover,
ul#globalLinksSubnav li a:hover, ul#quickCreateULSubnav li a:hover,
ul.clickMenu li ul.subnav li a:hover,ul.clickMenu li ul.subnav li input:hover, ul.clickMenu.subpanel.records li ul.subnav li a:hover, ul.clickMenu ul.subnav-sub li a:hover {
    background:#<?php echo $sugar_config['colourselector']['buttonhover']; ?>;
    color:#<?php echo $sugar_config['colourselector']['buttoncolourhover']; ?>;
}