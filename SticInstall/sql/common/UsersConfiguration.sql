-- SinergiaCRM: default users and email addresses

DELETE FROM users;
DELETE FROM user_preferences;

INSERT INTO `users` (`id`, `user_name`, `user_hash`, `system_generated_password`, `pwd_last_changed`, `authenticate_id`, `sugar_login`, `first_name`, `last_name`, `is_admin`, `external_auth_only`, `receive_notifications`, `description`, `date_entered`, `date_modified`, `modified_user_id`, `created_by`, `title`, `photo`, `department`, `phone_home`, `phone_mobile`, `phone_work`, `phone_other`, `phone_fax`, `status`, `address_street`, `address_city`, `address_state`, `address_country`, `address_postalcode`, `deleted`, `portal_only`, `show_on_employees`, `employee_status`, `messenger_id`, `messenger_type`, `reports_to_id`, `is_group`, `factor_auth`, `factor_auth_interface`) VALUES
('1', 'admin', md5('@@pwdAdmin@@'), 0, NULL, NULL, 1, NULL, 'Administrator', 1, 0, 1, NULL, NOW(), NOW(), '1', '', 'Administrator', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 'Active', NULL, NULL, '', 0, 0, NULL),
('2', 'sinergiacrm', md5('@@pwdSinergiaCRM@@'), 0, NULL, NULL, 1, NULL, 'SinergiaCRM', 1, 0, 1, NULL, NOW(), NOW(), '2', '1', 'SinergiaCRM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 'Active', NULL, NULL, '', 0, 0, NULL);

INSERT INTO `email_addresses` (`id`, `email_address`, `email_address_caps`, `invalid_email`, `opt_out`, `date_created`, `date_modified`, `deleted`) VALUES
('2f2df9cc-5718-8d4d-9082-5b4001239c92', '@@emailSinergiaCRM@@', '@@emailCapsSinergiaCRM@@', 0, 0, NOW(), NOW(), 0),
('9357c4b2-d67e-1abd-b03e-5b40013ced29', 'test@test.com', 'TEST@TEST.COM', 0, 0, NOW(), NOW(), 0);

INSERT INTO `email_addr_bean_rel` (`id`, `email_address_id`, `bean_id`, `bean_module`, `primary_address`, `reply_to_address`, `date_created`, `date_modified`, `deleted`) VALUES
('2f13a5a1-f837-dbee-771d-5b4001e86a0d', '2f2df9cc-5718-8d4d-9082-5b4001239c92', '2', 'Users', 1, 0, NOW(), NOW(), 0),
('933c61d2-15e4-fa94-154e-5b40010d7b19', '9357c4b2-d67e-1abd-b03e-5b40013ced29', '1', 'Users', 1, 0, NOW(), NOW(), 0);
