<?php
/**
 * This file is part of SinergiaCRM.
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 */
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

global $current_user, $sugar_version, $sugar_config, $beanFiles;

require_once('include/MySugar/MySugar.php');

// build dashlet cache file if not found
if (!is_file($cachefile = sugar_cached('dashlets/dashlets.php'))) {
    require_once('include/Dashlets/DashletCacheBuilder.php');

    $dc = new DashletCacheBuilder();
    $dc->buildCache();
}
require_once $cachefile;

require('modules/Home/dashlets.php');

$pages = $current_user->getPreference('pages', 'Home');
$dashlets = $current_user->getPreference('dashlets', 'Home');

$defaultHomepage = false;
// BEGIN fill in with default homepage and dashlet selections

$hasUserPreferences = (!isset($pages) || empty($pages) || !isset($dashlets) || empty($dashlets)) ? false : true;

if (!$hasUserPreferences) {
    $dashlets = array();

    //list of preferences to move over and to where
    $prefstomove = array(
        'mypbss_date_start' => 'MyPipelineBySalesStageDashlet',
        'mypbss_date_end' => 'MyPipelineBySalesStageDashlet',
        'mypbss_sales_stages' => 'MyPipelineBySalesStageDashlet',
        'mypbss_chart_type' => 'MyPipelineBySalesStageDashlet',
        'lsbo_lead_sources' => 'OpportunitiesByLeadSourceByOutcomeDashlet',
        'lsbo_ids' => 'OpportunitiesByLeadSourceByOutcomeDashlet',
        'pbls_lead_sources' => 'OpportunitiesByLeadSourceDashlet',
        'pbls_ids' => 'OpportunitiesByLeadSourceDashlet',
        'pbss_date_start' => 'PipelineBySalesStageDashlet',
        'pbss_date_end' => 'PipelineBySalesStageDashlet',
        'pbss_sales_stages' => 'PipelineBySalesStageDashlet',
        'pbss_chart_type' => 'PipelineBySalesStageDashlet',
        'obm_date_start' => 'OutcomeByMonthDashlet',
        'obm_date_end' => 'OutcomeByMonthDashlet',
        'obm_ids' => 'OutcomeByMonthDashlet');

    //upgrading from pre-5.0 homepage
    $old_columns = $current_user->getPreference('columns', 'home');
    $old_dashlets = $current_user->getPreference('dashlets', 'home');

    if (isset($old_columns) && !empty($old_columns) && isset($old_dashlets) && !empty($old_dashlets)) {
        $columns = $old_columns;
        $dashlets = $old_dashlets;

        // resetting old columns and dashlets to have no preference and data
        $old_columns = array();
        $old_dashlets = array();
        $current_user->setPreference('columns', $old_columns, 0, 'home');
        $current_user->setPreference('dashlets', $old_dashlets, 0, 'home');
    } else {
        // STIC 2020/08/14 https://github.com/salesagility/SuiteCRM/issues/8848: 
        // - Removing default SugarFeed dashlet
        // - Customizing the function to retrieve the default dashlets and assigning a default column number

        // This is here to get Sugar dashlets added above the rest
        // $dashlets[create_guid()] = array('className' => 'SugarFeedDashlet',
        //     'module' => 'SugarFeed',
        //     'forceColumn' => 1,
        //     'fileLocation' => $dashletsFiles['SugarFeedDashlet']['file'],
        // );

	    foreach($defaultDashlets as $dashletName=>$dashletData){
			// clint - fixes bug #20398
			// only display dashlets that are from visibile modules and that the user has permission to list
			$myDashlet = new MySugar($dashletData['module']);
			$displayDashlet = $myDashlet->checkDashletDisplay();
	    	if (isset($dashletsFiles[$dashletName]) && $displayDashlet){
	        	$options = array();
               $prefsforthisdashlet = array_keys($prefstomove,$dashletName);
               foreach ( $prefsforthisdashlet as $pref ) {
                   $options[$pref] = $current_user->getPreference($pref);
               }
                $dashlets[create_guid()] = array('className' => $dashletName,
												 'module' => $dashletData['module'],
	            	                             'forceColumn' => $dashletData['column'],
	            	                             'fileLocation' => $dashletsFiles[$dashletName]['file'],
                                                 'options' => $options);
	    	}
	    }
        // STIC: End of customization

        $count = 0;
        $columns = array();
        $columns[0] = array();
        $columns[0]['width'] = '60%';
        $columns[0]['dashlets'] = array();
        $columns[1] = array();
        $columns[1]['width'] = '40%';
        $columns[1]['dashlets'] = array();

        foreach ($dashlets as $guid=>$dashlet) {
            if ($dashlet['forceColumn'] == 0) {
                array_push($columns[0]['dashlets'], $guid);
            } else {
                array_push($columns[1]['dashlets'], $guid);
            }
            $count++;
        }
    }




    $current_user->setPreference('dashlets', $dashlets, 0, 'Home');
}

