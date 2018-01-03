<?php
require_once('include/ListView/ListViewSmarty.php');
require_once('modules/AOS_PDF_Templates/formLetter.php');


/**
 * Class ContactsListViewSmarty
 */
class ContactsListViewSmarty extends ListViewSmarty
{

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8,
     *     please update your code, use __construct instead
     */
    public function ContactsListViewSmarty()
    {
        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, ' .
            'please update your code';
        if (isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        } else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct();
    }

    /**
     * ContactsListViewSmarty constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->targetList = true;
    }

    /**
     * @param $file
     * @param $data
     * @param $htmlVar
     * @return bool|void
     */
    public function process($file, $data, $htmlVar)
    {
        parent::process($file, $data, $htmlVar);

        if (!ACLController::checkAccess($this->seed->module_dir, 'export', true) || !$this->export) {
            $this->ss->assign('exportLink', $this->buildExportLink());
        }
    }

    /**
     * @param string $id
     * @return string
     */
    public function buildExportLink($id = 'export_link')
    {
        global $app_strings;

        $script = "";
        if (ACLController::checkAccess($this->seed->module_dir, 'export', true)) {
            if ($this->export) {
                $script = parent::buildExportLink($id);
            }
        }

        $script .= "<a href='javascript:void(0)' id='map_listview_top' " .
            " onclick=\"return sListView.send_form(true, 'jjwg_Maps', " .
            "'index.php?entryPoint=jjwg_Maps&display_module={$_REQUEST['module']}', " .
            "'{$app_strings['LBL_LISTVIEW_NO_SELECTED']}')\">{$app_strings['LBL_MAP']}</a>";

        return formLetter::LVSmarty() . $script;
    }
}
