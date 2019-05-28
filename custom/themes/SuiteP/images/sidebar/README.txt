To set the icon in the sidebar action please change the menu.php module name to the action you wish to use.

example

if(ACLController::checkAccess('Accounts', 'edit', true)) {
    $module_menu[]=Array("index.php?module=Accounts&action=EditView&return_module=Accounts&return_action=index", $mod_strings['LNK_NEW_ACCOUNT'],"My_New_Icon", 'Accounts');
}


To add a new icon you need to add it in the sidebar directory and add css style:

#actionMenuSidebar li a.side-bar-My_New_Icon {
    background-image: url("../../../../themes/SuiteP/images/sidebar/side-bar-My_New_Icon.png");
    background-image: url("../../../../themes/SuiteP/images/sidebar/side-bar-My_New_Icon.svg");
}