<?php
/**
 * Created by PhpStorm.
 * User: lewis
 * Date: 17/02/14
 * Time: 13:49
 */


global $current_user;
$type = 'Home';
$pages = $current_user->getPreference('pages', $type);


if (count($pages) > 1) {

    if (!isset($_POST['dashName'])) {
        $html = "<form method='post' name='removepageform'/>";
        $html .= "<table>";
        $html .= "<tr>";
        $html .= "<td><label for='dashName'>".$GLOBALS['app_strings']['LBL_ENTER_DASHBOARD_NAME']." </label></td>";
        $html .= "<td><input name='dashName' id='dashName' value='" .$pages[$_POST['page_id']]['pageTitle'] ."'/></td>";
        $html .= "<input type='hidden' id='page_id' name='page_id' value='" . $_POST['page_id']. "' />";
        $html .= "</tr>";
        $html .= "</table>";
        $html .="</form>";

        echo $html;

    } else {

        $pages[$_POST['page_id']]['pageTitle'] = $_POST['dashName'];

        $current_user->setPreference('pages', $pages, 0, $type);

        $return_params = array(
            'dashName' => $pages[$_POST['page_id']]['pageTitle'],
            'page_id' => $_POST['page_id'],
        );

       $return_params = json_encode($return_params,true);

       echo $return_params;
    }

}
