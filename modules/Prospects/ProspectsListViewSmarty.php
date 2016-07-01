<?php

require_once('include/ListView/ListViewSmarty.php');

class ProspectsListViewSmarty extends ListViewSmarty {

    function __construct() {

        parent::__construct();
    }

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    function ProspectsListViewSmarty(){
        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code';
        if(isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        }
        else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct();
    }


    function buildExportLink($id = 'export_link') {

        global $app_strings;

        $script = "<a href='javascript:void(0)' id='export_listview_top' ".
                "onclick=\"return sListView.send_form(true, '{$_REQUEST['module']}', " .
                "'index.php?entryPoint=export', " .
                "'{$app_strings['LBL_LISTVIEW_NO_SELECTED']}')\">{$app_strings['LBL_EXPORT']}</a>" .
                "</li><li>". // List item hack
                "<a href='javascript:void(0)' id='map_listview_top' " .
                " onclick=\"return sListView.send_form(true, 'jjwg_Maps', " .
                "'index.php?entryPoint=jjwg_Maps&display_module={$_REQUEST['module']}', " .
                "'{$app_strings['LBL_LISTVIEW_NO_SELECTED']}')\">{$app_strings['LBL_MAP']}</a>";

        return $script;
    }

}

?>