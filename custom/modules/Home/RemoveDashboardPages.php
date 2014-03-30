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

    if (!isset($_POST['status'])) {
        $html = "<form method='post' name='removepageform' action='index.php?module=Home&action=RemoveDashboardPages'/>";
        $html .= "<p>".$GLOBALS['app_strings']['LBL_DELETE_DASHBOARD1']." ".$pages[$_POST['page_id']]['pageTitle'] . " ".$GLOBALS['app_strings']['LBL_DELETE_DASHBOARD2']."</p>";
        $html .= "<input type='hidden' name='page_id' value='" . $_POST['page_id']. "' />";
        $html .= "<input type='hidden' name='status' value='yes' />";
        $html .= "</form>";

        echo $html;

    } else {

        unset($pages[$_POST['page_id']]);

        $pages = array_values($pages);

        $current_user->setPreference('pages', $pages, 0, $type);

        $queryParams = array(
            'module' => 'Home',
            'action' => 'index',
        );

        $sa = new SugarApplication();
        $sa->redirect('index.php?' . http_build_query($queryParams));

    }

}
