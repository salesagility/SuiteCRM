DELETE FROM email_templates;

-- SinergiaCRM: example email templates

INSERT INTO `email_templates` (`id`, `date_entered`, `date_modified`, `modified_user_id`, `created_by`, `published`, `name`, `description`, `subject`, `body`, `body_html`, `deleted`, `assigned_user_id`, `text_only`, `type`) VALUES
('d3b49c38-eeba-b910-2590-5b4069caaac1', NOW(), NOW(), '1', '1', NULL, 'Example - Donation', 'Email template example for donation confirmation and acknowledgement', 'Thank you for your donation!', 'Dear $contact_first_name $contact_last_name,\r\n\r\nWe have successfully received your donation of $stic_payments_amount €.\r\n\r\nThank you very much for your support!\r\n\r\n', '<p>Dear $contact_first_name $contact_last_name,</p>\n<p>We have successfully received your donation of $stic_payments_amount €.</p>\n<p>Thank you for your support!</p>', 0, '1', 0, 'email'),
('dba65685-d26f-6ecd-802c-5b406983c9b5', NOW(), NOW(), '1', '1', NULL, 'Example - Registration', 'Email template example for registration confirmation', 'Registration confirmation to $stic_events_name', 'Dear $contact_first_name $contact_last_name,\r\n\r\nWe have successfully received your registration to $stic_events_name.\r\n\r\nOn $stic_registrations_registration_date your registration is $stic_registrations_status.\r\n\r\nSee you on $stic_events_start_date!', '<p>Dear $contact_first_name $contact_last_name,</p>\n<p>We have successfully received your registration to $stic_events_name.</p>\n<p>On $stic_registrations_registration_date your registration is $stic_registrations_status.</p>\n<p>See you on $stic_events_start_date!</p>', 0, '1', 0, 'email'),
('52cdc554-bd90-f8f9-e2e0-66d718ae8fe9', NOW(), NOW(), '1', '1', NULL, 'Example - New opportunity', 'Email template example for new opportunity notification', 'New opportunity: $opportunity_name', 'New opportunity: $opportunity_name\r\n\r\n$opportunity_stic_additional_information_c\r\nYou may find more information at: $opportunity_stic_opportunity_url_c', '<p>New opportunity: $opportunity_name</p><p></p><p>$opportunity_stic_additional_information_c</p><p>You may find more information at: $opportunity_stic_opportunity_url_c</p>', 0, '1', 0, 'notification'),
('9f118e85-13f2-baa9-4ee3-66d80c674dea', NOW(), NOW(), '1', '1', NULL, 'Example - New event', 'Email template example for new event notification', 'New event: $stic_events_name', '$stic_events_name\r\n\r\nStart date: $stic_events_start_date\r\nEnd date: $stic_events_end_date\r\nLocation: $stic_events_stic_events_fp_event_locations_name', '<p>$stic_events_name</p><p></p><p>Start date: $stic_events_start_date</p><p>End date: $stic_events_end_date</p><p>Location: $stic_events_stic_events_fp_event_locations_name</p>', 0, '1', 0, 'notification');

-- SuiteCRM Base: example email templates 
-- These are the same templates added in the SuiteCRMBase.sql file, but we add them here for symmetry with the other language files

