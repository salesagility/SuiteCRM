<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

/**
 * Created by Adam Jakab.
 * Date: 11/03/16
 * Time: 9.16
 */

require_once('modules/Devel/views/DevelView.php');

class DevelViewDetail extends DevelView
{
    public function __construct($bean = null, $view_object_map = array())
    {
        parent::__construct($bean, $view_object_map);
    }

    public function display() {
        $this->ss->register_function('convert_to_printable_key_value_array', [$this, 'smartyConvertToPrintableKeyValueArray']);
        $this->ss->assign('containerID', 'stats-for-request-'.$this->bean->getRequestNumber());
        $this->ss->assign('stats', $this->bean);
        $contents = $this->ss->fetch('modules/Devel/tpls/detailview.tpl');
        echo $contents;
    }

    /**
     * @param array $params
     * @param \Sugar_Smarty $smarty
     * @return null
     */
    public function smartyConvertToPrintableKeyValueArray($params, &$smarty) {
        $answer = [];
        if(isset($params["data"])) {
            foreach($params["data"] as $k => $v) {
                $printableValue = '?';
                switch(gettype($v)) {
                    case "boolean":
                        $printableValue = $v ? "True" : "False";
                        break;
                    case "integer":
                    case "double":
                    case "string":
                    $printableValue = (string)$v;
                        break;
                    case "array":
                    case "object":
                        $printableValue = print_r($v, true);
                        break;
                    case "NULL":
                        $printableValue = "NULL";
                        break;
                }
                $answer[$k] = $printableValue;
            }
        }
        $smarty->assign($params['assign'], $answer);
        return NULL;
    }


}