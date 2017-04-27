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

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

/**
 * Interface SuiteEditorInterface
 *
 * each editor based on same interface to use all of it in same way
 */
interface SuiteEditorInterface
{
    /**
     * use this method after the constructor to tell
     * the settings that apply on editor connector
     *
     * @param null $settings (optional) preferred an associative array or object
     */
    public function setup(SuiteEditorSettings $settings = null);

    /**
     * generate an output which contains the editor
     *
     * @return string (html output)
     */
    public function getHtml();

}

/**
 * Class SuiteEditorSettings
 *
 * store and extends an associative settings for editors
 */
abstract class SuiteEditorSettings
{

    /**
     * SuiteEditorSettings constructor.
     *
     * @param $settings assoc array or object
     */
    public function __construct($settings) {
        foreach($this as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * extends the settings
     *
     * @param $settings assoc array or object
     */
    public function extend($settings)
    {
        foreach ($settings as $key => $value) {
            $this->$key = $value;
        }
    }

}



/**
 * Class SuiteEditorSettingsForDirectHTML
 *
 * store and extends an associative settings for a simple textarea editor
 */
class SuiteEditorSettingsForDirectHTML extends SuiteEditorSettings
{

    /**
     * Editor contents
     * @var string
     */
    public $contents = '';

    /**
     * target element, original textarea ID
     * @var string
     */
    public $textareaId = 'text';

    /**
     * Editor element ID
     * @var string
     */
    public $elementId = 'editor';

    /**
     * SuiteEditorSettingsForDirectHTML constructor.
     *
     * set the default settings for a simple textarea editor
     * and if settings argument exists extends it
     * @param null $settings (optional)
     */
    public function __construct($settings = null) {
        if($settings) {
            $this->extend($settings);
        }
    }

}

class SuiteEditorSettingsForTinyMCE extends SuiteEditorSettingsForDirectHTML
{

}

/**
 * Class SuiteEditorSettingsForMozaik
 *
 * store and extends an associative settings for a mozaik editor
 * in constructor, set the default settings for a mozaik editor
 * and if settings argument exists extends it
 */
class SuiteEditorSettingsForMozaik extends SuiteEditorSettingsForDirectHTML
{

    public $width = 600;
    public $group = '';
    public $tinyMCESetup = 'tinyMCE: {}';

}



/**
 * Class SuiteEditorDirectHTML
 *
 * use simple textarea as a SuiteEditor
 */
class SuiteEditorDirectHTML implements SuiteEditorInterface
{
    protected $settings;

    /**
     * see at SuiteEditorInterface
     *
     * @param SuiteEditorSettings $settings
     */
    public function setup(SuiteEditorSettings $settings = null) {
        $this->settings = new SuiteEditorSettingsForDirectHTML();
        $this->settings->extend($settings);
    }

    /**
     * see at SuiteEditorInterface
     *
     * @return mixed
     */
    public function getHtml() {
        // todo: use a smarty template to generate html of the textarea instead of a simple string concatenation because that is... better???
        return "<script>
                    SuiteEditor.getValue = function() {
                        return $('#{$this->settings->elementId}').val();
                    }
                    $(window).mouseup(function(){
                        $('#{$this->settings->textareaId}').val(SuiteEditor.getValue());
                    });
                </script>
                <textarea id=\"{$this->settings->elementId}\" name=\"{$this->settings->elementId}\">{$this->settings->contents}</textarea>";
    }

}

/**
 * Class SuiteEditorTinyMCE
 *
 * use TinyMCE editor as SuiteEditor
 */
class SuiteEditorTinyMCE implements SuiteEditorInterface
{
    protected $settings;

    /**
     * see at SuiteEditorInterface
     *
     * @param SuiteEditorSettings $settings
     */
    public function setup(SuiteEditorSettings $settings = null) {
        $this->settings = $settings;
    }

    /**
     * see at SuiteEditorInterface
     *
     * @return mixed
     */
    public function getHtml() {
        return "<script src='include/javascript/mozaik/vendor/tinymce/tinymce/tinymce.min.js'></script>" .
        "<script>tinymce.init({ selector:'#{$this->settings->elementId}' });</script>".
        "<script>
            SuiteEditor.getValue = function() {
                return tinyMCE.get('{$this->settings->elementId}').getContent();
            }
            $(window).mouseup(function(){
                $('#{$this->settings->textareaId}').val(SuiteEditor.getValue());
            });
            </script>".
        "<textarea id=\"{$this->settings->elementId}\" name=\"{$this->settings->elementId}\">{$this->settings->contents}</textarea>";
    }

}

/**
 * Class SuiteEditorMozaik
 *
 * Use Mozaik Editor as SuiteEditor
 */
class SuiteEditorMozaik implements SuiteEditorInterface
{
    protected $settings;
    protected $mozaik;

    /**
     * see at SuiteEditorInterface
     *
     * @param SuiteEditorSettings $settings
     */
    public function setup(SuiteEditorSettings $settings = null) {
        $this->settings = new SuiteEditorSettingsForMozaik($settings);
        require_once('include/SuiteMozaik.php');
        $this->mozaik = new SuiteMozaik();
    }

    /**
     * see at SuiteEditorInterface
     *
     * @return mixed
     */
    public function getHtml() {
        return "<script>SuiteEditor.getValue = function() { return $('#{$this->settings->elementId}').getMozaikValue(); }</script>". $this->mozaik->getAllHTML(
            $this->settings->contents,
            $this->settings->textareaId,
            $this->settings->elementId,
            $this->settings->width,
            $this->settings->group,
            $this->settings->tinyMCESetup
        );
    }

}



/**
 * Class SuiteEditor
 *
 * User Preference Editor connector class for different kind of editors
 * typically for Email Templates but any HTML or text editing..
 */
class SuiteEditorConnector
{

    /**
     * return an output HTML of user selected editor for templates
     * based on current user preferences
     *
     * @param null $settings (optional) extends of selected editor default settings
     * @throws Exception unknown or incorrect editor
     * @return string HTML output of editor
     */
    public static function getHtml($settings = null) {
        global $current_user;

        switch($current_user->getEditorType()) {

            case 'none':
                $editor = new SuiteEditorDirectHTML();
                $settings = new SuiteEditorSettingsForDirectHTML($settings);
                break;

            case 'tinymce':
                $editor = new SuiteEditorTinyMCE();
                $settings = new SuiteEditorSettingsForTinyMCE($settings);
                break;

            case 'mozaik':
                $editor = new SuiteEditorMozaik();
                $settings = new SuiteEditorSettingsForMozaik($settings);
                break;

            // new editor type should be possible to store in
            // user preferences but in this file for
            // add more type use the syntax bellow... for e.g:
            //
            //case 'your_awesome_editor':
            //    $editor = new SuiteEditorAwesome(); // where the editor class should implements SuiteEditorInterface
            //    break;

            default:
                throw new Exception('unknown editor type: '.$current_user->getEditorType());
        }

        // just make sure the type of editor implements a SuiteEditorInterface..

        if( !($editor instanceof SuiteEditorInterface) ){
            throw new Exception("class $editor is not a SuiteEditorInterface");
        }

        // rendering the editor output HTML

        $editor->setup($settings);
        return "<script>if(!SuiteEditor) {var SuiteEditor = {};}</script>".$editor->getHtml();
    }

}