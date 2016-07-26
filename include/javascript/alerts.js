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
function Alerts(){}function AlertObj(){this.title="Alert",this.options={body:" ",url_redirect:null,target_module:null,type:"info"}}Alerts.prototype.replaceMessages=[],Alerts.prototype.enable=function(){return"Notification"in window?void Notification.requestPermission(function(e){"granted"===e?Alerts.prototype.show({title:"Desktop notifications are now enabled for this web browser."}):Alerts.prototype.show({title:"Desktop notifications are disabled for this web browser. Use your browser preferences to enable them again."})}):void Alerts.prototype.show({title:"This browser does not support desktop notifications"})},Alerts.prototype.requestPermission=function(){"Notification"in window&&Notification.requestPermission()},Alerts.prototype.show=function(e){if(Alerts.prototype.requestPermission(),"Notification"in window)if("granted"===Notification.permission){"undefined"!=typeof e.options&&("undefined"!=typeof e.options.target_module&&(e.options.icon="index.php?entryPoint=getImage&themeName="+SUGAR.themes.theme_name+"&imageName="+e.options.target_module+"s.gif"),"undefined"!=typeof e.options.type?e.options.type=e.options.type:e.options.type="info");var t=new Notification(e.title,e.options);"undefined"!=typeof e.options&&("undefined"!=typeof e.options.url_redirect&&(t.onclick=function(){window.open(e.options.url_redirect)}),t.onclose=function(){Alerts.prototype.addToManager(e)})}else{var o=e.title;"undefined"!=typeof e.options&&("undefined"!=typeof e.options.body&&(o+="\n"+e.options.body),o+=SUGAR.language.translate("app_strings","MSG_JS_ALERT_MTG_REMINDER_CALL_MSG")+"\n\n",confirm(o)?"undefined"!=typeof e.options&&"undefined"!=typeof e.options.url_redirect&&(window.location=e.options.url_redirect):Alerts.prototype.addToManager(e))}},Alerts.prototype.addToManager=function(e){var t,o,n,i="index.php",r=e.title,s=0,a="info";"undefined"!=typeof e.options&&("undefined"!=typeof e.options.url_redirect&&(o=e.options.url_redirect),"undefined"!=typeof e.options.body&&(t=e.options.body),"undefined"!=typeof e.options.target_module&&(n=e.options.target_module),"undefined"!=typeof e.options.type&&(a=e.options.type)),$.post(i,{module:"Alerts",action:"add",name:r,description:t,url_redirect:o,is_read:s,target_module:n,type:a}).done(function(e){}).fail(function(e){console.log(e)}).always(function(){Alerts.prototype.updateManager()})},Alerts.prototype.redirectToLogin=function(){var e=function(e){e=e.split("+").join(" ");for(var t,o={},n=/[?&]?([^=]+)=([^&]*)/g;t=n.exec(e);)o[decodeURIComponent(t[1])]=decodeURIComponent(t[2]);return o},t=e(document.location.search);return"Changenewpassword"!=t.entryPoint&&"Users"!=t.module&&"Login"!=t.action?(document.location.href="index.php?module=Users&action=Login&loginErrorMessage=LBL_SESSION_EXPIRED",!0):!1},Alerts.prototype.updateManager=function(){var e="index.php?module=Alerts&action=get&to_pdf=1";$.ajax(e).done(function(e){if("lost session"==e)return Alerts.prototype.redirectToLogin(),!1;for(replaceMessage in Alerts.prototype.replaceMessages)e=e.replace(Alerts.prototype.replaceMessages[replaceMessage].search,Alerts.prototype.replaceMessages[replaceMessage].replace);$("div#alerts").html(e),$("div.alerts").css("width","200px");var t=$("#alerts").find("div.module-alert").size();$(".alert_count").html(t),t>0?$(".alertsButton").removeClass("btn-").addClass("btn-danger"):$(".alertsButton").removeClass("btn-danger").addClass("btn-success")}).fail(function(){}).always(function(){})},Alerts.prototype.markAsRead=function(e){var t="index.php?module=Alerts&action=markAsRead&record="+e+"&to_pdf=1";$.ajax(t).done(function(e){Alerts.prototype.updateManager()}).fail(function(){}).always(function(){})},$(document).ready(function(){Alerts.prototype.replaceMessages=[{search:SUGAR.language.translate("app","MSG_JS_ALERT_MTG_REMINDER_CALL_MSG"),replace:""},{search:SUGAR.language.translate("app","MSG_JS_ALERT_MTG_REMINDER_MEETING_MSG"),replace:""}];var e=function(){Alerts.prototype.updateManager(),setTimeout(e,6e4)};setTimeout(e,2e3)});