<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
/**
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
 */


require_once('include/Sugarpdf/Sugarpdf.php');

/**
 * This is an helper class to generate PDF using smarty template.
 * You have to extend this class, set the templateLocation to your smarty template
 * location and assign the Smarty variables ($this->ss->assign()) in the overriden
 * preDisplay method (don't forget to call the parent).
 *
 * @author bsoufflet
 *
 */
class SugarpdfSmarty extends Sugarpdf
{
    
    /**
     *
     * @var String
     */
    protected $templateLocation = "";
    /**
     * The Sugar_Smarty object
     * @var Sugar_Smarty
     */
    protected $ss;
    /**
     * These 5 variables are use for the writeHTML method.
     * @see include/tcpdf/tcpdf.php writeHTML()
     */
    protected $smartyLn = true;
    protected $smartyFill = false;
    protected $smartyReseth = false;
    protected $smartyCell = false;
    protected $smartyAlign = "";
    
    public function preDisplay()
    {
        parent::preDisplay();
        $this->print_header = false;
        $this->print_footer = false;
        $this->_initSmartyInstance();
    }
    
    public function display()
    {
        //turn off all error reporting so that PHP warnings don't munge the PDF code
        $maxExecutionTime = ini_get('max_execution_time');
        $errorReporting = error_reporting();
        
        error_reporting(0);
        set_time_limit(1800);
        
        //Create new page
        $this->AddPage();
        $this->SetFont(PDF_FONT_NAME_MAIN, '', 8);
        
        if (!empty($this->templateLocation)) {
            $str = $this->ss->fetch($this->templateLocation);
            $this->writeHTML($str, $this->smartyLn, $this->smartyFill, $this->smartyReseth, $this->smartyCell, $this->smartyAlign);
        } else {
            $this->Error('The class SugarpdfSmarty has to be extended and you have to set a location for the Smarty template.');
        }
        
        ini_set('max_execution_time', $maxExecutionTime);
        error_reporting($errorReporting);
    }
    
    /**
     * Init the Sugar_Smarty object.
     */
    private function _initSmartyInstance()
    {
        if (!($this->ss instanceof Sugar_Smarty)) {
            require_once('include/Sugar_Smarty.php');
            $this->ss = new Sugar_Smarty();
            $this->ss->assign('MOD', $GLOBALS['mod_strings']);
            $this->ss->assign('APP', $GLOBALS['app_strings']);
        }
    }
}
