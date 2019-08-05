<?php
$viewdefs ['ProjectTask'] =
array(
  'QuickCreate' =>
  array(
    'templateMeta' =>
    array(
      'maxColumns' => '2',
      'widths' =>
      array(
        0 =>
        array(
          'label' => '10',
          'field' => '30',
        ),
        1 =>
        array(
          'label' => '10',
          'field' => '30',
        ),
      ),
      'includes' =>
      array(
        0 =>
        array(
          'file' => 'modules/ProjectTask/ProjectTask.js',
        ),
      ),
    ),
    'panels' =>
    array(
      'default' =>
      array(
        0 =>
        array(
          0 =>
          array(
            'name' => 'name',
            'label' => 'LBL_NAME',
          ),
          1 =>
          array(
            'name' => 'project_task_id',
            'label' => 'LBL_TASK_ID',
          ),
        ),
        1 =>
        array(
          0 =>
          array(
            'name' => 'date_start',
          ),
          1 =>
          array(
            'name' => 'date_finish',
          ),
        ),
        2 =>
        array(
          'name' => 'assigned_user_name',
        ),
        3 =>
        array(
          0 =>
          array(
            'name' => 'status',
            'customCode' => '<select name="{$fields.status.name}" id="{$fields.status.name}" title="" tabindex="s" onchange="update_percent_complete(this.value);">{if isset($fields.status.value) && $fields.status.value != ""}{html_options options=$fields.status.options selected=$fields.status.value}{else}{html_options options=$fields.status.options selected=$fields.status.default}{/if}</select>',
          ),
          1 => 'priority',
        ),
        4 =>
        array(
          0 =>
          array(
            'name' => 'percent_complete',
            'customCode' => '<input type="text" name="{$fields.percent_complete.name}" id="{$fields.percent_complete.name}" size="30" value="{$fields.percent_complete.value}" title="" tabindex="0" onChange="update_status(this.value);" /></tr>',
          ),
        ),
        5 =>
        array(
          0 => 'milestone_flag',
        ),
        6 =>
        array(
          0 =>
          array(
            'name' => 'project_name',
            'label' => 'LBL_PROJECT_NAME',
          ),
        ),
        7 =>
        array(
          0 => 'task_number',
          1 => 'order_number',
        ),
        8 =>
        array(
          0 => 'estimated_effort',
          1 => 'utilization',
        ),
        9 =>
        array(
          0 =>
          array(
            'name' => 'description',
          ),
        ),
        10 =>
        array(
          0 =>
          array(
            'name' => 'duration',
            'hideLabel' => true,
            'customCode' => '<input type="hidden" name="duration" id="projectTask_duration" value="0" />',
          ),
        ),
        11 =>
        array(
          0 =>
          array(
            'name' => 'duration_unit',
            'hideLabel' => true,
            'customCode' => '<input type="hidden" name="duration_unit" id="projectTask_durationUnit" value="Days" />',
          ),
        ),
      ),
    ),
  ),
);
