<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2017 SalesAgility Ltd.
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


class ComposeView extends EditView
{
    /**
     * ComposeView constructor.
     */
    public function __construct()
    {
        $this->view = get_class($this);
    }

    /**
     * @inheritdoc
     */
    function setup($module, $focus = null, $metadataFile = null, $tpl = 'modules/Emails/include/ComposeView/ComposeView.tpl', $createFocus = true)
    {
        $this->th = $this->getTemplateHandler();
        $this->th->ss =& $this->ss;
        $this->tpl = $tpl;
        $this->module = $module;
        $this->focus = $focus;

        //this logic checks if the focus has an id and if it does not then it will create a new instance of the focus bean
        //but in convert lead we do not want to create a new instance and do not want to populate id.
        if ($createFocus)
        {
            $this->createFocus();
        }

        if (empty($GLOBALS['sugar_config']['showDetailData']))
        {
            $this->showDetailData = false;
        }
        $this->metadataFile = $metadataFile;

        if (isset($GLOBALS['sugar_config']['disable_vcr']))
        {
           $this->showVCRControl = !$GLOBALS['sugar_config']['disable_vcr'];
        }

        if (!empty($this->metadataFile) && file_exists($this->metadataFile))
        {
            include($this->metadataFile);
        }
        else
        {
            //If file doesn't exist we create a best guess
            if (!file_exists("modules/$this->module/metadata/composeviewdefs.php")
                && file_exists("modules/$this->module/EditView.html"))
            {
                require_once('include/SugarFields/Parsers/EditViewMetaParser.php');

                global $dictionary;

                $htmlFile = "modules/" . $this->module . "/EditView.html";
                $parser = new EditViewMetaParser();
                if (!file_exists('modules/'.$this->module.'/metadata'))
                {
                   sugar_mkdir('modules/'.$this->module.'/metadata');
                }

                $fp = sugar_fopen('modules/'.$this->module.'/metadata/composeviewdefs.php', 'w');
                fwrite($fp, $parser->parse($htmlFile, $dictionary[$focus->object_name]['fields'], $this->module));
                fclose($fp);
            }

            //Flag an error... we couldn't create the best guess meta-data file
            if (!file_exists("modules/$this->module/metadata/composeviewdefs.php"))
            {
                global $app_strings;

                $error = str_replace("[file]", "modules/$this->module/metadata/composeviewdefs.php", $app_strings['ERR_CANNOT_CREATE_METADATA_FILE']);
                $GLOBALS['log']->fatal($error);
                echo $error;
                die();
            }

            require("modules/$this->module/metadata/composeviewdefs.php");
        }

        $this->defs = $viewdefs[$this->module][$this->view];
        $this->isDuplicate = isset($_REQUEST['isDuplicate']) && $_REQUEST['isDuplicate'] == 'true' && $this->focus->aclAccess('edit');
    }
}

