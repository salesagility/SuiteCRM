<?php
/**
 *
 *
 * @package
 * @copyright SalesAgility Ltd http://www.salesagility.com
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU AFFERO GENERAL PUBLIC LICENSE
 * along with this program; if not, see http://www.gnu.org/licenses
 * or write to the Free Software Foundation,Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA 02110-1301  USA
 *
 * @author Salesagility Ltd <support@salesagility.com>
 */
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/MVC/View/SugarView.php');
require_once('include/MVC/View/views/view.list.php');

class PivotViewPivotData extends SugarView {

    public function __construct() {
        parent::SugarView();
    }
    /**
     * display the form
     */
    public function display(){
        global $mod_strings;
        $areaForAnalysis = $mod_strings['LBL_AN_AREA_FOR_ANALYSIS'];
        $sales = $mod_strings['LBL_AN_SALES'];
        $accounts = $mod_strings['LBL_AN_ACCOUNTS'];
        $leads = $mod_strings['LBL_AN_LEADS'];
        $service = $mod_strings['LBL_AN_SERVICE'];
        $marketing =  $mod_strings['LBL_AN_MARKETING'];
        $marketingActivity = $mod_strings['LBL_AN_MARKETING_ACTIVITY'];
        $quotes = $mod_strings['LBL_AN_QUOTES'];
        $activities = $mod_strings['LBL_AN_ACTIVITIES'];
        $genericSave = $mod_strings['LBL_AN_BTN_SAVE'];
        $genericLoad = $mod_strings['LBL_AN_BTN_LOAD'];
        $genericDelete = $mod_strings['LBL_AN_BTN_DELETE'];
        $dialogSaveLabel = $mod_strings['LBL_AN_SAVE_PIVOT'];
        $dialogLoadLabel = $mod_strings['LBL_AN_LOAD_PIVOT'];
        $dialogDeleteLabel = $mod_strings['LBL_AN_DELETE_PIVOT'];

        $analytics = <<<EOT
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.10/c3.min.css">
<script type="text/javascript" src="include/javascript/d3/d3.min.js"></script>
<script type="text/javascript" src="include/javascript/c3/c3.min.js"></script>
<script type="text/javascript" src="include/javascript/touchPunch/jquery.ui.touch-punch.min.js"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="include/javascript/pivottable/pivot.css">
<script type="text/javascript" src="include/javascript/pivottable/pivot.js"></script>
<script type="text/javascript" src="include/javascript/pivottable/c3_renderers.js"></script>
<script type="text/javascript" src="include/javascript/suitePivot/suitePivot.js"></script>

<style>
    i.fa{
        margin-right:10px;
    }
</style>

<label for="analysisType">$areaForAnalysis</label>
<select id="analysisType">
    <option value="getSalesPivotData">$sales</option>
    <option value="getAccountsPivotData">$accounts</option>
    <option value="getLeadsPivotData">$leads</option>
    <option value="getServicePivotData">$service</option>
    <option value="getMarketingPivotData">$marketing</option>
    <option value="getMarketingActivityPivotData">$marketingActivity</option>
    <option value="getActivitiesPivotData">$activities</option>
    <option value="getQuotesPivotData">$quotes</option>
</select>
<div id="output" style="margin: 30px;"></div>
<div id="config"></div>

<button type="button" id="btnSavePivot" class="button"><i class="fa fa-floppy-o"></i>$genericSave</button>
<button type="button" id="btnLoadPivot" class="button"><i class="fa fa-search"></i>$genericLoad</button>
<button type="button" id="btnDeletePivot" class="button"><i class="fa fa-trash"></i>$genericDelete</button>

<input type="hidden" id="txtChosenSave">
<input type="hidden" id="txtConfigSave">
<div id="dialogSave" title="$dialogSaveLabel">
    <p class="validateTips"></p>
    <form>
        <fieldset>
            <label for="name">Name</label>
            <input type="text" name="name" id="pivotName" class="text ui-widget-content ui-corner-all">
        </fieldset>
    </form>
</div>
<div id="dialogLoad" title="$dialogLoadLabel">
<select id="pivotLoadList"></select>
</div>
<div id="dialogDelete" title="$dialogDeleteLabel">
    <select id="pivotDeleteList"></select>
</div>
EOT;

        echo $analytics;
    }
}