/**
 * This file is part of KReporter. KReporter is an enhancement developed
 * by Christian Knoll. All rights are (c) 2012 by Christian Knoll
 *
 * This file has been modified by SinergiaTIC in SinergiaCRM.
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
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
 * You can contact Christian Knoll at info@kreporter.org
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 */

// STIC-Custom 20230710 AAM - Improving export to LPO
// STIC#1010
// var C=new Ext.LoadMask(Ext.getBody(),{msg:"creating TargetList ... "});var ktargetlistexport=function(){Ext.Msg.prompt(bi('LBL_TARGETLIST_NAME'),bi('LBL_TARGETLIST_PROMPT'),function(btn,text){if(btn=='ok'){C.show();Ext.Ajax.request({url:'index.php?module=KReports&to_pdf=true&action=pluginaction&plugin=ktargetlistexport&pluginaction=export_to_targetlist',success:function(){C.hide();},failure:function(){C.hide();},params:{targetlist_name:text,record:document.getElementById('recordid').value,whereConditions:K.kreports.DetailView.ae()}});}})}; 
var ktargetlistexport = function() {
    Ext.Msg.show({
        title: SUGAR.language.translate('KReports', 'LBL_TARGETLISTEXPORT_ALERT_TITLE'),
        msg: SUGAR.language.translate('KReports', 'LBL_TARGETLISTEXPORT_ALERT_DESCRIPTION'),
        width: 300,
        closable: false,
        buttons: Ext.Msg.YESNOCANCEL,
        buttonText: {
            yes: SUGAR.language.translate('KReports', 'LBL_TARGETLISTEXPORT_ALERT_CUMULATIVE'),
            no: SUGAR.language.translate('KReports', 'LBL_TARGETLISTEXPORT_ALERT_REPLACEMENT'),
            cancel: SUGAR.language.translate('KReports', 'LBL_TARGETLISTEXPORT_ALERT_CANCEL')
        },
        multiline: false,
        fn: function(buttonValue, inputText, showConfig) {
            // yes = Cumulative
            if (buttonValue == "yes") {
                openPopup();
            // no = replacement
            } else if (buttonValue == "no") {
                openPopup(true);
            } else {
                SUGAR.ajaxUI.loadingPanel.hide();
                ajaxStatus.hideStatus();
            }
        },
        icon: Ext.Msg.QUESTION
    });
    
    // In order to initialize the function loadingPanel.show(), it needs to be called the showLoadingPanel() first.
};

function openPopup (replacement = false) {
    SUGAR.ajaxUI.showLoadingPanel();
    SUGAR.ajaxUI.hideLoadingPanel();
    SUGAR.ajaxUI.loadingPanel.show();
    ajaxStatus.showStatus(SUGAR.language.get("KReports", "LBL_TARGETLISTEXPORT_SELECTION"));
    document.getElementById("ajaxStatusDiv").style.zIndex = 1040; // No need this line when this PR is merged: https://github.com/salesagility/SuiteCRM/issues/8266

    var win = open_popup(
        "ProspectLists",
        800,
        600,
        "",
        true,
        true,
        {
            call_back_function: "setReturnExportTargetList",
            form_name: "ListView",
            field_to_name_array: { id: "prospectListId", name: "prospectListName" },
            passthru_data: {
                replacement: replacement,
            }
        },
        "single",
        true,
        "lvso=DES&ProspectLists2_PROSPECTSLISTS_ORDER_BY=date_entered"
    );
    win.onload = function() {
        win.onbeforeunload = function() {
            SUGAR.ajaxUI.loadingPanel.hide();
            ajaxStatus.hideStatus();
        };
    };
}

/**
 * 
 * Runs the controller action after a job offer is selected in the job applications mass creation process
 */
function setReturnExportTargetList(popupReplyData) {
    ajaxStatus.showStatus(SUGAR.language.get("KReports", "LBL_TARGETLISTEXPORT_LOADING"));
    sendAjaxRequest(popupReplyData);
}

function sendAjaxRequest(popupReplyData) {
    replacement = popupReplyData.passthru_data.replacement;
    SUGAR.ajaxUI.showLoadingPanel();
    SUGAR.ajaxUI.hideLoadingPanel();
    SUGAR.ajaxUI.loadingPanel.show();
    ajaxStatus.showStatus(SUGAR.language.get("KReports", "LBL_TARGETLISTEXPORT_LOADING"));
    Ext.Ajax.request({
        url:
            "index.php?module=KReports&to_pdf=true&action=pluginaction&plugin=ktargetlistexport&pluginaction=export_to_targetlist",
        params: {
            prospectListId: popupReplyData.name_to_value_array.prospectListId,
            prospectListName: popupReplyData.name_to_value_array.prospectListName,
            record: document.getElementById("recordid").value,
            whereConditions: K.kreports.DetailView.ae(),
            replacement: replacement,
        },
        success: function(data) {
            SUGAR.ajaxUI.loadingPanel.hide();
            ajaxStatus.hideStatus();
        },
        failure: function() {
            SUGAR.ajaxUI.showLoadingPanel();
            SUGAR.ajaxUI.hideLoadingPanel();
            SUGAR.ajaxUI.loadingPanel.show();
            ajaxStatus.showStatus("Error");
            console.log("failure");
        }
    });
}

// END STIC-Custom