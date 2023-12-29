{*
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
 *}
<script type="text/javascript" src="{sugar_getjspath file='include/javascript/sugar_grp_yui_widgets.js'}"></script>
<script>

    //set the variables
    var modalBod = "{$MESSAGE}";
    var cnfgtitle = '{$MOD.LBL_ERROR}';
    var startOverLBL = '{$MOD.LBL_TRY_AGAIN}';
    var cancelLBL = '{$MOD.LBL_CANCEL}';
    var actionVAR = '{$ACTION}';
    var importModuleVAR = '{$IMPORT_MODULE}';
    var sourceVAR = '{$SOURCE}';
    var showCancelVAR = '{$SHOWCANCEL}';
    {if !empty($CANCELLABEL)}
        cancelLBL = '{$CANCELLABEL}';
    {/if}

{literal}
    //function called when 'start over' button is pressed
    var chooseToStartOver = function() {
        //hide the modal and redirect window to previous step
        this.hide();
        document.location.href='index.php?module=stic_Import_Validation&action='+actionVAR+'&import_module='+importModuleVAR+'&source='+sourceVAR;
        //SUGAR.importWizard.renderDialog(importModuleVAR,actionVAR,sourceVAR);
    };
    var chooseToCancel = function() {
        //do nothing, just hide the modal
        this.hide();
    };

    //define the buttons to be used in modal popup
    var importButtons = '';
    if(showCancelVAR){
        importButtons = [{ text: startOverLBL, handler: chooseToStartOver, isDefault:true },{ text:cancelLBL, handler: chooseToCancel}];
    }else{
        importButtons = [{ text: startOverLBL, handler: chooseToStartOver, isDefault:true }];
    }

    //define import error modal window
    ImportErrorBox = new YAHOO.widget.SimpleDialog('importMsgWindow', {
        type : 'alert',
        modal: true,
        width: '350px',
        id: 'importMsgWindow',
        close: true,
        visible: true,
        fixedcenter: true,
        constraintoviewport: true,
        draggable: true,
        buttons: importButtons
    });
{/literal}
    //display the window
    ImportErrorBox.setHeader(cnfgtitle);
    ImportErrorBox.setBody(modalBod);
    ImportErrorBox.render(document.body);
    ImportErrorBox.show();

</script>