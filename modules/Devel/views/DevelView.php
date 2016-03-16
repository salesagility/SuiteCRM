<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/**
 * Created by Adam Jakab.
 * Date: 11/03/16
 * Time: 10.52
 */

require_once('include/MVC/View/SugarView.php');


class DevelView extends SugarView
{
    /** @var \DevelRequestStats  */
    public $bean;

    /**
     * @var Sugar_Smarty
     */
    public $ss;

    public function __construct($bean = null, $view_object_map = array()) {
        $this->ss = new Sugar_Smarty();
    }

    /**
     * @see SugarView::getMenu()
     */
    public function getMenu($module = null)
    {
        $menu = parent::getMenu();
        return $menu;
    }
}

