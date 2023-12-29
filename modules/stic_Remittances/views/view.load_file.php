<?php
/**
 * This file is part of SinergiaCRM.
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation.
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
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 */
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once 'include/MVC/View/SugarView.php';

class stic_RemittancesViewload_file extends SugarView
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see SugarView::display()
     */
    public function display()
    {

        echo <<<SCRIPT
        <script type='text/javascript' src='cache/include/javascript/sugar_grp_yui_widgets.js'></script>
        <script>
        YAHOO.SUGAR.MessageBox.show({
            width: 'auto',
            msg: '<form id="miform" action="index.php?module=stic_Remittances&action=loadSEPAReturns" method="post" enctype="multipart/form-data"><input type="file" name="file" size="10"> <br><center><input type="button" onclick="this.form.submit();" value="' + SUGAR.language.get("stic_Remittances", "LBL_SEPA_RETURN_LOAD_FILE") + '"></center></form>',
            title: SUGAR.language.get('stic_Remittances', 'LBL_SEPA_RETURN_SELECT_FILE')
        });

        </script>
SCRIPT;

    }
}
