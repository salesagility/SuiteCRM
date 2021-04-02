<?php
/*
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2019 SalesAgility Ltd.
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
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
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
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 *
 * This file was contributed by Urdhva tech private limited <contact@urdhva-tech.com>
 **/

require_once('include/SugarFields/Fields/Base/SugarFieldBase.php');

class SugarFieldWysiwyg extends SugarFieldBase {

    function getDetailViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex)
    {
        $vardef['inline_edit'] = false;
        return parent::getDetailViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex);
    }

    function getEditViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex)
    {
        $this->setup($parentFieldArray, $vardef, $displayParams, $tabindex);

        require_once('include/SugarTinyMCE.php');

        global $json;

        if (empty($json)) {
            $json = getJSONobj();
        }

        $form_name = '';

        if (!empty($this->ss->_tpl_vars['displayParams']['formName'])) {
            $form_name = $this->ss->_tpl_vars['displayParams']['formName'];
        }

        $tiny = new SugarTinyMCE();

        $tiny->defaultConfig['apply_source_formatting'] = false;
        $tiny->defaultConfig['cleanup_on_startup'] = true;
        $tiny->defaultConfig['relative_urls'] = false;
        $tiny->defaultConfig['convert_urls'] = false;
        $tiny->defaultConfig['strict_loading_mode'] = true;
        $tiny->defaultConfig['width'] = '100%';

        $config = $tiny->defaultConfig;

        $config['plugins']  = 'print code preview fullpage searchreplace autolink directionality visualblocks visualchars fullscreen image link media codesample table charmap hr pagebreak nonbreaking anchor insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern ';
        $config['elements'] = "#{$form_name} "."#".$vardef['name'];
        $config['selector'] = "#{$form_name} "."#".$vardef['name'];
        $config['content_css'] = './../../vendor/tinymce/tinymce/skins/lightgray/content.min.css';
        $config['toolbar1'] = 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat';
        $config['theme'] = 'modern';

        $jsConfig = $json->encode($config);
        $initiate = '<script type="text/javascript" language="Javascript"> tinyMCE.init('.$jsConfig.');</script>';
        $this->ss->assign("tiny", $initiate);

        return parent::getEditViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex);
    }
}
