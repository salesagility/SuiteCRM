<?php

/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2019 Salesagility Ltd.
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
 ********************************************************************************/


if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('modules/DynamicFields/templates/Fields/TemplateText.php');
class TemplateTextAreaLong extends TemplateText
{
    var $type = 'longtext';
    var $len = '';

    /**
    * __construct
    *
    * Constructor for TemplateTextAreaLong  class.
    */
    function __construct()
    {
        $this->vardef_map['rows'] = 'ext2';
        $this->vardef_map['cols'] = 'ext3';
    }

    /**
    * set
    *
    * @see parent::set()
    */
    public function set($values)
    {
        parent::set($values);

        if (!empty($this->ext2)) {
            $this->rows = $this->ext2;
        }
        
        if (!empty($this->ext3)) {
            $this->cols = $this->ext3;
        }
        
        if (!empty($this->ext4)) {
            $this->default_value = $this->ext4;
        }
    }

    /**
    * get_xtpl_detail
    *
    * Inserts HTML line breaks before all newlines in the TextArea
    */
    public function get_xtpl_detail()
    {
        $name = $this->name;
        return nl2br($this->bean->$name);
    }

    /**
    * get_field_def
    *
    * @see parent::get_field_def()
    */
    public function get_field_def()
    {
        $def = parent::get_field_def();
        $def['studio'] = 'visible';

        if (isset($this->ext2) && isset($this->ext3)) {
            $def['rows'] = $this->ext2;
            $def['cols'] = $this->ext3;
        }
        
        if (isset($this->rows) && isset($this->cols)) {
            $def['rows'] = $this->rows;
            $def['cols'] = $this->cols;
        }
        
        return $def;
    }

    /**
    * get_db_default
    *
    * TEXT columns in MySQL cannot have a DEFAULT value - let the Bean handle it on save
    * set null so that the get_db_default() routine in TemplateField doesn't try to set DEFAULT
    */
    public function get_db_default($modify = false)
    {
        return null;
    }
}
