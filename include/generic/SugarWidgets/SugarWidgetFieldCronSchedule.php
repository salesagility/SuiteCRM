<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
class SugarWidgetFieldCronSchedule extends SugarWidgetFieldVarchar
{
    public function SugarWidgetFieldCronSchedule($layout_manager) {
        parent::SugarWidgetFieldText($layout_manager);
    }
}