// handles upgrading from versions that had the 'Dashboard' module; move those items over to the Home page
$pagesDashboard = $current_user->getPreference('pages', 'Dashboard');
$dashletsDashboard = $current_user->getPreference('dashlets', 'Dashboard');
if (!empty($pagesDashboard)) {
    // move dashlets from the dashboard to be at the end of the home screen dashlets
    foreach ($pagesDashboard[0]['columns'] as $dashboardColumnKey => $dashboardColumn) {
        foreach ($dashboardColumn['dashlets'] as $dashletItem) {
            $pages[0]['columns'][$dashboardColumnKey]['dashlets'][] = $dashletItem;
        }
    }
    $pages = array_merge($pages, $pagesDashboard);
    $current_user->setPreference('pages', $pages, 0, 'Home');
}
if (!empty($dashletsDashboard)) {
    $dashlets = array_merge($dashlets, $dashletsDashboard);
    $current_user->setPreference('dashlets', $dashlets, 0, 'Home');
}
if (!empty($pagesDashboard) || !empty($dashletsDashboard)) {
    $current_user->resetPreferences('Dashboard');
}

if (empty($pages)) {
    $pages = array();
    $pageIndex = 0;
    $pages[0]['columns'] = $columns;
    $pages[0]['numColumns'] = '3';
    $pages[0]['pageTitleLabel'] = 'LBL_HOME_PAGE_1_NAME';	// "My Sugar"
    $pageIndex++;
    $current_user->setPreference('pages', $pages, 0, 'Home');
    $activePage = 0;
}

$sugar_smarty = new Sugar_Smarty();

$activePage = 0;

$divPages[] = $activePage;

$numCols = $pages[$activePage]['numColumns'];


$count = 0;
$dashletIds = array(); // collect ids to pass to javascript
$display = array();

foreach ($pages[$activePage]['columns'] as $colNum => $column) {
    if ($colNum == $numCols) {
        break;
    }
    $display[$colNum]['width'] = $column['width'];
    $display[$colNum]['dashlets'] = array();
    foreach ($column['dashlets'] as $num => $id) {
        // clint - fixes bug #20398
        // only display dashlets that are from visibile modules and that the user has permission to list
        if (!empty($id) && isset($dashlets[$id]) && is_file($dashlets[$id]['fileLocation'])) {
            $module = 'Home';
            if (!empty($dashletsFiles[$dashlets[$id]['className']]['module'])) {
                $module = $dashletsFiles[$dashlets[$id]['className']]['module'];
            }
            // Bug 24772 - Look into the user preference for the module the dashlet is a part of in case
            //             of the Report Chart dashlets.
            elseif (!empty($dashlets[$id]['module'])) {
                $module = $dashlets[$id]['module'];
            }

            $myDashlet = new MySugar($module);

            if ($myDashlet->checkDashletDisplay()) {
                require_once($dashlets[$id]['fileLocation']);


                $dashlet = new $dashlets[$id]['className']($id, (isset($dashlets[$id]['options']) ? $dashlets[$id]['options'] : array()));
                // Need to add support to dynamically display/hide dashlets
                // If it has a method 'shouldDisplay' we will call it to see if we should display it or not
                if (method_exists($dashlet, 'shouldDisplay')) {
                    if (!$dashlet->shouldDisplay()) {
                        // This dashlet doesn't want us to show it, skip it.
                        continue;
                    }
                }

                array_push($dashletIds, $id);

                $dashlets = $current_user->getPreference('dashlets', 'Home'); // Using hardcoded 'Home' because DynamicAction.php $_REQUEST['module'] value is always Home
                $lvsParams = array();
                if (!empty($dashlets[$id]['sort_options'])) {
                    $lvsParams = $dashlets[$id]['sort_options'];
                }

                $dashlet->process($lvsParams);
                try {
                    $display[$colNum]['dashlets'][$id]['display'] = $dashlet->display();
                    $display[$colNum]['dashlets'][$id]['displayHeader'] = $dashlet->getHeader();
                    $display[$colNum]['dashlets'][$id]['displayFooter'] = $dashlet->getFooter();
                    if ($dashlet->hasScript) {
                        $display[$colNum]['dashlets'][$id]['script'] = $dashlet->displayScript();
                    }
                } catch (Exception $ex) {
                    $display[$colNum]['dashlets'][$id]['display'] = $ex->getMessage();
                    $display[$colNum]['dashlets'][$id]['displayHeader'] = $dashlet->getHeader();
                    $display[$colNum]['dashlets'][$id]['displayFooter'] = $dashlet->getFooter();
                }
            }
        }
    }
}


