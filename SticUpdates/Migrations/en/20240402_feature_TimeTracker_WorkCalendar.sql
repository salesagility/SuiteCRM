-- Insert the scheduler 
REPLACE INTO schedulers (id, deleted, date_entered, date_modified, created_by, modified_user_id, name, job, date_time_start, date_time_end, job_interval, time_from, time_to, last_run, status, catch_up) VALUES
('56dca334-679c-266d-fd9a-660bcd6ed93e', 0, NOW(), NOW(), '1', '1', 'SinergiaCRM - Weekly data validation and updating', 'function::validationActions', NOW(), NULL, '*::1::*::*::1', NULL, NULL, NULL, 'Active', 0);

-- Insert the validation actions
REPLACE INTO stic_validation_actions (id, name, date_entered, date_modified, modified_user_id, created_by, description, deleted, assigned_user_id, last_execution, `function`, report_always, priority) VALUES
('3b9f3cc9-3a16-8d5f-3822-660bc51215e0', 'Time tracker - Previous day records validation', NOW(), NOW(), '1', '1', NULL, 0, '1', NULL, '3b9f3cc9-3a16-8d5f-3822-660bc51215e0', 0, 90),
('7acc83f4-f72e-10d5-969c-660bcb36cb56', 'Time tracker - Previous week worked hours validation', NOW(), NOW(), '1', '1', NULL, 0, '1', NULL, '7acc83f4-f72e-10d5-969c-660bcb36cb56', 0, 95),
('6eac6d58-ae3b-df60-261b-660e85c32b9a', 'Work calendar - Previous day records validation', NOW(), NOW(), '1', '1', NULL, 0, '1', NULL, '6eac6d58-ae3b-df60-261b-660e85c32b9a', 0, 95);

-- Insert the relationship between the validation actions and their respective schedulers
REPLACE INTO stic_validation_actions_schedulers_c (id, date_modified, deleted, stic_validation_actions_schedulersstic_validation_actions_ida, stic_validation_actions_schedulersschedulers_idb) VALUES
('d59a3bf0-8035-069f-9ec2-660bc7470264', NOW(), 0, '3b9f3cc9-3a16-8d5f-3822-660bc51215e0', 'b05bde8a-1309-4789-993b-bf85be389f07'),
('366fe514-7762-189c-f14e-660e85e49357', NOW(), 0, '6eac6d58-ae3b-df60-261b-660e85c32b9a', 'b05bde8a-1309-4789-993b-bf85be389f07'),
('72cea0a5-cb6a-eaeb-aaf5-660bcd238d1d', NOW(), 0, '7acc83f4-f72e-10d5-969c-660bcb36cb56', '56dca334-679c-266d-fd9a-660bcd6ed93e');

-- Insert the two configuration variables related to Time Tracker module
REPLACE INTO `stic_settings` (`id`, `date_entered`, `date_modified`, `modified_user_id`, `created_by`, `deleted`, `assigned_user_id`, `type`, `name`, `value`, `description`) VALUES
('78e895d4-b528-7392-5e83-66347f276649', NOW(), NOW(), '1', '1', 0, '1', 'TIMETRACKER', 'TIMETRACKER_LOWER_MARGIN_PERCENT', '20', 'Indicates the percentage of hours worked less (with respect to the theoretical weekly schedule) that will cause an alert to be sent.'),
('6ac2d1e7-ff90-61f0-85c2-66347f0d8311', NOW(), NOW(), '1', '1', 0, '1', 'TIMETRACKER', 'TIMETRACKER_UPPER_MARGIN_PERCENT', '20', 'Indicates the percentage of hours worked in excess (with respect to the theoretical weekly schedule) that will cause an alert to be sent.');
