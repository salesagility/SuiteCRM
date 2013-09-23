{if false}
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



{/if}

<script type="text/javascript" language="Javascript" src="{sugar_getjspath file='modules/UpgradeWizard/upgradeWizard.js'}"></script>

{$UW_JS}

<div id="title">
{$UW_TITLE}
</div>

<div id="progress" style="display:none;">
{$UW_PROGRESS}
</div>

<div id="message" style="display:none;">
{$UW_MESSAGE}
</div>

<div id="nav">
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td>
<form action="index.php" method="post" name="UpgradeWizardForm" id="form">
	<input type="hidden" name="module" value="UpgradeWizard">
	<input type="hidden" name="action" value="index">
	<input type="hidden" name="step" id="step" value="{$UW_STEP}">
	<input type="hidden" name="overwrite_files" id="over">
	<input type="hidden" name="schema_change" id="schema">
	<input type="hidden" name="schema_drop"   id="schema_drop">
	<input type="hidden" name="overwrite_files_serial" id="overwrite_files_serial">
	<input type="hidden" name="addTaskReminder" id="addTaskReminder">
	<input type="hidden" name="addEmailReminder" id="addEmailReminder">
    {if !isset($includeContainerCSS) || $includeContainerCSS}
    <link rel='stylesheet' type='text/css' href="{sugar_getjspath file='include/javascript/yui/assets/container.css'}" />
        {if $step == 'commit'}
    <link rel='stylesheet' type='text/css' href="{sugar_getjspath file='include/javascript/yui/build/container/assets/container.css'}"/>
    <link rel='stylesheet' type='text/css' href="{sugar_getjspath file='themes/default/css/yui.css'}"/>
       {/if}
    {/if}
		{if $showBack}
			<input	title		= "{$MOD.LBL_BUTTON_BACK}"
					class		= "button"
					onclick		= "document.getElementById('form').step.value='{$STEP_BACK}';"
					type		= "submit"
					value		= "  {$MOD.LBL_BUTTON_BACK}  ">
		{/if}
		{if $showNext}
			<input	title		= "{$MOD.LBL_BUTTON_NEXT}"
					class		= "button"
					{$disableNextForLicense}
 					onclick	= " handleUploadCheck('{$step}', {$u_allow}); if(!{$u_allow}) return; upgradeP('{$step}', false);document.getElementById('form').step.value='{$STEP_NEXT}'; handlePreflight('{$step}'); document.getElementById('form').submit();"
					type		= "button"
					value		= "  {$MOD.LBL_BUTTON_NEXT}  "
					id			= "next_button" >
		{/if}
		{if $showCancel}
			<input	title		= "{$MOD.LBL_BUTTON_CANCEL}"
					class		= "button"
				{if $step == 'start'}
					{**** if this is the first step, cancel should take you to administration screen ****}
					onclick		= "document.location.href='index.php?module=Administration&action=index';"
					type		= "button"
				{else}
					onclick		= "cancelUpgrade();document.getElementById('form').step.value='{$STEP_CANCEL}';"
					type		= "submit"
				{/if}
					value		= "  {$MOD.LBL_BUTTON_CANCEL}  ">
		{/if}
		{if $showRecheck}
			<input	title		= "{$MOD.LBL_BUTTON_RECHECK}"
					class		= "button"
					onclick		= "upgradeP('{$step}', true);document.getElementById('form').step.value='{$STEP_RECHECK}';"
					type		= "submit"
					value		= "  {$MOD.LBL_BUTTON_RECHECK}  ">
		{/if}
		{if $showDone}
			<input	title		= "{$MOD.LBL_BUTTON_DONE}"
					class		= "button"
					onclick		= "deleteCacheAjax();window.location.href='index.php?module=Home&action=About';"
					type		= "button"
					value		= "  {$MOD.LBL_BUTTON_DONE}  ">
		{/if}
		{if $showExit}
			<input	title		= "{$MOD.LBL_BUTTON_EXIT}"
					class		= "button"
					onclick		= "window.location.href='index.php?module=Administration&action=index';"
					type		= "button"
					value		= "  {$MOD.LBL_BUTTON_EXIT}  ">
		{/if}

</form>
		</td>
	</tr>
</table>
</div>

