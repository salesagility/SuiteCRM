<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

/**
 * Created by Adam Jakab.
 * Date: 11/03/16
 * Time: 9.16
 */
class DevelController extends SugarController
{
    /** @var  \DevelTools */
    protected $develTools;

    /** @var \DevelRequestStats */
    public $bean;

    public function __construct() {
        if(isset($GLOBALS['DevelTools']) && $GLOBALS['DevelTools'] instanceof \DevelTools) {
            $this->develTools = $GLOBALS['DevelTools'];
        }
    }

    /**
     * @return bool
     */
    protected function checkIfDevelToolsISEnabled() {
        $enabled = $this->develTools instanceof \DevelTools;
        if(!$enabled) {
            print '<div class="alert alert-warning" role="alert">Devel Tools is not enabled!</div>';
        }
        return $enabled;
    }

    public function action_configure()
    {
        if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
            if(isset($_POST['devel-tools-enabled']) && $_POST['devel-tools-enabled']) {
                $_SESSION['devel_tools_enabled'] = true;
            } else {
                $_SESSION['devel_tools_enabled'] = false;
            }
        }
        $this->view = 'configure';
        $this->view_object_map['enabled'] = \DevelTools::checkIfEnabled();
    }

    public function action_listview()
    {
        if(!$this->checkIfDevelToolsISEnabled()) {
            return;
        }
        parent::action_listview();
        $this->view = 'list';
        $develRequestsStats = [];
        $requests = $this->develTools->getRegisteredStatisticsRequests();
        rsort($requests);
        foreach($requests as $requestNumber) {
            $stat = $this->develTools->getDevelRequestStatsForRequest($requestNumber);
            if($stat) {
                $develRequestsStats[] = [
                    'number' => $stat->getRequestNumber(),
                    'module' => $stat->getModule(),
                    'action' => $stat->getAction(),
                    'method' => $stat->getRequestMethod(),
                    'exec_length' => number_format($stat->getExecutionLength(), 2) . "s",
                    'memory_usage' => $stat->getFormattedMemoryUsage(),
                    'query_count' => $stat->getTotalQueryCount(),
                    'exec_date' => $stat->getFormattedExecutionTime()
                ];
            }
        }
        $this->view_object_map['stats'] = $develRequestsStats;
    }

    public function action_detailview()
    {
        if(!$this->checkIfDevelToolsISEnabled()) {
            return;
        }
        $this->view = 'detail';
        $requestNumber = (isset($_GET['request']) && !empty($_GET['request'])) ? $_GET['request'] : false;
        if(!$requestNumber) {
            sugar_die("Undefined request number!");
        }
        $stat = $this->develTools->getDevelRequestStatsForRequest($requestNumber);
        if(!$stat) {
            sugar_die("Unable to get statistics for request number $requestNumber!");
        }
        $this->bean = $stat;
    }


    /**
     * Register Devel Toolbar state
     */
    public function action_develToolbarToggleOpenClosedState() {
        if(!isset($_SESSION['DevelToolsToolbarState'])) {
            $_SESSION['DevelToolsToolbarState'] = true;
        } else {
            $_SESSION['DevelToolsToolbarState'] = !$_SESSION['DevelToolsToolbarState'];
        }
        $response = [
            'state' => $_SESSION['DevelToolsToolbarState']
        ];
        ob_end_clean();
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }


}