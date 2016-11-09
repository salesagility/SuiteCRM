/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
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


/**
 * Edit functions for EAPM
 */
function EAPMChange() {
    var apiName = '';
    var passwordPlaceholder = '::PASSWORD::';

    if ( EAPMFormName == 'EditView' ) {
        apiName = document.getElementById('application').value;
    } else {
        apiName = document.getElementById('application_raw').value;
    }
    if(SUGAR.eapm[apiName]){
        var apiOpts = SUGAR.eapm[apiName];

        var urlObj = new SUGAR.forms.VisibilityAction('url',(apiOpts.needsUrl?'true':'false'), EAPMFormName);
        urlObj.setContext(new SUGAR.forms.FormExpressionContext(this.form));
        if ( EAPMFormName == 'EditView' ) {
            EAPMSetFieldRequired('url',(apiOpts.needsUrl == true));
        }

        var userObj = new SUGAR.forms.VisibilityAction('name',((apiOpts.authMethod=='password')?'true':'false'), EAPMFormName);
        userObj.setContext(new SUGAR.forms.FormExpressionContext(this.form));
        if ( EAPMFormName == 'EditView' ) {
            EAPMSetFieldRequired('name',(apiOpts.authMethod == 'password'));
        }

        var passObj = new SUGAR.forms.VisibilityAction('password',((apiOpts.authMethod=='password')?'true':'false'), EAPMFormName);
        passObj.setContext(new SUGAR.forms.FormExpressionContext(this.form));
        if ( EAPMFormName == 'EditView' ) {
            EAPMSetFieldRequired('password',(apiOpts.authMethod == 'password'));
            var $el = $('#password');

            //Setup a toggle to prevent accidental password changes since we no longer send the real password
            //to the browser
            if ($el.val() == passwordPlaceholder) {
                var instructions = $(EAPMBClickToEdit);
                instructions.click(function(e) {
                    e.preventDefault();
                    $el.val('');
                    instructions.hide();
                    $el.show();
                    $el.focus();
                });
                $el.parent().append(instructions);
                $el.hide();
                $el.focusout(function() {
                    if ($el.val() == '') {
                        $el.val(passwordPlaceholder);
                        instructions.show();
                        $el.hide();
                    }
                });
            }
        }

        urlObj.exec();
        userObj.exec();
        passObj.exec();

        //hide/show new window notice
        var messageDiv = document.getElementById('eapm_notice_div');
        if ( typeof messageDiv != 'undefined' && messageDiv != null ) {
            if(apiOpts.authMethod){
                if(apiOpts.authMethod == "oauth"){
                    messageDiv.innerHTML = EAPMOAuthNotice;
                }else{
                    messageDiv.innerHTML = EAPMBAsicAuthNotice;
                }
            }else{
                messageDiv.innerHTML = EAPMBAsicAuthNotice;
            }
        }
    }
}

function EAPMSetFieldRequired(fieldName, isRequired) {
    var formname = 'EditView';
    for(var i = 0; i < validate[formname].length; i++){
		if(validate[formname][i][0] == fieldName){
            validate[formname][i][2] = isRequired;
		}
    }
}

function EAPMEditStart(userIsAdmin) {
    var apiElem = document.getElementById('application');

    EAPM_url_validate = null;
    EAPM_name_validate = null;
    EAPM_password_validate = null;

    apiElem.onchange = EAPMChange;

    setTimeout(EAPMChange,100);
    
    if ( !userIsAdmin ) {
        // Disable the assigned user picker for non-admins
        document.getElementById('assigned_user_name').parentNode.innerHTML = document.getElementById('assigned_user_name').value;
    }

    // Disable the app picker if we are editing an existing record.
    if ( apiElem.form.record.value != '' ) {
        apiElem.disabled = true;
    }
}

var EAPMPopupCheckCount = 0;
function EAPMPopupCheck(newWin, popup_url, redirect_url, popup_warning_message) {
    if ( newWin == false || newWin == null || typeof newWin.close != 'function' || EAPMPopupCheckCount > 35 ) {
        // Opening the popup failed, redirect them to the popup_url
        alert(popup_warning_message);
        document.location = redirect_url;
        return;
    }
    
    if ( typeof(newWin.innerHeight) != 'undefined' && newWin.innerHeight != 0 ) {
        // Popup was successful
        document.location = redirect_url;
        return;
    }

    // If we are here, we don't know if it worked or not.
    EAPMPopupCheckCount++;
    setTimeout(function() { EAPMPopupCheck(newWin, popup_url, redirect_url, popup_warning_message); },100);
}

function EAPMPopupAndRedirect(popup_url, redirect_url, popup_warning_message) {
    var newWin = false;

    try {
        newWin = window.open(popup_url + '&closeWhenDone=1&refreshParentWindow=1','_blank');
    } catch (e) {
        newWin = false;
    }

    EAPMPopupCheck(newWin, popup_url, redirect_url, popup_warning_message);
}