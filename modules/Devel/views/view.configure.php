<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

/**
 * Created by Adam Jakab.
 * Date: 11/03/16
 * Time: 9.16
 */

require_once('modules/Devel/views/DevelView.php');

class DevelViewConfigure extends DevelView
{
    public function __construct($bean = null, $view_object_map = array())
    {
        parent::__construct($bean, $view_object_map);
    }

    public function display() {
        $this->ss->assign('devel_tool_checked', ($this->view_object_map['enabled'] ? 'checked' : ''));
        $contents = $this->ss->fetch('modules/Devel/tpls/configureview.tpl');
        echo $contents;
    }
}