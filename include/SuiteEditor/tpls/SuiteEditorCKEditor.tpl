{**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
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
 *}


<script src="vendor/ckeditor/ckeditor/ckeditor.js"></script>

<textarea name="{$elementId}">{$contents}</textarea>

<script>
    var textarea_id = "#{$textareaId}";
    var editor_name = "{$elementId}";
    var crm_language = "{$language}";
    var click_handler = null;
    {if $clickHandler}
    click_handler = {$clickHandler};
    {/if}

    CKEDITOR.timestamp = "{$VERSION_MARK}";

    {literal}

    /**
     * Given a SuiteCRM language identifier tries to return a matching CKEditor language identifier.
     *
     * @param crm_language
     * @returns {string}
     */
    function getEditorLanguage(crm_language) {
        var primary = crm_language.toLowerCase().split('_')[0];
        var region = crm_language.toLowerCase().replace('_', '-');
        var available = Object.keys(CKEDITOR.lang.languages);

        // example: for 'zh_CN' first try 'zh-cn' and then 'zh' and then fall back to 'en'
        if (available.includes(region)) {
            return region;
        } else if (available.includes(primary)) {
            return primary;
        } else {
            return CKEDITOR.config.defaultLanguage;
        }
    }

    SuiteEditor.apply = function(htmlCode) {
        CKEDITOR.instances[editor_name].setData(htmlCode);
    };

    SuiteEditor.getValue = function() {
        return CKEDITOR.instances[editor_name].getData();
    };

    SuiteEditor.insert = function(text, elemId) {
        if (elemId === editor_name) {
            CKEDITOR.instances[editor_name].insertHtml(text);
        }
    };

    CKEDITOR.replace(editor_name, {
        extraPlugins: 'image2,font,templates,colorbutton,tableresize,justify',
        // * image disable because we use image2
        // * tableselection disabled to work around this bug: https://github.com/ckeditor/ckeditor-dev/issues/547
        removePlugins: 'image,tableselection',
        height: 600,
        width: "90%",
        language: getEditorLanguage(crm_language),
        filebrowserImageUploadUrl: 'index.php?to_pdf=1&module=EmailTemplates&action=UploadImageCKEditor',
        // We send emails without styles, so make sure we show things as is
        contentsCss: '',
        allowedContent: true,
        forcePasteAsPlainText: true,
        templates_replaceContent: false,
        templates_files: ['/include/SuiteEditor/ckeditor/templates/templates.js'],
    });

    // Use all existing transformation which could help us with supporting older E-Mail HTML engines
    CKEDITOR.on('instanceReady', function(ev) {
        ev.editor.filter.addTransformations([['sizeToAttribute'], ['alignmentToAttribute'], ['splitBorderShorthand'], ['splitMarginShorthand']]);
    });

    // Set the alt text to the filename by default
    CKEDITOR.instances[editor_name].on('fileUploadResponse', function(ev) {
        var filename = ev.data.fileLoader.fileName;
        var dialog = CKEDITOR.dialog.getCurrent();
        var alt = dialog.getContentElement('info', 'alt');
        alt.setValue(filename);
    });

    // On focus switch the insert button to target the editor
    CKEDITOR.instances[editor_name].on('focus', function(ev) {
        click_handler();
    });

    // Sync the content into the textarea element
    CKEDITOR.instances[editor_name].on('change', function(ev) {
        $(textarea_id).val(SuiteEditor.getValue());
    });

    {/literal}
</script>