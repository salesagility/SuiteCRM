-- SinergiaCRM: custom schedulers, validation actions and schedulers-actions relationships

INSERT INTO schedulers (id, deleted, date_entered, date_modified, created_by, modified_user_id, name, job, date_time_start, date_time_end, job_interval, time_from, time_to, last_run, status, catch_up) VALUES
('a9bebf7f-8896-46dd-8d06-77e2b5256c83', 0, NOW(), NOW(), '1', '1', 'SinergiaCRM - Economic data validation', 'function::validationActions', NOW(), NULL, '*::1::*::*::6', NULL, NULL, NULL, 'Active', 0),
('7386c4b1-bcc2-4f6f-be88-7e2a2e5778b5', 0, NOW(), NOW(), '1', '1', 'SinergiaCRM - General data validation', 'function::validationActions', NOW(), NULL, '*::1::*::*::0', NULL, NULL, NULL, 'Active', 0),
('3faa2520-9b74-2ca3-98cd-5bd6de539b9c', 0, NOW(), NOW(), '1', '1', 'SinergiaCRM - Create attendances for multisession events', 'function::createAttendances', NOW(), NULL, '0::0::*::*::*', NULL, NULL, NULL, 'Active', 1),
('2a01deb0-04ed-5cd3-86b6-51a3235544fc', 0, NOW(), NOW(), '1', '1', 'SinergiaCRM - Create recurring payments', 'function::createCurrentMonthRecurringPayments', NOW(), NULL, '0::0::1::*::*', NULL, NULL, NULL, 'Active', 1),
('e3a6b5f4-9d8c-ecc1-a8af-51a71894802d', 0, NOW(), NOW(), '1', '1', 'SinergiaCRM - Opportunities reminder', 'function::opportunitiesReminder', NOW(), NULL, '*::6::*::*::*', NULL, NULL, NULL, 'Active', 0),
('b05bde8a-1309-4789-993b-bf85be389f07', 0, NOW(), NOW(), '1', '1', 'SinergiaCRM - Daily data validation and updating', 'function::validationActions', NOW(), NULL, '*::0::*::*::*', NULL, NULL, NULL, 'Active', 0),
('1f4425d5-e576-4785-bb9a-5b3c3b0784b2', 0, NOW(), NOW(), '1', '1', 'SinergiaCRM - Update people age', 'function::calculateContactsAge', NOW(), NULL, '*::1::*::*::*', NULL, NULL, NULL, 'Active', 0),
('511fda77-4b76-4b8e-b44f-ff78489b1e5f', 0, NOW(), NOW(), '1', '1', 'SinergiaCRM - Reset optimal settings', 'function::sticCleanConfig', NOW(), NULL, '*::18::*::*::5', NULL, NULL, NULL, 'Active', 0),
('98eb0c26-99dd-d656-ee73-611cc6994570', 0, NOW(), NOW(), '1', '1', 'SinergiaCRM - Purge database', 'function::sticPurgeDatabase', NOW(), NULL, '*::2::*::*::0', NULL, NULL, NULL, 'Active', 0),
('4d0ac999-2bcb-cc4f-f65d-6192a21c4aff', 0, NOW(), NOW(), '1', '1', 'SinergiaCRM - Monthly data validation and updating', 'function::validationActions', NOW(), NULL, '*::3::1::*::*', NULL, NULL, NULL, 'Active', 0),
('ca564b47-9a06-987d-a115-6442356ca768', 0, NOW(), NOW(), '1', '1', 'SinergiaCRM - Create medication logs', 'function::createMedicationLogs', NOW(), NULL, '*::1::*::*::*', NULL, NULL, NULL, 'Active', 0),
('c5f7d492-5a02-6fe1-1d6e-6540b28a4b21', 0, NOW(), NOW(), '1', '1', 'SinergiaCRM - Rebuild SinergiaDA data sources', 'function::rebuildSDASources', NOW(), NULL, '*::2::*::*::*', NULL, NULL, NULL, 'Active', 0),
('56dca334-679c-266d-fd9a-660bcd6ed93e', 0, NOW(), NOW(), '1', '1', 'SinergiaCRM - Weekly data validation and updating', 'function::validationActions', NOW(), NULL, '*::1::*::*::1', NULL, NULL, NULL, 'Active', 0);

