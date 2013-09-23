<?php

require_once('include/ListView/ListViewSmarty.php');

// custom/modules/Prospects/ProspectsListViewSmarty.php

class ProspectsListViewSmarty extends ListViewSmarty {

    function ProspectsListViewSmarty() {

        parent::ListViewSmarty();
    }

    function buildExportLink($id = 'export_link') {

        global $app_strings;
        global $sugar_config;

        if (preg_match('/^6\.[2-4]/', $sugar_config['sugar_version'])) { // Older v6.2-6.4

            $script = "<a href='#' style='width: 150px' class='menuItem' onmouseover='hiliteItem(this,\"yes\");' " .
                    "onmouseout='unhiliteItem(this);' onclick=\"return sListView.send_form(true, '{$_REQUEST['module']}', " .
                    "'index.php?entryPoint=export','{$app_strings['LBL_LISTVIEW_NO_SELECTED']}')\">{$app_strings['LBL_EXPORT']}</a>" .
                    "<a href='#' style='width: 150px' class='menuItem' onmouseover='hiliteItem(this,\"yes\");' " .
                    "onmouseout='unhiliteItem(this);' onclick=\"return sListView.send_form(true, 'jjwg_Maps', " .
                    "'index.php?entryPoint=jjwg_Maps&display_module={$_REQUEST['module']}', " .
                    "'{$app_strings['LBL_LISTVIEW_NO_SELECTED']}')\">{$app_strings['LBL_MAP']}</a>";
                    
        } else { // Newer v6.5+
            
            $script = "<a href='javascript:void(0)' id='export_listview_top' ".
                    "onclick=\"return sListView.send_form(true, '{$_REQUEST['module']}', " .
                    "'index.php?entryPoint=export', " . 
                    "'{$app_strings['LBL_LISTVIEW_NO_SELECTED']}')\">{$app_strings['LBL_EXPORT']}</a>" .
                    "</li><li>". // List item hack
                    "<a href='javascript:void(0)' id='map_listview_top' " .
                    " onclick=\"return sListView.send_form(true, 'jjwg_Maps', " .
                    "'index.php?entryPoint=jjwg_Maps&display_module={$_REQUEST['module']}', " .
                    "'{$app_strings['LBL_LISTVIEW_NO_SELECTED']}')\">{$app_strings['LBL_MAP']}</a>";
        }

        return $script;
    }

}

?>