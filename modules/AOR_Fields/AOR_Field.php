<?php

/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2016 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */
class AOR_Field extends Basic
{
    var $new_schema = true;
    var $module_dir = 'AOR_Fields';
    var $object_name = 'AOR_Field';
    var $table_name = 'aor_fields';
    var $tracker_visibility = false;
    var $importable = true;
    var $disable_row_level_security = true;

    var $id;
    var $name;
    var $date_entered;
    var $date_modified;
    var $modified_user_id;
    var $modified_by_name;
    var $created_by;
    var $created_by_name;
    var $description;
    var $deleted;
    var $created_by_link;
    var $modified_user_link;
    var $field_order;
    var $field;
    var $display;
    var $label;
    var $field_function;
    var $sort_by;
    var $sort_order;
    var $group_by;
    var $group_order;
    var $group_display;
    var $aor_report_id;

    function AOR_Field()
    {
        parent::Basic();
    }

    function save_lines($post_data, $parent, $key = '')
    {

        require_once('modules/AOW_WorkFlow/aow_utils.php');

        $line_count = count($post_data[$key . 'field']);
        for ($i = 0; $i < $line_count; ++$i) {

            if ($post_data[$key . 'deleted'][$i] == 1) {
                $this->mark_deleted($post_data[$key . 'id'][$i]);
            } else {
                $field = new AOR_Field();
                $field->group_display = false;

                if ($key == 'aor_fields_') {
                    foreach ($post_data['aor_fields_group_display'] as $gdKey => $gdValue) {
                        if ($gdValue == $i) {
                            $field->group_display = $gdKey + 1;
                            break;
                        }
                    }
                }

                foreach ($this->field_defs as $field_def) {
                    $field_name = $field_def['name'];
                    if (is_array($post_data[$key . $field_name])) {
                        if ($field_name != 'group_display' && isset($post_data[$key . $field_name][$i])) {
                            if (is_array($post_data[$key . $field_name][$i])) {
                                $post_data[$key . $field_name][$i] = base64_encode(serialize($post_data[$key . $field_name][$i]));
                            } else if ($field_name == 'value') {
                                $post_data[$key . $field_name][$i] = fixUpFormatting($_REQUEST['report_module'], $field->field, $post_data[$key . $field_name][$i]);
                            }
                            if ($field_name == 'module_path') {
                                $post_data[$key . $field_name][$i] = base64_encode(serialize(explode(":", $post_data[$key . $field_name][$i])));
                            }
                            $field->$field_name = $post_data[$key . $field_name][$i];
                        }
                    } else if (is_null($post_data[$key . $field_name])) {
                        // do nothing
                    } else {
                        throw new Exception('illegal type in post data at key ' . $key . $field_name . ' ' . gettype($post_data[$key . $field_name]));
                    }

                }
                if (trim($field->field) != '') {
                    $field->aor_report_id = $parent->id;
                    $field->save();
                }
            }
        }
    }

}