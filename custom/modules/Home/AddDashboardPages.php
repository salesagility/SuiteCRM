<?php
/**
 * Created by PhpStorm.
 * User: lewis
 * Date: 17/02/14
 * Time: 13:49
 */


global $current_user;


if(!isset($_POST['dashName'])){
    $html = "<form method='post' name='addpageform' id='addpageform' action='index.php?module=Home&action=AddDashboardPages'/>";
    $html .= "<table>";
    $html .= "<tr>";
    $html .= "<td><label for='dashName'>".$GLOBALS['app_strings']['LBL_ENTER_DASHBOARD_NAME']."</label></td>";
    $html .= "<td><input name='dashName' id='dashName'/></td>";
    $html .= "</tr>";
    $html .= "<tr>";
    $html .= "<td><label for='numColumns'>".$GLOBALS['app_strings']['LBL_NUMBER_OF_COLUMNS']." </label></td>";
    $html .= "<td><select name='numColumns'>";
    $html .= "<option value='1'>1</option>";
    $html .= "<option value='2'>2</option>";
    $html .= "<option value='3'>3</option>";
    $html .="</select></td>";
    $html .="</tr>";
    $html .= "<td></td>";
    $html .= "</tr></table>";
    $html .="</form>";

    echo $html;
}else{
    $type = 'Home';

    $existingPages = $current_user->getPreference('pages',$type);
    $dashboardPage = array();
    $numberColumns = $_POST['numColumns'];
    $pageName = $_POST['dashName'];

    switch ($numberColumns) {
        case 1:
            $pagecolumns[0] = array();
            $pagecolumns[0]['dashlets'] = array();
            $pagecolumns[0]['width'] = '100%';
            break;
        case 2:
            $pagecolumns[0] = array();
            $pagecolumns[0]['dashlets'] = array();
            $pagecolumns[0]['width'] = '60%';
            $pagecolumns[1] = array();
            $pagecolumns[1]['dashlets'] = array();
            $pagecolumns[1]['width'] = '40%';
            break;
        case 3:
            $pagecolumns[0] = array();
            $pagecolumns[0]['dashlets'] = array();
            $pagecolumns[0]['width'] = '30%';
            $pagecolumns[1] = array();
            $pagecolumns[1]['dashlets'] = array();
            $pagecolumns[1]['width'] = '30%';
            $pagecolumns[2] = array();
            $pagecolumns[2]['dashlets'] = array();
            $pagecolumns[2]['width'] = '30%';
            break;
    }

    $dashboardPage['columns'] = $pagecolumns;
    $dashboardPage['pageTitle'] = $pageName;
    $dashboardPage['numColumns'] = $numberColumns;

    array_push($existingPages,$dashboardPage);

    $current_user->setPreference('pages', $existingPages, 0, $type);

    $display = array();

    foreach($dashboardPage['columns'] as $colNum => $column)
        $display[$colNum]['width'] = $column['width'];

    $home_mod_strings = return_module_language($current_language, $type);

    $sugar_smarty = new Sugar_Smarty();
    $sugar_smarty->assign('columns', $display);
    $sugar_smarty->assign('selectedPage', sizeof($pages) - 1);
    $sugar_smarty->assign('mod',$home_mod_strings);
    $sugar_smarty->assign('app',$GLOBALS['app_strings']);
    $sugar_smarty->assign('lblAddDashlets', $home_mod_strings['LBL_ADD_DASHLETS']);
    $sugar_smarty->assign('numCols', $dashboardPage['numColumns']);

}