INSERT INTO `email_templates` (`id`, `date_entered`, `date_modified`, `modified_user_id`, `created_by`, `published`, `name`, `description`, `subject`, `body`, `body_html`, `deleted`, `assigned_user_id`, `text_only`, `type`) VALUES
('14f18ded-378d-ab84-3237-5e830d4e874d', NOW(), NOW(), '1', '1', 'off', 'User Case Update', 'Email template to send to a Sugar user when their case is updated.', '$acase_name (# $acase_case_number) update', 'Hi $user_first_name $user_last_name,\n\n					   You''ve had an update to your case $acase_name (# $acase_case_number) on $aop_case_updates_date_entered:\n					       $contact_first_name $contact_last_name, said:\n					               $aop_case_updates_description\n                        You may review this Case at:\n                            $sugarurl/index.php?module=Cases&action=DetailView&record=$acase_id;', '<p>Hi $user_first_name $user_last_name,</p>\n					     <p> </p>\n					     <p>You''ve had an update to your case $acase_name (# $acase_case_number) on $aop_case_updates_date_entered:</p>\n					     <p><strong>$contact_first_name $contact_last_name, said:</strong></p>\n					     <p style="padding-left:30px;">$aop_case_updates_description</p>\n					     <p>You may review this Case at: $sugarurl/index.php?module=Cases&action=DetailView&record=$acase_id;</p>', 0, NULL, NULL, 'system'),
('267275d8-959c-6aed-8754-5e830d07fedf', NOW(), NOW(), '1', '1', 'off', 'Event Invite Template', 'Default event invite template.', 'You have been invited to $fp_events_name', 'Dear $contact_name,\nYou have been invited to $fp_events_name on $fp_events_date_start to $fp_events_date_end\n$fp_events_description\nYours Sincerely,\n', '\n<p>Dear $contact_name,</p>\n<p>You have been invited to $fp_events_name on $fp_events_date_start to $fp_events_date_end</p>\n<p>$fp_events_description</p>\n<p>If you would like to accept this invititation please click accept.</p>\n<p> $fp_events_link or $fp_events_link_declined</p>\n<p>Yours Sincerely,</p>\n', 0, NULL, NULL, 'system'),
('483e1c3b-51dc-b5ab-e220-5e830d52596a', NOW(), NOW(), '1', '1', 'off', 'Confirmed Opt In', 'Email template to send to a contact to confirm they have opted in.', 'Confirm Opt In', 'Hi $contact_first_name $contact_last_name, \\n Please confirm that you have opted in by selecting the following link: $sugarurl/index.php?entryPoint=ConfirmOptIn&from=$emailaddress_email_address', '<p>Hi $contact_first_name $contact_last_name,</p>\n             <p>\n                Please confirm that you have opted in by selecting the following link:\n                <a href="$sugarurl/index.php?entryPoint=ConfirmOptIn&from=$emailaddress_confirm_opt_in_token">Opt In</a>\n             </p>', 0, NULL, NULL, 'system'),
('b4477938-f3c4-bef6-292c-5e830dee6ceb', NOW(), NOW(), '1', '1', 'off', 'System-generated password email', 'This template is used when the System Administrator sends a new password to a user.', 'New account information', '\nHere is your account username and temporary password:\nUsername : $contact_user_user_name\nPassword : $contact_user_user_hash\n\n$config_site_url\n\nAfter you log in using the above password, you may be required to reset the password to one of your own choice.', '<div><table width="550"><tbody><tr><td><p>Here is your account username and temporary password:</p><p>Username : $contact_user_user_name </p><p>Password : $contact_user_user_hash </p><br /><p>$config_site_url</p><br /><p>After you log in using the above password, you may be required to reset the password to one of your own choice.</p>   </td>         </tr><tr><td></td>         </tr></tbody></table></div>', 0, NULL, 0, 'system'),
('bc4c87c3-febd-73d5-cf73-5e830dd3bac0', NOW(), NOW(), '1', '1', 'off', 'Forgot Password email', 'This template is used to send a user a link to click to reset the user''s account password.', 'Reset your account password', '\nYou recently requested on $contact_user_pwd_last_changed to be able to reset your account password.\n\nClick on the link below to reset your password:\n\n$contact_user_link_guid', '<div><table width="550"><tbody><tr><td><p>You recently requested on $contact_user_pwd_last_changed to be able to reset your account password. </p><p>Click on the link below to reset your password:</p><p> $contact_user_link_guid </p>  </td>         </tr><tr><td></td>         </tr></tbody></table></div>', 0, NULL, 0, 'system'),
('c4440a38-10b9-ef63-0e40-5e830d1c293d', NOW(), NOW(), '1', '1', 'off', 'Two Factor Authentication email', 'This template is used to send a user a code for Two Factor Authentication.', 'Two Factor Authentication Code', 'Two Factor Authentication code is $code.', '<div><table width="550"><tbody><tr><td><p>Two Factor Authentication code is <b>$code</b>.</p>  </td>         </tr><tr><td></td>         </tr></tbody></table></div>', 0, NULL, 0, 'system'),
('c6c4093f-0a1a-30d8-5e33-5e830d6ddd51', NOW(), NOW(), '1', '1', 'off', 'Contact Case Update', 'Template to send to a contact when their case is updated.', '$acase_name update [CASE:$acase_case_number]', 'Hi $user_first_name $user_last_name,\n\n					   You''ve had an update to your case $acase_name (# $acase_case_number) on $aop_case_updates_date_entered:\n					       $contact_first_name $contact_last_name, said:\n					               $aop_case_updates_description', '<p>Hi $contact_first_name $contact_last_name,</p>\n					    <p> </p>\n					    <p>You''ve had an update to your case $acase_name (# $acase_case_number) on $aop_case_updates_date_entered:</p>\n					    <p><strong>$user_first_name $user_last_name said:</strong></p>\n					    <p style="padding-left:30px;">$aop_case_updates_description</p>', 0, NULL, NULL, 'system'),
('e61c85c2-e6cb-6dda-3760-5e830d31fbdc', NOW(), NOW(), '1', '1', 'off', 'Case Closure', 'Template for informing a contact that their case has been closed.', '$acase_name [CASE:$acase_case_number] closed', 'Hi $contact_first_name $contact_last_name,\n\n					   Your case $acase_name (# $acase_case_number) has been closed on $acase_date_entered\n					   Status:				$acase_status\n					   Reference:			$acase_case_number\n					   Resolution:			$acase_resolution', '<p> Hi $contact_first_name $contact_last_name,</p>\n					    <p>Your case $acase_name (# $acase_case_number) has been closed on $acase_date_entered</p>\n					    <table border="0"><tbody><tr><td>Status</td><td>$acase_status</td></tr><tr><td>Reference</td><td>$acase_case_number</td></tr><tr><td>Resolution</td><td>$acase_resolution</td></tr></tbody></table>', 0, NULL, NULL, 'system'),
('e9e00ea2-ac1b-a635-9671-5e830d66a582', NOW(), NOW(), '1', '1', 'off', 'Case Creation', 'Template to send to a contact when a case is received from them.', '$acase_name [CASE:$acase_case_number]', 'Hi $contact_first_name $contact_last_name,\n\n					   We''ve received your case $acase_name (# $acase_case_number) on $acase_date_entered\n					   Status:		$acase_status\n					   Reference:	$acase_case_number\n					   Description:	$acase_description', '<p> Hi $contact_first_name $contact_last_name,</p>\n					    <p>We''ve received your case $acase_name (# $acase_case_number) on $acase_date_entered</p>\n					    <table border="0"><tbody><tr><td>Status</td><td>$acase_status</td></tr><tr><td>Reference</td><td>$acase_case_number</td></tr><tr><td>Description</td><td>$acase_description</td></tr></tbody></table>', 0, NULL, NULL, 'system'),
('ed9867a2-1f56-b684-4bc6-5e830d215b5d', NOW(), NOW(), '1', '1', 'off', 'Joomla Account Creation', 'Template used when informing a contact that they''ve been given an account on the joomla portal.', 'Support Portal Account Created', 'Hi $contact_name,\n					   An account has been created for you at $portal_address.\n					   You may login using this email address and the password $joomla_pass', '<p>Hi $contact_name,</p>\n					    <p>An account has been created for you at <a href="$portal_address">$portal_address</a>.</p>\n					    <p>You may login using this email address and the password $joomla_pass</p>', 0, NULL, NULL, 'system');
