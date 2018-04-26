{*
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

/*********************************************************************************

 ********************************************************************************/
*}

<div id='wiz_stage'>
<form  id="wizform" name="wizform" method="POST" action="index.php">
	<input type="hidden" name="module" value="Campaigns">
	<input type="hidden" id='action' name="action" value='WizardNewsletter'>
	<input type="hidden" id="return_module" name="return_module" value="Campaigns">
	<input type="hidden" id="return_action" name="return_action" value="WizardHome">


	
<table class='other view' cellspacing="1">
<tr>


	<td  rowspan='2' width='100%' class='edit view'>
		<div id="wiz_message"></div>


		<div id=wizard class="wizard-unique-elem">


			<div id='step1' >
				<table border="0" cellpadding="0" cellspacing="0" width="100%">

					<tr>
						<td colspan='2' >
							<fieldset>
								<legend>{$MOD.LBL_HOME_START_MESSAGE}</legend>
								<p style="display: none;">
									<input type="radio"  id="wizardtype_nl" name="wizardtype" value='1'checked ><label for='wizardtype_nl'>{$MOD.LBL_NEWSLETTER}</label><br>
									<input type="radio"  id="wizardtype_em" name="wizardtype" value='2'><label for='wizardtype_em'>{$MOD.LBL_EMAIL}</label><br>
									<input type="radio"  id="wizardtype_ot" name='wizardtype' value='3'><label for='wizardtype_ot'>{$MOD.LBL_OTHER_TYPE_CAMPAIGN}</label><br>
									<input type="radio"  id="wizardtype_survey" name='wizardtype' value='4'><label for='wizardtype_survey'>{$MOD.LBL_CAMPAIGN_SURVEY}</label><br>
								</p>



								<ul class="icon-btn-lst">
									<li class="icon-btn">
										<a href="javascript:" onclick="$('#wizardtype_nl').click(); $(this).closest('form').submit();" title="{$MOD.LBL_NEWSLETTER_TITLE}">
											<span class="suitepicon suitepicon-action-view-news"></span>
											<br />
											<span>{$MOD.LBL_NEWSLETTER}</span>
										</a>
									</li>

									<li class="icon-btn">
										<a href="javascript:" onclick="$('#wizardtype_em').click(); $(this).closest('form').submit();" title="{$MOD.LBL_EMAIL_TITLE}">
											<span class="suitepicon suitepicon-module-emails"></span>
											<br />
											<span>{$MOD.LBL_EMAIL}</span>
										</a>
									</li>

									<li class="icon-btn">
										<a href="javascript:" onclick="$('#wizardtype_ot').click(); $(this).closest('form').submit();" title="{$MOD.LBL_NON_EMAIL_TITLE}">
											<span class="suitepicon suitepicon-action-megaphone"></span>
											<br />
											<span>{$MOD.LBL_OTHER_TYPE_CAMPAIGN}</span>
										</a>
									</li>
									<li class="icon-btn">
										<a href="javascript:" onclick="$('#wizardtype_survey').click(); $(this).closest('form').submit();" title="{$MOD.LBL_CAMPAIGN_SURVEY}">
											<span class="suitepicon suitepicon-module-surveys"></span>
											<br />
											<span>{$MOD.LBL_CAMPAIGN_SURVEY}</span>
										</a>
									</li>
								</ul>

							</fieldset>
						</td>
					</tr>
				</table>
			</div>

		</div>


	
	</td>
</tr>
</table>



</form>



</div>