<div id="main">
<table width="100%" border="0" cellpadding="0" cellpadding="0"
    class="{if !isset($includeContainerCSS) || $includeContainerCSS}tabDetailView{else}detail view small{/if}">
{if $step != "start" && $step != "cancel" && $step != "end"}
	<tr>
		<td id=error_messages colspan="2">
			<div id="top_message">{$top_message}</div>
		</td>
	</tr>
{/if}
	<tr>
		<td width="25%" rowspan="2" {if !isset($includeContainerCSS) || $includeContainerCSS}class="tabDetailViewDL"{else}scope="row"{/if}><slot>
			{$CHECKLIST}
		</slot></td>
		<td width="75%" {if !isset($includeContainerCSS) || $includeContainerCSS}class="tabDetailViewDF"{/if}><slot>
			{$UW_MAIN}&nbsp;
		</slot></td>
	</tr>
{if $step == "upload"}
	<tr>
		<td valign="top" {if !isset($includeContainerCSS) || $includeContainerCSS}class="tabDetailViewDF"{/if}>
			&nbsp;<br />
			{$UW_HISTORY}
		</td>
	</tr>
{/if}
</table>
</div>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td>
<form action="index.php" method="post" name="UpgradeWizardForm" id="form">
	<input type="hidden" name="module" value="UpgradeWizard">
	<input type="hidden" name="action" value="index">
	<input type="hidden" name="step" value="{$UW_STEP}">
	<input type="hidden" name="overwrite_files" id="over">
	<input type="hidden" name="schema_change" id="schema">
	<input type="hidden" name="schema_drop"   id="schema_drop">
	<input type="hidden" name="overwrite_files_serial" id="overwrite_files_serial">
	<input type="hidden" name="addTaskReminder" id="addTaskReminder">
	<input type="hidden" name="addEmailReminder" id="addEmailReminder">
    {if !isset($includeContainerCSS) || $includeContainerCSS}
    <link rel='stylesheet' type='text/css' href='include/javascript/yui/assets/container.css' />
        {if $step == 'commit'}
    <link rel='stylesheet' type='text/css' href='include/javascript/yui/build/container/assets/container.css'/>
    <link rel='stylesheet' type='text/css' href='themes/default/css/yui.css'/>
       {/if}
    {/if}
		{if $showBack}
			<input	title		= "{$MOD.LBL_BUTTON_BACK}"
					class		= "button"
					onclick		= "document.getElementById('form').step.value='{$STEP_BACK}';"
					type		= "submit"
					value		= "  {$MOD.LBL_BUTTON_BACK}  ">
		{/if}
		{if $showNext}
			<input	title		= "{$MOD.LBL_BUTTON_NEXT}"
					class		= "button"
					{$disableNextForLicense}
 					onclick	= " handleUploadCheck('{$step}', {$u_allow}); if(!{$u_allow}) return; upgradeP('{$step}', false);document.getElementById('form').step.value='{$STEP_NEXT}'; handlePreflight('{$step}'); document.getElementById('form').submit();"
					type		= "button"
					value		= "  {$MOD.LBL_BUTTON_NEXT}  "
					id			= "next_button" >
		{/if}
		{if $showCancel}
			<input	title		= "{$MOD.LBL_BUTTON_CANCEL}"
					class		= "button"
				{if $step == 'start'}
					{**** if this is the first step, cancel should take you to administration screen ****}
					onclick		= "document.location.href='index.php?module=Administration&action=index';"
					type		= "button"
				{else}
					onclick		= "cancelUpgrade();document.getElementById('form').step.value='{$STEP_CANCEL}';"
					type		= "submit"
				{/if}
					value		= "  {$MOD.LBL_BUTTON_CANCEL}  ">
		{/if}
		{if $showRecheck}
			<input	title		= "{$MOD.LBL_BUTTON_RECHECK}"
					class		= "button"
					onclick		= "upgradeP('{$step}', true);document.getElementById('form').step.value='{$STEP_RECHECK}';"
					type		= "submit"
					value		= "  {$MOD.LBL_BUTTON_RECHECK}  ">
		{/if}
		{if $showDone}
			<input	title		= "{$MOD.LBL_BUTTON_DONE}"
					class		= "button"
					onclick		= "deleteCacheAjax();window.location.href='index.php?module=Home&action=About';"
					type		= "button"
					value		= "  {$MOD.LBL_BUTTON_DONE}  ">
		{/if}
		{if $showExit}
			<input	title		= "{$MOD.LBL_BUTTON_EXIT}"
					class		= "button"
					onclick		= "window.location.href='index.php?module=Administration&action=index';"
					type		= "button"
					value		= "  {$MOD.LBL_BUTTON_EXIT}  ">
		{/if}