INSERT INTO stic_validation_actions (id, name, date_entered, date_modified, modified_user_id, created_by, description, deleted, assigned_user_id, last_execution, `function`, report_always, priority) VALUES
('d1d60459-3713-488d-94ce-ff38bf3e1f98', 'Accounts - Main data validation', NOW(), NOW(), '1', '1', NULL, 0, '1', NULL, 'd1d60459-3713-488d-94ce-ff38bf3e1f98', 0, 65),
('e126ec69-2a9e-4bb9-a731-a05f95b3e4c7', 'Accounts - Relationship type validation', NOW(), NOW(), '1', '1', NULL, 0, '1', NULL, 'e126ec69-2a9e-4bb9-a731-a05f95b3e4c7', 0, 60),
('9b975af1-34c9-8cae-1f60-5db9d528c22a', 'Accounts - Search for duplicates', NOW(), NOW(), '1', '1', NULL, 0, '1', NULL, '9b975af1-34c9-8cae-1f60-5db9d528c22a', 0, 0),
('23d660da-b276-11eb-b5ab-0242ac1e0002', 'Accounts relationships - Set active/inactive records', NOW(), NOW(), '1', '1', NULL, 0, '1', NULL, '23d660da-b276-11eb-b5ab-0242ac1e0002', 0, 30),
('ccd95008-28c1-42ff-be53-6722b821e1e5', 'Accounts relationships - Main data validation', NOW(), NOW(), '1', '1', NULL, 0, '1', NULL, 'ccd95008-28c1-42ff-be53-6722b821e1e5', 0, 55),
('99d53183-6091-40c0-ac04-ed4fb099528c', 'Accounts relationships - Relationships validation', NOW(), NOW(), '1', '1', NULL, 0, '1', NULL, '99d53183-6091-40c0-ac04-ed4fb099528c', 0, 50),
('f512af92-7518-4bbe-b583-5b43bc6223da', 'Contacts - Main data validation', NOW(), NOW(), '1', '1', NULL, 0, '1', NULL, 'f512af92-7518-4bbe-b583-5b43bc6223da', 0, 85),
('2fede90f-5df5-44a2-8c8a-bc1a1813dc70', 'Contacts - Relationship type validation', NOW(), NOW(), '1', '1', NULL, 0, '1', NULL, '2fede90f-5df5-44a2-8c8a-bc1a1813dc70', 0, 80),
('17ade03a-9f60-4e14-bd8b-69ae39243526', 'Contacts - Search for duplicates', NOW(), NOW(), '1', '1', NULL, 0, '1', NULL, '17ade03a-9f60-4e14-bd8b-69ae39243526', 0, 0),
('8cd4b3ba-b273-11eb-b5ab-0242ac1e0002', 'Contacts relationships - Set active/inactive records', NOW(), NOW(), '1', '1', NULL, 0, '1', NULL, '8cd4b3ba-b273-11eb-b5ab-0242ac1e0002', 0, 30),
('d49627f2-3623-44e3-bdb2-d5af0f8c5165', 'Contacts relationships - Main data validation', NOW(), NOW(), '1', '1', NULL, 0, '1', NULL, 'd49627f2-3623-44e3-bdb2-d5af0f8c5165', 0, 75),
('430a2764-5e4d-4a54-835c-0a1896ad2fc0', 'Contacts relationships - Relationships validation', NOW(), NOW(), '1', '1', NULL, 0, '1', NULL, '430a2764-5e4d-4a54-835c-0a1896ad2fc0', 0, 70),
('914c771f-9609-43b8-8229-99395f48d6f9', 'Leads - Main data validation', NOW(), NOW(), '1', '1', NULL, 0, '1', NULL, '914c771f-9609-43b8-8229-99395f48d6f9', 0, 5),
('0b5b5d41-ae84-11eb-9b56-0242ac180004', 'Payment commitments - Set active/inactive records', NOW(), NOW(), '1', '1', NULL, 0, '1', NULL, '0b5b5d41-ae84-11eb-9b56-0242ac180004', 0, 30),
('14875de6-ed5e-443a-abbc-54d57dec100e', 'Payment commitments - Main data validation', NOW(), NOW(), '1', '1', NULL, 0, '1', NULL, '14875de6-ed5e-443a-abbc-54d57dec100e', 0, 45),
('d2baf24e-cd27-47c5-8ee1-84c905b9198d', 'Payment commitments - Relationships validation', NOW(), NOW(), '1', '1', NULL, 0, '1', NULL, 'd2baf24e-cd27-47c5-8ee1-84c905b9198d', 0, 40),
('ac28533e-40ad-11ec-b2f2-0242ac150002', 'Payment commitments - Incomplete recurring authorizations validation', NOW(), NOW(), '1', '1', NULL, 0, '1', NULL, 'ac28533e-40ad-11ec-b2f2-0242ac150002', 0, 30),
('a8d6cdff-ff13-4a2d-b5af-dba7ed47f29c', 'Payment commitments - Card expirancy date validation', NOW(), NOW(), '1', '1', NULL, 0, '1', NULL, 'a8d6cdff-ff13-4a2d-b5af-dba7ed47f29c', 0, 65),
('e39516bb-9acf-4c6f-8e25-d3af9aac0a95', 'Payments - Main data validation', NOW(), NOW(), '1', '1', NULL, 0, '1', NULL, 'e39516bb-9acf-4c6f-8e25-d3af9aac0a95', 0, 35),
('b738e9b4-c025-4a96-86c1-c2c6f657d3cf', 'Payments - Relationships validation', NOW(), NOW(), '1', '1', NULL, 0, '1', NULL, 'b738e9b4-c025-4a96-86c1-c2c6f657d3cf', 0, 30),
('28874faf-7465-43a4-ad31-357769af3f6f', 'Registrations - Main data validation', NOW(), NOW(), '1', '1', NULL, 0, '1', NULL, '28874faf-7465-43a4-ad31-357769af3f6f', 0, 15),
('88aa01ca-94a1-4313-a24e-a0a637dcf029', 'Registrations - Relationships validation', NOW(), NOW(), '1', '1', NULL, 0, '1', NULL, '88aa01ca-94a1-4313-a24e-a0a637dcf029', 0, 10),
('375431dc-a6bb-4c0b-ab4c-af1a06229ee4', 'Remittances - Main data validation', NOW(), NOW(), '1', '1', NULL, 0, '1', NULL, '375431dc-a6bb-4c0b-ab4c-af1a06229ee4', 0, 25),
('b07eefb3-20fb-4993-abea-66ce0aa71649', 'Remittances - Relationships validation', NOW(), NOW(), '1', '1', NULL, 0, '1', NULL, 'b07eefb3-20fb-4993-abea-66ce0aa71649', 0, 20),
('10fff3d4-5dc5-ef7a-3d7f-636bae661c14', 'Families - Set active/inactive records', NOW(), NOW(), '1', '1', NULL, 0, '1', NULL, '10fff3d4-5dc5-ef7a-3d7f-636bae661c14', 0, 30),
('b53a08c5-23dc-96b7-2b31-6582cf7dbebc', 'Grants - Set active/inactive records', NOW(), NOW(), '1', '1', NULL, 0, '1', NULL, 'b53a08c5-23dc-96b7-2b31-6582cf7dbebc', 0, 30),
('3b9f3cc9-3a16-8d5f-3822-660bc51215e0', 'Time tracker - Previous day records validation', NOW(), NOW(), '1', '1', NULL, 0, '1', NULL, '3b9f3cc9-3a16-8d5f-3822-660bc51215e0', 0, 90),
('7acc83f4-f72e-10d5-969c-660bcb36cb56', 'Time tracker - Previous week worked hours validation', NOW(), NOW(), '1', '1', NULL, 0, '1', NULL, '7acc83f4-f72e-10d5-969c-660bcb36cb56', 0, 95),
('6eac6d58-ae3b-df60-261b-660e85c32b9a', 'Work calendar - Previous day records validation', NOW(), NOW(), '1', '1', NULL, 0, '1', NULL, '6eac6d58-ae3b-df60-261b-660e85c32b9a', 0, 95);

