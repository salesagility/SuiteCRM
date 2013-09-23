/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
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
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/

SUGAR.email2 = {
    cache : new Object(),
    o : null, // holder for reference to AjaxObject's return object (used in composeDraft())
    reGUID : new RegExp(/\w{8}-\w{4}-\w{4}-\w{4}-\w{12}/i),
    templates : {},
    tinyInstances : {
        currentHtmleditor : ''
    },

    /**
     * preserves hits from email server
     */ 
    _setDetailCache : function(ret) {
        if(ret.meta) {
            var compKey = ret.meta.mbox + ret.meta.uid;

            if(!SUGAR.email2.cache[compKey]) {
                SUGAR.email2.cache[compKey] = ret;
            }
        }
    },

    autoSetLayout : function() {
    	var c = document.getElementById('container');
        var tHeight = YAHOO.util.Dom.getViewportHeight() - YAHOO.util.Dom.getY(c) - 35;
        //Ensure a minimum height.
        tHeight = Math.max(tHeight, 550);
        c.style.height = tHeight + "px";
        SUGAR.email2.complexLayout.set('height', tHeight);
        SUGAR.email2.complexLayout.set('width', YAHOO.util.Dom.getViewportWidth() - 40);
        SUGAR.email2.complexLayout.render();
        SUGAR.email2.listViewLayout.resizePreview();        
    }
};


/**
 * Shows overlay progress message
 */

//overlayModal
SUGAR.showMessageBoxModal = function(title, body) {
    SUGAR.showMessageBox(title, body);
}

//overlay
SUGAR.showMessageBox = function(reqtitle, body, type, additconfig) {
    var config = { };
    if (typeof(additconfig) == "object") {
        var config = additconfig;
    }
    config.type = type;
    config.title = reqtitle;
    config.msg = body;
    YAHOO.SUGAR.MessageBox.show(config);
}

//hideOverlay
SUGAR.hideMessageBox = function() {
	YAHOO.SUGAR.MessageBox.hide();
};