</form>
		</td>
	</tr>
</table>


<script>

UPGRADE_PROGRESS = '{$MOD.LBL_UPGRADE_IN_PROGRESS}';
TIME_ELAPSED = "{$MOD.LBL_UPGRADE_TIME_ELAPSED}";
START_IN_PROGRESS = "{$MOD.LBL_START_UPGRADE_IN_PROGRESS}";
SYSTEM_CHECK_IN_PROGRESS = "{$MOD.LBL_SYSTEM_CHECKS_IN_PROGRESS}";
LICENSE_CHECK_IN_PROGRESS = "{$MOD.LBL_LICENSE_CHECK_IN_PROGRESS}";
PREFLIGHT_CHECK_IN_PROGRESS ="{$MOD.LBL_PREFLIGHT_CHECK_IN_PROGRESS}";
COMMIT_UPGRADE_IN_PROGRESS ="{$MOD.LBL_COMMIT_UPGRADE_IN_PROGRESS}";
UPGRADE_SUMMARY_IN_PROGRESS ="{$MOD.LBL_UPGRADE_SUMMARY_IN_PROGRESS}";
UPGRADE_SCRIPTS_IN_PROGRESS ="{$MOD.LBL_UPGRADE_SCRIPTS_IN_PROGRESS}";
SET_STEP_TO_COMPLETE = "{$MOD.LBL_UW_COMPLETE}";
UPLOADE_UPGRADE_IN_PROGRESS= "{$MOD.LBL_UPLOADE_UPGRADE_IN_PROGRESS}";
UPLOADING_UPGRADE_PACKAGE = "{$MOD.LBL_UPLOADING_UPGRADE_PACKAGE}";
UPGRADE_CANCEL_IN_PROGRESS ="{$MOD.LBL_UPGRADE_CANCEL_IN_PROGRESS}";
PREFLIGHT_FILE_COPYING_PROGRESS = "{$MOD.LBL_PREFLIGHT_FILE_COPYING_PROGRESS}";
{literal}
var msgPanel;
var c=0
var s=0
var t
var currStage
var timeOutWindowMultiplier = 1
var timeOutWindow = 60
function upgradeP(step, recheck){
//if(step == 'systemCheck'){
//	return;
//}

if(document.getElementById("upgradeDiv") != null){
	    var args = {    width:"300px",
	                    modal:true,
	                    //xy:[400,300],
	                    fixedcenter: true,
	                    constraintoviewport: false,
	                    underlay:"shadow",
	                    close:false,
	                    draggable:true,
	                    effect:{effect:YAHOO.widget.ContainerEffect.FADE, duration:.5}
	                   } ;
	            msg_panel = new YAHOO.widget.Panel('p_msg', args);
	            //If we haven't built our panel using existing markup,
	            //we can set its content via script:

				if(step == 'start' || step == 'systemCheck'){
                	//currStage = START_IN_PROGRESS;
                	currStage = SYSTEM_CHECK_IN_PROGRESS;
                }
                /* removed window from system check. if you need to add back, remove check at the top
                 * of this function as well
                if(step == 'systemCheck'){
                	currStage = UPLOADE_UPGRADE_IN_PROGRESS;
                	//document.getElementById(step).innerHTML='<i>'+SET_STEP_TO_COMPLETE+'</i>'
                }
                */
                if(step == 'uploadingUpgradePackage'){
                	currStage = UPLOADING_UPGRADE_PACKAGE;
                }
                if(step == 'license_fiveO'){
                	//currStage = LICENSE_CHECK_IN_PROGRESS;
                	currStage = PREFLIGHT_CHECK_IN_PROGRESS;
                	//document.getElementById(step).innerHTML='<i>'+SET_STEP_TO_COMPLETE+'</i>'
                }
                if(step == 'upload'){
                	//currStage = LICENSE_CHECK_IN_PROGRESS;
                	currStage = PREFLIGHT_CHECK_IN_PROGRESS;
                	//document.getElementById(step).innerHTML='<i>'+SET_STEP_TO_COMPLETE+'</i>'
                }
                if(step == 'preflight'){
                	if(recheck){
                    	currStage = PREFLIGHT_CHECK_IN_PROGRESS;
                	}
                	else{
	                	currStage = PREFLIGHT_FILE_COPYING_PROGRESS;
                	}
                	//document.getElementById(step).innerHTML='<i>'+SET_STEP_TO_COMPLETE+'</i>'
                }
                if(step == 'commit'){
                	currStage = UPGRADE_SCRIPTS_IN_PROGRESS;
                	//document.getElementById(step).innerHTML='<i>'+SET_STEP_TO_COMPLETE+'</i>'
                }
                if(step == 'layouts'){
                	currStage = UPGRADE_SUMMARY_IN_PROGRESS;
                	//document.getElementById(step).innerHTML='<i>'+SET_STEP_TO_COMPLETE+'</i>'
                }
	            msg_panel.setHeader(currStage);
	            msg_panel.setBody(document.getElementById("upgradeDiv").innerHTML);
	            //timedCount(currStage);
	            //msg_panel.setFooter('Time Elapsed '+s);
	            msg_panel.render(document.body);
	            msgPanel = msg_panel;
	    		msgPanel.show;
    }
    return;
}

