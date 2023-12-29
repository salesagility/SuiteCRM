-- STIC#334

-- SinergiaCRM - General data validation
UPDATE schedulers SET catch_up = 0  WHERE id='7386c4b1-bcc2-4f6f-be88-7e2a2e5778b5';

-- SinergiaCRM - Economic data validation
UPDATE schedulers SET catch_up = 0  WHERE id='a9bebf7f-8896-46dd-8d06-77e2b5256c83';

-- SinergiaCRM - Generate recurring payments
UPDATE schedulers SET job_interval = REGEXP_REPLACE(job_interval ,'^(.+?)::','0::') WHERE id='2a01deb0-04ed-5cd3-86b6-51a3235544fc';

-- SinergiaCRM - Generate attendances at multisession events
UPDATE schedulers SET job_interval = '0::0::*::*::*' WHERE id='3faa2520-9b74-2ca3-98cd-5bd6de539b9c';

-- SinergiaCRM - Daily data validation and updating (before "Relationship types validation")
UPDATE schedulers SET catch_up = 0  WHERE id='b05bde8a-1309-4789-993b-bf85be389f07';

-- Prune Tracker Tables
UPDATE schedulers SET catch_up = 0 WHERE id='600e94d1-6aa3-d743-9781-5e830de19e7e';

-- Run Nightly Process Bounced Campaign Emails
UPDATE schedulers SET catch_up = 0 WHERE id='6e4062f8-b4eb-9629-aca5-5e830d17031b';

-- Run Nightly Mass Email Campaigns
UPDATE schedulers SET catch_up = 0 WHERE id='72ed826e-bd84-758a-d742-5e830d2ce892';

-- Prune SuiteCRM Feed Tables
UPDATE schedulers SET catch_up = 0 WHERE id='988ee5ee-336a-4bcd-c698-5e830de4b2d1';

-- Process Workflow Tasks
UPDATE schedulers SET catch_up = 0 WHERE id='555afabf-a050-da1b-4ab3-5e830d5282f9';

-- Run Report Generation Scheduled Tasks
UPDATE schedulers SET catch_up = 0 WHERE id='5ad4580e-22d4-fb83-423e-5e830d68041e';