<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

/**
 * Created by Adam Jakab.
 * Date: 11/03/16
 * Time: 9.16
 */

require_once('modules/Devel/views/DevelView.php');

class DevelViewList extends DevelView
{
    public function __construct($bean = null, $view_object_map = array())
    {
        parent::__construct($bean, $view_object_map);
    }

    /**
     *
     */
    public function display() {
        if(isset($this->view_object_map['stats']) && count($this->view_object_map['stats'])) {
            $this->ss->assign('containerID', 'stats-for-session-'.session_id());
            $this->ss->assign('stats', $this->view_object_map['stats']);
            $contents = $this->ss->fetch('modules/Devel/tpls/listview.tpl');
        } else {
            $contents = '<h3>There are no registered statistics for this session.</h3>';
        }
        echo $contents;
    }
}