function cancelUpgrade(){
if(document.getElementById("upgradeDiv") != null){
	    var args = {    width:"300px",
	                    modal:true,
	                    //xy:[400,300],
	                    fixedcenter: true,
	                    constraintoviewport: false,
	                    underlay:"shadow",
	                    close:false,
	                    draggable:true,
	                    effect:{effect:YAHOO.widget.ContainerEffect.FADE, duration:.5}
	                   } ;
	            msg_panel = new YAHOO.widget.Panel('p_msg', args);
	            //If we haven't built our panel using existing markup,
	            //we can set its content via script:

                currStage = UPGRADE_CANCEL_IN_PROGRESS;
                //document.getElementById(step).innerHTML='<i>'+SET_STEP_TO_COMPLETE+'</i>'
	            msg_panel.setHeader(currStage);
	            msg_panel.setBody(document.getElementById("upgradeDiv").innerHTML);
	            //timedCount(currStage);
	            //msg_panel.setFooter('Time Elapsed '+s);
	            msg_panel.render(document.body);
	            msgPanel = msg_panel;
	    		msgPanel.show;
    }
    return;
}

function timedCount(currStage)
{
      msg_panel.setFooter(TIME_ELAPSED+'   '+s);
      currStage = currStage+'   '+s;
      msg_panel.setHeader(currStage);
    	c=c+1
		s=c

		timeOutWindowMultiples = timeOutWindowMultiplier*timeOutWindow
		if(c == timeOutWindowMultiples){
		  updateUpgradeStepTime(timeOutWindow)
		  timeOutWindowMultiplier = timeOutWindowMultiplier+1
		}

		if(c<10){
		 	s='0'+c
		}

	  if(c>=60 && c<3600){
			 m=1
			 while(c>=((m+1)*60)){
			    m=m+1
			  }
			 secs= (c-(m*60))
			 if(m < 10){
			     m = '0'+m
			  }
			  if(secs < 10){
			     secs = '0'+secs
			  }
			  s=m+':'+ secs
		 }
		 if(c>=3600){
			  h=1;
			  while(c>=((h+1)*3600)){
			    h=h+1;
			   }
			  r= c-(h*3600)
			  m = 0
			  secs = 0
			  if(r>=60){
				 m=1;
				  while(r>=((m+1)*60)){
				     m=m+1;
				  }
				  secs =  (r-(m*60))
			    }
			    if(h < 10){
			       h = '0'+h
			     }
			     if(m < 10){
			       m = '0'+m
			     }
			     if(secs <10){
				     secs = '0'+ secs
				  }
			  s=h+':'+m+':'+ secs
		   }
		t=setTimeout("timedCount(currStage)",1000)
}
function updateUpgradeStepTime(ts){
  success = function(r) {
    	//making ajax call every three minutes to make sure the browser
    	//remains active
    }
   postData = 'upgradeStepTime=' + ts + '&module=UpgradeWizard&action=upgradeTimeCounter&to_pdf=1&sugar_body_only=1';
   var ajxProgress = YAHOO.util.Connect.asyncRequest('POST','index.php', {success: success, failure: success}, postData);
}
</script>
{/literal}