INSERT INTO stic_validation_actions_schedulers_c (id, date_modified, deleted, stic_validation_actions_schedulersstic_validation_actions_ida, stic_validation_actions_schedulersschedulers_idb) VALUES
('16085edd-15a4-e6df-c869-5b406a4611ed', NOW(), 0, 'f512af92-7518-4bbe-b583-5b43bc6223da', '7386c4b1-bcc2-4f6f-be88-7e2a2e5778b5'),
('1925c223-f11d-4b63-4ca7-5b406ae57fce', NOW(), 0, '17ade03a-9f60-4e14-bd8b-69ae39243526', '7386c4b1-bcc2-4f6f-be88-7e2a2e5778b5'),
('1c4a0e52-10b0-281e-1a8a-5b406af94151', NOW(), 0, 'd49627f2-3623-44e3-bdb2-d5af0f8c5165', '7386c4b1-bcc2-4f6f-be88-7e2a2e5778b5'),
('1f497438-8d62-ce8d-74a4-5b406a88c50e', NOW(), 0, '430a2764-5e4d-4a54-835c-0a1896ad2fc0', '7386c4b1-bcc2-4f6f-be88-7e2a2e5778b5'),
('2251bd95-7cdd-fba9-a7ea-5b406ac57c01', NOW(), 0, 'd1d60459-3713-488d-94ce-ff38bf3e1f98', '7386c4b1-bcc2-4f6f-be88-7e2a2e5778b5'),
('25698b63-f1e6-05fa-2b6b-5b406a95cd36', NOW(), 0, 'ccd95008-28c1-42ff-be53-6722b821e1e5', '7386c4b1-bcc2-4f6f-be88-7e2a2e5778b5'),
('286879b9-d062-24d6-9192-5b406aa55c2a', NOW(), 0, '99d53183-6091-40c0-ac04-ed4fb099528c', '7386c4b1-bcc2-4f6f-be88-7e2a2e5778b5'),
('298d9945-7c0e-8995-59c0-5b406a085c56', NOW(), 0, '914c771f-9609-43b8-8229-99395f48d6f9', '7386c4b1-bcc2-4f6f-be88-7e2a2e5778b5'),
('2a7466d0-996f-5b1e-b9dd-5b406a5c080c', NOW(), 0, '28874faf-7465-43a4-ad31-357769af3f6f', '7386c4b1-bcc2-4f6f-be88-7e2a2e5778b5'),
('2b55ea0e-966a-fcd1-ed41-5b406a336933', NOW(), 0, '88aa01ca-94a1-4313-a24e-a0a637dcf029', '7386c4b1-bcc2-4f6f-be88-7e2a2e5778b5'),
('4e95a019-c3ef-1bec-bd0a-5b406aba0c10', NOW(), 0, '14875de6-ed5e-443a-abbc-54d57dec100e', 'a9bebf7f-8896-46dd-8d06-77e2b5256c83'),
('4fb6f8b3-5df3-6fbb-5a42-5b406a46d2bd', NOW(), 0, 'd2baf24e-cd27-47c5-8ee1-84c905b9198d', 'a9bebf7f-8896-46dd-8d06-77e2b5256c83'),
('50b61496-7a27-4fcd-2dd6-5b406ab9da18', NOW(), 0, 'e39516bb-9acf-4c6f-8e25-d3af9aac0a95', 'a9bebf7f-8896-46dd-8d06-77e2b5256c83'),
('51973ce8-dce3-41f9-9e39-5b406a37226a', NOW(), 0, 'b738e9b4-c025-4a96-86c1-c2c6f657d3cf', 'a9bebf7f-8896-46dd-8d06-77e2b5256c83'),
('521b0d1c-800e-f0a2-e36e-5b406a145158', NOW(), 0, '375431dc-a6bb-4c0b-ab4c-af1a06229ee4', 'a9bebf7f-8896-46dd-8d06-77e2b5256c83'),
('54461dbd-2ad4-8536-af64-5b406a2821ff', NOW(), 0, 'b07eefb3-20fb-4993-abea-66ce0aa71649', 'a9bebf7f-8896-46dd-8d06-77e2b5256c83'),
('a58bba60-c60f-11ee-98c0-0242ac140002', NOW(), 0, 'a8d6cdff-ff13-4a2d-b5af-dba7ed47f29c', '4d0ac999-2bcb-cc4f-f65d-6192a21c4aff'),
('a2b96791-1f65-ee15-18ba-5db9d5e016d3', NOW(), 0, '9b975af1-34c9-8cae-1f60-5db9d528c22a', '7386c4b1-bcc2-4f6f-be88-7e2a2e5778b5'),
('b60f8629-0fb7-ccd6-358e-5b406aecfa9f', NOW(), 0, '2fede90f-5df5-44a2-8c8a-bc1a1813dc70', 'b05bde8a-1309-4789-993b-bf85be389f07'),
('b7cdff60-6c50-7059-3c60-5b406a81e407', NOW(), 0, 'e126ec69-2a9e-4bb9-a731-a05f95b3e4c7', 'b05bde8a-1309-4789-993b-bf85be389f07'),
('695a1453-aef7-11eb-9a4a-0242ac1a0003', NOW(), 0, '0b5b5d41-ae84-11eb-9b56-0242ac180004', 'b05bde8a-1309-4789-993b-bf85be389f07'),
('529f2cd9-b277-11eb-b5ab-0242ac1e0002', NOW(), 0, '8cd4b3ba-b273-11eb-b5ab-0242ac1e0002', 'b05bde8a-1309-4789-993b-bf85be389f07'),
('583981c3-b277-11eb-b5ab-0242ac1e0002', NOW(), 0, '23d660da-b276-11eb-b5ab-0242ac1e0002', 'b05bde8a-1309-4789-993b-bf85be389f07'),
('6f82c1d8-d481-09b5-9bfb-618955029780', NOW(), 0, 'ac28533e-40ad-11ec-b2f2-0242ac150002', 'b05bde8a-1309-4789-993b-bf85be389f07'),
('d0d59fed-6419-a8eb-a7e2-636b906e5f36', NOW(), 0, '10fff3d4-5dc5-ef7a-3d7f-636bae661c14', 'b05bde8a-1309-4789-993b-bf85be389f07'),
('d0d59ped-6cd9-areb-a77a-6361606e5f36', NOW(), 0, 'b53a08c5-23dc-96b7-2b31-6582cf7dbebc', 'b05bde8a-1309-4789-993b-bf85be389f07'),
('d59a3bf0-8035-069f-9ec2-660bc7470264', NOW(), 0, '3b9f3cc9-3a16-8d5f-3822-660bc51215e0', 'b05bde8a-1309-4789-993b-bf85be389f07'),
('366fe514-7762-189c-f14e-660e85e49357', NOW(), 0, '6eac6d58-ae3b-df60-261b-660e85c32b9a', 'b05bde8a-1309-4789-993b-bf85be389f07'),
('72cea0a5-cb6a-eaeb-aaf5-660bcd238d1d', NOW(), 0, '7acc83f4-f72e-10d5-969c-660bcb36cb56', '56dca334-679c-266d-fd9a-660bcd6ed93e');

