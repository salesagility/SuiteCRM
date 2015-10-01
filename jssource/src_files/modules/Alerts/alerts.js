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
 * Extends Alert notifications:
 *
 * * Enables Desktop Notifications API when available. Falls back to
 * the standard alert/confirm.
 *
 * * Manages the alert notification manager in the top menu bar next the username.
 * All alert notifications that have not been actioned are listed in the alert notification manager
 * at the top of the page next to the username.
 *
 * @constructor:
 *
 */
function Alerts() {};

/**
 * Requests to enable Desktop Notifications API when available.
 * Then notifies the user of the result
 *
 * Support note:
 * * Desktop Notifications are managed through the browser settings.
 * * A User can block notifications.
 * * Each browser must have Desktop Notifications API available for it to work.
 * * This class is limited by the javascript security same origin policy.
 */
Alerts.prototype.enable = function() {
    if (!("Notification" in window)) {
        Alerts.prototype.show({title: "This browser does not support desktop notifications"});
        return;
    }

    Notification.requestPermission(
        function (permission) {
            if (permission === "granted") {
                Alerts.prototype.show({title: "Desktop notifications are now enabled for this web browser."});
            }
            else {
                Alerts.prototype.show({title: "Desktop notifications are disabled for this web browser. Use your browser preferences to enable them again."});
            }
        }
    );
}

/**
 * Requests to enable Desktop Notifications API when available.
 *
 * Support note:
 * * Desktop Notifications are managed through the browser settings.
 * * A User can block notifications.
 * * Each browser must have Desktop Notifications API available for it to work.
 * * This class is limited by the javascript security same origin policy.
 */
Alerts.prototype.requestPermission = function() {
    if (!("Notification" in window)) {
        return;
    }

    Notification.requestPermission();
}

/**
 * Shows an alert notification
 *
 * @param: AlertObj - Alert Object Structure - See AlertObj();
 *
 */
Alerts.prototype.show = function(AlertObj) {
    Alerts.prototype.requestPermission();
    if (("Notification" in window)) {
        // Use Desktop Notifications
        if (Notification.permission === "granted") {
            if(typeof AlertObj.options !== "undefined") {
                if(typeof AlertObj.options.target_module !== "undefined") {
                    AlertObj.options.icon = 'index.php?entryPoint=getImage&themeName=' + SUGAR.themes.theme_name+'&imageName='+AlertObj.options.target_module+'s.gif';
                }
                if(typeof AlertObj.options.type !== "undefined") {
                    AlertObj.options.type = AlertObj.options.type;
                }
                else {
                    AlertObj.options.type = 'info';
                }
            }

            var notification = new Notification(AlertObj.title, AlertObj.options);
            if(typeof AlertObj.options !== "undefined") {
                if(typeof AlertObj.options.url_redirect!== "undefined") {
                    notification.onclick = function () {
                        window.open(AlertObj.options.url_redirect);
                    }
                }
                notification.onclose = function () {
                    Alerts.prototype.addToManager(AlertObj);
                }
            }
        }
        else {
            // Use Browser Notifications
            var message = AlertObj.title;
            if(typeof AlertObj.options !== "undefined") {
                if(typeof AlertObj.options.body !== "undefined") {
                    message += '\n' + AlertObj.options.body;
                }

                message += SUGAR.language.translate('app_strings', 'MSG_JS_ALERT_MTG_REMINDER_CALL_MSG') + "\n\n";
                if(confirm(message)) {
                    if(typeof AlertObj.options !== "undefined") {
                        if (typeof AlertObj.options.url_redirect !== "undefined") {
                            window.location = AlertObj.options.url_redirect;
                        }
                    }
                }
                else {
                    Alerts.prototype.addToManager(AlertObj);
                }
            }
        }
    }
}

/**
 * Adds Alert object structure to the alert notification manager
 *
 * @arg:  AlertObj - See: AlertObj()
 *
 */
Alerts.prototype.addToManager = function(AlertObj) {
    var url = 'index.php',
        name = AlertObj.title,
        description,
        url_redirect,
        is_read = 0,
        target_module,
        type = 'info';

    if(typeof AlertObj.options !== "undefined") {
        if (typeof AlertObj.options.url_redirect!== "undefined") {
            url_redirect = AlertObj.options.url_redirect
        }
        if (typeof AlertObj.options.body !== "undefined") {
            description = AlertObj.options.body
        }
        if (typeof AlertObj.options.target_module !== "undefined") {
            target_module = AlertObj.options.target_module
        }
        if (typeof AlertObj.options.type !== "undefined") {
            type = AlertObj.options.type
        }
    }

    $.post(url,
        {
            module: 'Alerts',
            action: 'add',
            name: name,
            description: description,
            url_redirect: url_redirect,
            is_read: is_read,
            target_module: target_module,
            type: type
        }
    ).done(function(data) {
            if(data.redirect) {
                Alerts.prototype.refreshPeriod = -1;
            }
    }).fail(function(data) {
            console.log(data);
    }).always(function() {
            Alerts.prototype.updateManager();
    });
}

/**
 * Updates the alert notification manager
 */
Alerts.prototype.updateManager = function() {
    var url = 'index.php?module=Alerts&action=get&to_pdf=1';
    $.ajax(url).done(function(data, textStatus, jqXHR) {

        // Detect if use is logged out by looking for the login form
        if($('form.form-signin').length > 0) {
            Alerts.prototype.refreshPeriod = -1;
            return;
        }

        $('div#alerts').html(data);
        $('div.alerts').css('width', '200px');

        var alertCount = $('#alerts').find('div.module-alert').size();
        $('.alert_count').html(alertCount);

        if(alertCount > 0) {
            $('.alertsButton').removeClass('btn-').addClass('btn-danger');
        }
        else {
            $('.alertsButton').removeClass('btn-danger').addClass('btn-success');
        }
    }).fail(function() {
    }).always(function() {
    });
}

/**
 * Tell the alert notification manager to mark an a alert as read
 *
 * @arg: id - ID of the alert
 *
 */
Alerts.prototype.markAsRead = function(id) {
    var url = 'index.php?module=Alerts&action=markAsRead&record='+id+'&to_pdf=1';
    $.ajax(url).done(function(data) {
        Alerts.prototype.updateManager();
    }).fail(function() {
    }).always(function() {
    });
}

Alerts.prototype.refreshPeriod = 60000;
/**
 * Alert structure
 * @constructor
 * title: 'The alert title';
 *      options: {
 *                  body: 'message body';
 *                  url_redirect: 'url to redirect to on click action';
 *                  target_module: 'this module that alert it related to eg meeting, call etc... sets up the icon';
 *                  type: 'success|warning|danger|info'
 *             }
 */
function AlertObj() {
    this.title = 'Alert';
    this.options = {
        body: ' ',
        url_redirect: null,
        target_module: null,
        type: 'info'
    };
}

/**
 * Wait for document to be ready before updating the alert notification manager.
 */
$(document).ready(function() {
    var updateMissed  = function() {
        Alerts.prototype.updateManager();
        if(Alerts.prototype.refreshPeriod != -1) {
            setTimeout(updateMissed, Alerts.prototype.refreshPeriod);
        }
    }
    updateMissed();
});