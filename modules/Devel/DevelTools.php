<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('DevelRequestStats.php');

class DevelTools {
    /** @var DevelRequestStats */
    protected $requestStats;

    /** @var array  */
    protected $bannedModules = ['Devel'];

    /** @var int  */
    protected $maxAllowedRequests = 50;

    public function __construct() {
        if(!$this->checkIfAllowed()) {
            return;
        }
        if(!session_id()) {
            session_start();
        }
        $requestNumber = isset($_SESSION['DevelRequestNumber']) ? (int)$_SESSION['DevelRequestNumber'] : 0;
        $requestNumber++;
        $_SESSION['DevelRequestNumber'] = $requestNumber;
        //
        $this->requestStats = new \DevelRequestStats($requestNumber);
        $GLOBALS['DevelRequestStats'] = $this->requestStats;
        //
        $GLOBALS['DevelTools'] = $this;
    }


    /**
     * Registered as shutdown_function in: custom/Extension/application/Ext/Include/Mekit_Devel.php
     *
     * @param mixed $data
     */
    public function shutdown($data=null) {
        if(!$this->checkIfAllowed()) {
            return;
        }
        $this->requestStats->registerShutdownValues();
        $this->injectDevelTools();
        $this->saveDevelRequestStats();
        $this->removeObsoleteStats();
    }

    /**
     * Save serialized statistics to file
     */
    protected function saveDevelRequestStats() {
        $develStatsFilePath = $this->getDevelRequestStatsFileFullPath();
        if($develStatsFilePath) {
            file_put_contents($develStatsFilePath, serialize($this->requestStats));
        }
    }

    /**
     * @return array
     */
    protected function getToolbarData() {
        $data = [];
        $data['toolbar_open'] = (!isset($_SESSION['DevelToolsToolbarState']) ? false : $_SESSION['DevelToolsToolbarState']);
        $data['request_number'] = $this->requestStats->getRequestNumber();
        $data['total_query_count'] = $this->requestStats->getTotalQueryCount();
        $data['devel_detail_link'] = 'index.php?module=Devel&action=DetailView&request='.$this->requestStats->getRequestNumber();
        $data['execution_length'] = number_format($this->requestStats->getExecutionLength(), 2) . "s";
        $data['memory_usage'] = $this->requestStats->getFormattedMemoryUsage();
        $data['memory_peak_usage'] = $this->requestStats->getFormattedMemoryPeakUsage();
        return $data;
    }

    /**
     * Called by logic_hook: after_ui_footer (custom/modules/logic_hooks.php)
     *
     * @param string $event
     * @param array $arguments
     */
    protected function injectDevelTools($event = null, $arguments = null) {
        $injectJs = '<script type="text/javascript" src="modules/Devel/assets/js/DevelTools.js"></script>';
        $injectCss = '<link rel="stylesheet" type="text/css" href="modules/Devel/assets/css/DevelTools.css" />';

        $develToolbarData = $this->getToolbarData();
        $develToolbarDataJs = '';
        $develToolbarDataJs .= '<script type="text/javascript">';
        $develToolbarDataJs .= 'SUGAR.config.develToolbar = ' . json_encode($develToolbarData) . ';';
        $develToolbarDataJs .= '</script>';

        $html = ob_get_clean();
        $html = str_replace('</body>', $injectJs . '</body>', $html);
        $html = str_replace('</head>', $injectCss . '</head>', $html);
        $html = str_replace('</head>', $develToolbarDataJs . '</head>', $html);
        echo $html;
    }


    /**
     * @return array
     */
    public function getRegisteredStatisticsRequests() {
        $answer = [];
        $session_id = session_id();
        $cachePath = $this->getDevelRequestStatsFileCachePath($session_id);
        $files = glob($cachePath.'/*.ser');
        foreach($files as $filename) {
            $filename = str_replace([$cachePath.'/','.ser'], '', $filename);
            $answer[] = (int)$filename;
        }
        if($this->requestStats && !in_array($this->requestStats->getRequestNumber(), $answer)) {
            $answer[] = (int)$this->requestStats->getRequestNumber();
        }
        sort($answer);
        return $answer;
    }

    /**
     * @param string $requestNumber
     * @return bool|\DevelRequestStats
     */
    public function getDevelRequestStatsForRequest($requestNumber) {
        $answer = false;
        $develStatsFilePath = $this->getDevelRequestStatsFileFullPath($requestNumber);
        if($develStatsFilePath) {
            /** @var \DevelRequestStats $stat */
            $stat = @unserialize(@file_get_contents($develStatsFilePath));
            if($stat instanceof \DevelRequestStats) {
                $answer = $stat;
            }
        }
        return $answer;
    }

    /**
     * @param null|string $requestNumber
     * @return bool|string
     */
    public function getDevelRequestStatsFileFullPath($requestNumber=null) {
        $answer = false;
        $session_id = session_id();
        $cachePath = $this->getDevelRequestStatsFileCachePath($session_id);
        if($cachePath) {
            $requestNumber = $requestNumber ? $requestNumber : $this->requestStats->getRequestNumber();
            if($requestNumber) {
                $answer = $cachePath . '/' . str_pad($requestNumber, 10, '0', STR_PAD_LEFT) . '.ser';
            }
        }
        return $answer;
    }

    /**
     * @param string $session_id
     * @return bool|string
     */
    protected function getDevelRequestStatsFileCachePath($session_id) {
        $answer = false;
        $cachePath = realpath(__DIR__ . '/../../cache');
        if($cachePath) {
            $cachePath = $cachePath . '/develStats/'.$session_id;
            if(!is_dir($cachePath)) {
                mkdir($cachePath, 0777, true);
            }
            $cachePath = realpath($cachePath);
            if($cachePath) {
                $answer = $cachePath;
            }
        }
        return $answer;
    }

    /**
     * Removes old statistics files (needs configurable option)
     */
    protected function removeObsoleteStats() {
        $requestNumbers = $this->getRegisteredStatisticsRequests();
        if(count($requestNumbers) > $this->maxAllowedRequests) {
            $numDelete = count($requestNumbers) - $this->maxAllowedRequests;
            $elementsToDelete = array_slice($requestNumbers, 0, $numDelete);
            if(count($elementsToDelete)) {
                foreach($elementsToDelete as $requestNumber) {
                    $develStatsFilePath = $this->getDevelRequestStatsFileFullPath($requestNumber);
                    @unlink($develStatsFilePath);
                }
            }
        }
    }

    /**
     * @return bool
     */
    protected function checkIfAllowed() {
        $answer = $this->checkIfEnabled();
        if(isset($_REQUEST['to_pdf'])) {
            $answer = false;
        }
        if(isset($_REQUEST['sugar_body_only'])) {
            //$answer = false;
        }
        if(isset($_REQUEST['module']) && in_array($_REQUEST['module'], $this->bannedModules)) {
            $answer = false;
        }
        if(!preg_match('#\/index\.php#', trim($_SERVER['REQUEST_URI']))) {
            $answer = false;
        }
        return $answer;
    }

    /**
     * This is static so that we can check if enabled before creating an instance
     * @return bool
     */
    public static function checkIfEnabled() {
        if(!session_id()) {
            session_start();
        }
        return isset($_SESSION['devel_tools_enabled']) && $_SESSION['devel_tools_enabled'];
    }
}
