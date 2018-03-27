<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$layout_defs['AOR_Reports'] = array(
    'subpanel_setup' => array(
        'aor_scheduled_reports_aor_reports' => array(
            'order' => 100,
            'module' => 'AOR_Scheduled_Reports',
            'subpanel_name' => 'default',
            'sort_order' => 'asc',
            'sort_by' => 'id',
            'title_key' => 'AOR_Scheduled_Reports',
            'get_subpanel_data' => 'aor_scheduled_reports',
            'top_buttons' =>
                array(
                    0 =>
                        array(
                            'widget_class' => 'SubPanelTopButtonQuickCreate',
                        ),
                    1 =>
                        array(
                            'widget_class' => 'SubPanelTopSelectButton',
                            'mode' => 'MultiSelect',
                        ),
                ),
        ),
    ),
);
