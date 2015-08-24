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


*}

	{if $fields.reminder_time}
            	{assign var="REMINDER_TIME_OPTIONS" value=$fields.reminder_time.options}
	{/if}



{if $view == "EditView" || $view == "QuickCreate" || $view == "QuickEdit"}

	<div>
		<input type="button" value="Add Alert" class="add-alert">
	</div>
	<div class="setup-multiple-alerts">

	</div>
	<select name="reminder_time" style="visibility: hidden">
		{html_options options=$REMINDER_TIME_OPTIONS selected=$EMAIL_REMINDER_TIME}
	</select>
{literal}
	<script>
		var alertIndex = 0;

		$(document).ready(function() {
			// Load existing alerts
			var loadExistingAlert = function (options) {
				var setupMultipleAlerts = $('.setup-multiple-alerts');

				var alert = $('<div id="'+options.fields.id+'" data-type="alert"></div>')
						.attr('name', 'alert['+options.fields.id+']');
				var alertNewFlag = $('<input type="hidden" name="alerts['+ options.fields.id +'][flag]" value="existing">')
						.appendTo(alert);

				var alertTimeDiv = $('<div></div>')
						.appendTo(alert);

				var alertSubscribers = $('<div></div>')
						.appendTo(alert);

				var alertSubscribersToolbar = $('<div></div>')
						.appendTo(alert);

				var alertSubscribersToolbarButtons = $('<div></div>')
						.appendTo(alertSubscribersToolbar);

				var alertActions = $('<div></div>')
						.appendTo(alert);


				var alertAddAllSubscriberBtn = $('<button class="add-alert" id="alert_add_subscriber_btn['+options.fields.id+']">' +
						'<img src="themes/default/images/glyphicon-16/glyphicon-plus.png"> Add All Invitees</button>')
						.appendTo(alertSubscribersToolbarButtons);
				var alertTime = $('select[name=reminder_time]')
						.clone() // clone the reminder time options
						.attr('name', 'alerts['+options.fields.id+'][time]')
						.attr('style', ' ') // remove hidden style
						.appendTo(alertTimeDiv);

				var alertSubscribersList = $('<div></div>')
						.addClass('panel')
						.appendTo(alertSubscribers);

				var alertActionPopup =  $('<input type="checkbox" name="alert['+options.fields.id+'][action][send_popup]" ' +
						'id="alert_action_send_popup['+options.fields.id+']" value="0"> <label>Popup </label> ');
				var alertActionEmail =  $('<input type="checkbox" name="alert['+alertIndex+'][action][send_email]" ' +
						'id="alert_action_send_email['+options.fields.id+']" value="0"> <label>Email </label> ');

				alertActionPopup.appendTo(alertActions);
				alertActionEmail.appendTo(alertActions);

				var alertRemoveBtn =
						$(' <button class="add-alert" id="alert_remove_btn['+options.fields.id+']" title="Remove Alert">' +
								'<img src="themes/default/images/glyphicon-16/glyphicon-remove.png"></button> ')
								.appendTo(alertTimeDiv);

				alert.appendTo(setupMultipleAlerts);

				alertAddAllSubscriberBtn.button().click(function(e) {
					var invitees = $(alertSubscribers);
					$(invitees).empty();
					if(typeof GLOBAL_REGISTRY !== "undefined" &&
							typeof GLOBAL_REGISTRY.focus !== "undefined" &&
							typeof GLOBAL_REGISTRY.focus.users_arr !== "undefined") {
						jQuery.each(GLOBAL_REGISTRY.focus.users_arr, function(key, value) {
							var id, label, bean, li;

							if(value.module == 'User') {
								id = value.fields.id;
								label = value.fields.full_name;
								bean = value.module;
							} else if(value.module == 'Contact') {
								id = value.fields.id;
								label = value.fields.full_name;
								bean = value.module;
							} else if(value.module == 'Lead') {
								id = value.fields.id;
								label = value.fields.full_name;
								bean = value.module;
							}

							invitee = $('<button data-id="'+ id +'" data-bean="'+ bean +'">' +
									'<img src="index.php?entryPoint=getImage&amp;themeName=Suite R&amp;imageName='+ bean
									+'s.gif">' +
									' <label>'+ label +'</label>' +
									'<input type="hidden" name="alerts['+ options.fields.id +'][subscribers]['+id+'][id]" value="'+ id +'">' +
									'<input type="hidden" name="alerts['+ options.fields.id +'][subscribers]['+id+'][bean]" value="'+ bean +'">' +
									'<img src="themes/default/images/glyphicon-16/glyphicon-remove.png"></button>');

							invitees.append(invitee);

							invitee.click(function() {
								$(this).remove();
							})
						});
					}
					return false;
				});

			}


			jQuery.each(GLOBAL_REGISTRY.focus.alerts, function(key, alert) {
				loadExistingAlert(alert);
			});


			$('input[type=button].add-alert').click(function(e) {
				console.log('Add alert');

				var setupMultipleAlerts = $('.setup-multiple-alerts');

				var alert = $('<div id="'+alertIndex+'" data-type="alert"></div>')
						.attr('name', 'alert['+alertIndex+']');
				var alertNewFlag = $('<input type="hidden" name="alerts['+ alertIndex +'][flag]" value="new">')
						.appendTo(alert);

				var alertTimeDiv = $('<div></div>')
						.appendTo(alert);

				var alertSubscribers = $('<div></div>')
						.appendTo(alert);

				var alertSubscribersToolbar = $('<div></div>')
						.appendTo(alert);

				var alertSubscribersToolbarButtons = $('<div></div>')
						.appendTo(alertSubscribersToolbar);

				var alertActions = $('<div></div>')
						.appendTo(alert);


				var alertAddAllSubscriberBtn = $('<button class="add-alert" id="alert_add_subscriber_btn['+alertIndex+']">' +
						'<img src="themes/default/images/glyphicon-16/glyphicon-plus.png"> Add All Invitees</button>')
						.appendTo(alertSubscribersToolbarButtons);

//				var alertAddSubscriberBtn = $('<button class="add-alert" id="alert_add_subscriber_btn['+alertIndex+']">' +
//						'</button>')
//						.appendTo(alertSubscribersToolbarButtons);

//				var alertSubscriberList = $('<ul class="alert-subscriber-list"></ul>')
//						.appendTo(alertSubscribersToolbar);

				var alertTime = $('select[name=reminder_time]')
						.clone() // clone the reminder time options
						.attr('name', 'alerts['+alertIndex+'][time]')
						.attr('style', ' ') // remove hidden style
						.appendTo(alertTimeDiv);

				var alertSubscribersList = $('<div></div>')
						.addClass('panel')
						.appendTo(alertSubscribers);

				var alertActionPopup =  $('<input type="checkbox" name="alerts['+alertIndex+'][action][send_popup]" ' +
						'id="alert_action_send_popup['+alertIndex+']" value="1"> <label>Popup </label> ');
				var alertActionEmail =  $('<input type="checkbox" name="alerts['+alertIndex+'][action][send_email]" ' +
						'id="alert_action_send_email['+alertIndex+']" value="1"> <label>Email </label> ');

				alertActionPopup.appendTo(alertActions);
				alertActionEmail.appendTo(alertActions);

				var alertRemoveBtn =
						$(' <button class="add-alert" id="alert_remove_btn['+alertIndex+']" title="Remove Alert">' +
								'<img src="themes/default/images/glyphicon-16/glyphicon-remove.png"></button> ')
								.appendTo(alertTimeDiv);

				alert.appendTo(setupMultipleAlerts);


				// events
				alertRemoveBtn.click(function(e) {
					$(this).parent().parent().remove();
					return false;
				});

				alertAddAllSubscriberBtn.button().click(function(e) {
					var invitees = $(alertSubscribers);
					$(invitees).empty();
					if(typeof GLOBAL_REGISTRY !== "undefined" &&
							typeof GLOBAL_REGISTRY.focus !== "undefined" &&
							typeof GLOBAL_REGISTRY.focus.users_arr !== "undefined") {
						jQuery.each(GLOBAL_REGISTRY.focus.users_arr, function(key, value) {
							var id, label, bean, li;

							if(value.module == 'User') {
								id = value.fields.id;
								label = value.fields.full_name;
								bean = value.module;
							} else if(value.module == 'Contact') {
								id = value.fields.id;
								label = value.fields.full_name;
								bean = value.module;
							} else if(value.module == 'Lead') {
								id = value.fields.id;
									label = value.fields.full_name;
									bean = value.module;
							}

							invitee = $('<button data-id="'+ id +'" data-bean="'+ bean +'">' +
									'<img src="index.php?entryPoint=getImage&amp;themeName=Suite R&amp;imageName='+ bean
									+'s.gif">' +
									' <label>'+ label +'</label>' +
									'<input type="hidden" name="alerts['+ alertIndex +'][subscribers]['+id+'][id]" value="'+ id +'">' +
									'<input type="hidden" name="alerts['+ alertIndex +'][subscribers]['+id+'][bean]" value="'+ bean +'">' +
									'<img src="themes/default/images/glyphicon-16/glyphicon-remove.png"></button>');

							invitees.append(invitee);

							invitee.click(function() {
								$(this).remove();
							})
						});
					}
					return false;
				});

//				alertAddSubscriberBtn.button({
//					text: false,
//					icons: {
//						primary: "ui-icon-triangle-1-s"
//					}
//				}).click(function() {
//						var menu = $( this ).parent().next().show().position({
//							my: "left top",
//							at: "left bottom",
//							of: this
//						});
//						$( document ).one( "click", function() {
//							menu.hide();
//						});
//						return false;
//					})
//					.parent()
//					.buttonset()
//					.next()
//					.hide()
//					.menu();

				var event = $(document);
				event.trigger("display:SugarWidgetScheduleRow");
				alertAddAllSubscriberBtn.trigger('click');
				alertIndex++;
			});

			$(document).on('display:SugarWidgetScheduleRow', function(e) {
				console.log('added row');
				$('ul.alert-subscriber-list').each(function(key, value) {
					var ul = $(this);
					$(this).empty();
					if(typeof GLOBAL_REGISTRY !== "undefined" &&
						typeof GLOBAL_REGISTRY.focus !== "undefined" &&
						typeof GLOBAL_REGISTRY.focus.users_arr !== "undefined") {
						jQuery.each(GLOBAL_REGISTRY.focus.users_arr, function(key, value) {
							var id, label, bean, li;

							if(value.module == 'User') {
								id = value.fields.full_name;
								label = value.fields.full_name;
								bean = value.module;
							} else if(value.module == 'Contact') {
								id = value.fields.full_name;
								label = value.fields.full_name;
								bean = value.module;
							} else if(value.module == 'Lead') {
								id = value.fields.full_name,
								label = value.fields.full_name,
								bean = value.module;
							}

							li = $('<li data-id="'+ id +'" data-bean="'+ bean +'">' +
									'<img src="index.php?entryPoint=getImage&amp;themeName=Suite R&amp;imageName='+ bean
									+'s.gif">' +
									'<label>'+ label +'</label></li>');
							ul.append(li);
						});
					}
				});
			})
		});
	</script>
{/literal}
	{else}

	{/if}
