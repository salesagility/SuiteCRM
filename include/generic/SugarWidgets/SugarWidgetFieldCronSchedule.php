<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
class SugarWidgetFieldCronSchedule extends SugarWidgetFieldVarchar
{
    public function __construct($layout_manager) {
        parent::__construct($layout_manager);
    }

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    public function SugarWidgetFieldCronSchedule($layout_manager){
        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code';
        if(isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        }
        else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct($layout_manager);
    }

}
