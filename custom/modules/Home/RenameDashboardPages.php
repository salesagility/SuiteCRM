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
        $html .= "<form method='post' name='removepageform' action='index.php?module=Home&action=RenameDashboardPages'/>";
        $html .= "<table>";
        $html .= "<tr>";
        $html .= "<td><label for='dashName'>Rename Dashboard: </label></td>";
        $html .= "<td><input name='dashName' id='dashName' value='" .$pages[$_POST['page_id']]['pageTitle'] ."'/></td>";
        $html .= "<input type='hidden' name='page_id' value='" . $_POST['page_id']. "' />";
        $html .= "</tr>";
        $html .= "</table>";
        $html .="</form>";

        echo $html;

    } else {

        $pages[$_POST['page_id']]['pageTitle'] = $_POST['dashName'];

        $current_user->setPreference('pages', $pages, 0, $type);

        $queryParams = array(
            'module' => 'Home',
            'action' => 'index',
        );

        $sa = new SugarApplication();
        $sa->redirect('index.php?' . http_build_query($queryParams));

    }

}
