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
function hide(divname){var elem1=document.getElementById(divname);elem1.style.display='none';}
function show(div){var elem1=document.getElementById(div);elem1.style.display='';}
function showdiv(div){hideall();show(div);}
function hideall(){var last_val=document.getElementById('wiz_total_steps');var last=parseInt(last_val.value);for(i=1;i<=last;i++){hide('step'+i);}}
function showfirst(wiz_mode){showdiv('step1');var current_step=document.getElementById('wiz_current_step');current_step.value="1";var save_button=document.getElementById('wiz_submit_button');var next_button=document.getElementById('wiz_next_button');var save_button_div=document.getElementById('save_button_div');var next_button_div=document.getElementById('next_button_div');var back_button_div=document.getElementById('back_button_div');save_button.disabled=true;back_button_div.style.display='none';save_button_div.style.display='none';next_button.focus();if(wiz_mode=='marketing'){back_button_div.style.display='';}
hilite(current_step.value);}
function navigate(direction){var current_step=document.getElementById('wiz_current_step');var currentValue=parseInt(current_step.value);if(validate_wiz(current_step.value,direction)){if(direction=='back'){current_step.value=currentValue-1;}
if(direction=='next'){current_step.value=currentValue+1;}
if(direction=='direct'){}
showdiv("step"+current_step.value);hilite(current_step.value);var total=document.getElementById('wiz_total_steps').value;var save_button=document.getElementById('wiz_submit_button');var back_button_div=document.getElementById('back_button_div');var save_button_div=document.getElementById('save_button_div');var next_button_div=document.getElementById('next_button_div');if(current_step.value==total){save_button.disabled=false;back_button_div.style.display='';save_button_div.style.display='';next_button_div.style.display='none';}else{if(current_step.value<2){back_button_div.style.display='none';}else{back_button_div.style.display='';}
var next_button=document.getElementById('wiz_next_button');next_button_div.style.display='';save_button_div.style.display='none';next_button.focus();}}else{}}
var already_linked='';function hilite(hilite){var last=parseInt(document.getElementById('wiz_total_steps').value);for(i=1;i<=last;i++){var nav_step=document.getElementById('nav_step'+i);nav_step.className='';}
var nav_step=document.getElementById('nav_step'+hilite);nav_step.className='';if(already_linked.indexOf(hilite)<0){nav_step.innerHTML="<a href='#'  onclick=\"javascript:direct('"+hilite+"');\">"+nav_step.innerHTML+"</a>";already_linked+=',hilite';}}
function link_navs(beg,end){if(beg==''){beg=1;}
if(end==''){var last=document.getElementById('wiz_total_steps').value;end=last;}
beg=parseInt(beg);end=parseInt(end);for(i=beg;i<=end;i++){var nav_step=document.getElementById('nav_step'+i);nav_step.innerHTML="<a href='#'  onclick=\"javascript:direct('"+i+"');\">"+nav_step.innerHTML+"</a>";}}
function direct(stepnumber){var current_step=document.getElementById('wiz_current_step');var currentValue=parseInt(current_step.value);if(validate_wiz(current_step.value,'direct')){current_step.value=stepnumber;navigate('direct');}else{}}
function validate_wiz(step,direction){var total=document.getElementById('wiz_total_steps').value;var wiz_message=document.getElementById('wiz_message');if(direction=='back'){if(step=='1'){var msg=SUGAR.language.get('mod_strings','LBL_WIZARD_FIRST_STEP_MESSAGE');wiz_message.innerHTML="<font color=\'red\' size=\'2\'><b>"+msg+"</b></font>";return false;}else{wiz_message.innerHTML='';}}
if(direction=='next'){if(step==total){var msg=SUGAR.language.get('mod_strings','LBL_WIZARD_LAST_STEP_MESSAGE');wiz_message.innerHTML="<font color=\'red\' size=\'2\'><b>"+msg+"</b></font>";return false;}else{wiz_message.innerHTML='';}}
if(direction=='direct'){}
if((direction!='direct')&&(window.validate_wiz_form)&&(!validate_wiz_form('step'+step))){return false;}
return true;}