$i = 0;
    while ($i < count($pages)) {
        if ($i == 0) {
            $pageTabs[$i]['pageTitle'] = $GLOBALS['app_strings']['LBL_SUITE_DASHBOARD'];
//            $pageTabs[$i]['active'] = 'current';
        } else {
            $pageTabs[$i]['pageTitle'] = $pages[$i]['pageTitle'];
            $divPages[] = $i;
        }
        $i++;
    }

if (!empty($sugar_config['lock_homepage']) && $sugar_config['lock_homepage'] == true) {
    $sugar_smarty->assign('lock_homepage', true);
}

$dashboardActions = $GLOBALS['app_strings']['LBL_SUITE_DASHBOARD_ACTIONS'];

$sugar_smarty->assign('sugarVersion', $sugar_version);
$sugar_smarty->assign('sugarFlavor', $sugar_flavor);
$sugar_smarty->assign('currentLanguage', $GLOBALS['current_language']);
$sugar_smarty->assign('serverUniqueKey', $GLOBALS['server_unique_key']);
$sugar_smarty->assign('imagePath', $GLOBALS['image_path']);

$sugar_smarty->assign('maxCount', empty($sugar_config['max_dashlets_homepage']) ? 15 : $sugar_config['max_dashlets_homepage']);
$sugar_smarty->assign('dashletCount', $count);
$sugar_smarty->assign('dashletIds', '["' . implode('","', $dashletIds) . '"]');
$sugar_smarty->assign('columns', $display);

global $theme;
$sugar_smarty->assign('theme', $theme);

$sugar_smarty->assign('divPages', $divPages);
$sugar_smarty->assign('activePage', $activePage);
$sugar_smarty->assign('dashboardPages', $pageTabs);
$sugar_smarty->assign('dashboardActions', $dashboardActions);
$sugar_smarty->assign('current_user', $current_user->id);

$sugar_smarty->assign('lblAdd', $GLOBALS['app_strings']['LBL_ADD_BUTTON']);
$sugar_smarty->assign('lblAddTab', $GLOBALS['app_strings']['LBL_ADD_TAB']);
$sugar_smarty->assign('lblAddDashlets', $GLOBALS['app_strings']['LBL_ADD_DASHLETS']);
$sugar_smarty->assign('lblLnkHelp', $GLOBALS['app_strings']['LNK_HELP']);

$sugar_smarty->assign('mod', return_module_language($GLOBALS['current_language'], 'Home'));
$sugar_smarty->assign('app', $GLOBALS['app_strings']);
$sugar_smarty->assign('module', 'Home');

//custom chart code
//Get the RGraph libraries (add this more elegantly later to check exactly what is needed, not just all).
require_once('include/SuiteGraphs/RGraphIncludes.php');

require_once('include/SugarCharts/SugarChartFactory.php');
$sugarChart = SugarChartFactory::getInstance();
if ($sugarChart) {
    $resources = $sugarChart->getChartResources();
    $mySugarResources = $sugarChart->getMySugarChartResources();
    $sugar_smarty->assign('chartResources', $resources);
    $sugar_smarty->assign('mySugarChartResources', $mySugarResources);
}

if (file_exists('custom/themes/' . $theme . '/tpls/MySugar.tpl')) {
    echo $sugar_smarty->fetch('custom/themes/' . $theme . '/tpls/MySugar.tpl');
} elseif (file_exists('custom/include/MySugar/tpls/MySugar.tpl')) {
    echo $sugar_smarty->fetch('custom/include/MySugar/tpls/MySugar.tpl');
} elseif (file_exists('themes/' . $theme . '/tpls/MySugar.tpl')) {
    echo $sugar_smarty->fetch('themes/' . $theme . '/tpls/MySugar.tpl');
} elseif (file_exists('include/MySugar/tpls/MySugar.tpl')) {
    echo $sugar_smarty->fetch('include/MySugar/tpls/MySugar.tpl');
} elseif (file_exists('custom/themes/' . $theme . '/include/MySugar/tpls/MySugar.tpl')) {
    echo $sugar_smarty->fetch('custom/themes/' . $theme . '/include/MySugar/tpls/MySugar.tpl');
} else {
    $GLOBALS['log']->fatal('MySugar.tpl not found');
}


//init the quickEdit listeners after the dashlets have loaded on home page the first time
echo"<script>if(typeof(qe_init) != 'undefined'){qe_init();}</script>";
echo"<script> $( '#pageNum_'+ 0 +'_anchor').addClass( 'current' );</script>";
echo"<script> $( '#pageNum_'+ 0).addClass( 'active' );</script>";
