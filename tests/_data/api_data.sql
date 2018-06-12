-- INSERT INTO `oauth2clients` (`id`, `name`, `date_entered`, `date_modified`, `modified_user_id`, `created_by`, `description`, `deleted`, `secret`, `redirect_url`, `is_confidential`, `allowed_grant_type`, `duration_value`, `duration_amount`, `duration_unit`, `assigned_user_id`) VALUES
-- ('API-4c59-f678-cecc-6594-5a8d9c704473', 'Password Grant API Client', '2018-02-21 16:20:43', '2018-02-21 16:20:43', '1', '1', NULL, 0, '$1$LWHSyJNo$Dg3KssRJcfw85uRJcF/py.', 'https://test.com', 1, 'password', 8640000, 1, 'day', NULL),
-- ('API-6d34-6c4c-59be-9fb5-5a8d9cda918f', 'Implicit API Client', '2018-02-21 16:22:07', '2018-02-21 16:22:17', '1', '1', NULL, 0, '$1$LWHSyJNo$Dg3KssRJcfw85uRJcF/py.', 'https://test.com', 1, 'implicit', 8640000, 1, 'day', NULL),
-- ('API-b95b-19cd-0229-a3ed-5a8d9cc0d3eb', 'Authorization Code API Client', '2018-02-21 16:22:46', '2018-02-21 16:22:46', '1', '1', NULL, 0, '$1$LWHSyJNo$Dg3KssRJcfw85uRJcF/py.', 'https://test.com', 1, 'authorization_code', 8640000, 1, 'day', NULL),
-- ('API-ea74-c352-badd-c2be-5a8d9c9d4351', 'Client Credentials API Client', '2018-02-21 16:21:42', '2018-02-22 17:03:17', '1', '1', NULL, 0, '$1$LWHSyJNo$Dg3KssRJcfw85uRJcF/py.', 'https://test.com', 1, 'client_credentials', 1, 1, 'day', '1');


INSERT INTO `oauth2clients` (`id`, `name`, `date_entered`, `date_modified`, `modified_user_id`, `created_by`, `description`, `deleted`, `secret`, `redirect_url`, `is_confidential`, `allowed_grant_type`, `duration_value`, `duration_amount`, `duration_unit`, `assigned_user_id`) VALUES
('API-4c59-f678-cecc-6594-5a8d9c704473', 'suitecrm_client', '2018-06-12 14:12:49', '2018-06-12 14:12:49', '1', '1', NULL, 0, '2bb80d537b1da3e38bd30361aa855686bde0eacd7162fef6a25fe97bf527a25b', NULL, 1, 'password', 60, 1, 'minute', NULL);
