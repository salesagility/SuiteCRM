-- STIC#304

-- SinergiaCRM - General data validation
UPDATE schedulers SET job_interval = REGEXP_REPLACE(job_interval ,'^(.+?)::','*::') WHERE id='7386c4b1-bcc2-4f6f-be88-7e2a2e5778b5';

-- SinergiaCRM - Economic data validation
UPDATE schedulers SET job_interval = REGEXP_REPLACE(job_interval ,'^(.+?)::','*::') WHERE id='a9bebf7f-8896-46dd-8d06-77e2b5256c83';

-- SinergiaCRM - Generate recurring payments
UPDATE schedulers SET job_interval = REGEXP_REPLACE(job_interval ,'^(.+?)::','*::') WHERE id='2a01deb0-04ed-5cd3-86b6-51a3235544fc';

-- SinergiaCRM - Generate attendances at multisession events
UPDATE schedulers SET job_interval = REGEXP_REPLACE(job_interval ,'^(.+?)::','*::') WHERE id='3faa2520-9b74-2ca3-98cd-5bd6de539b9c';

-- SinergiaCRM - Relationship types validation
UPDATE schedulers SET job_interval = REGEXP_REPLACE(job_interval ,'^(.+?)::','*::') WHERE id='b05bde8a-1309-4789-993b-bf85be389f07';

-- SinergiaCRM - Reset optimal settings
UPDATE schedulers SET catch_up=0, job_interval = REGEXP_REPLACE(job_interval ,'^(.+?)::','*::') WHERE id='511fda77-4b76-4b8e-b44f-ff78489b1e5f';

-- SinergiaCRM - Opportunities reminder
UPDATE schedulers SET catch_up=0, job_interval = REGEXP_REPLACE(job_interval ,'^(.+?)::','*::') WHERE id='e3a6b5f4-9d8c-ecc1-a8af-51a71894802d';

-- SinergiaCRM - Update people age
UPDATE schedulers SET catch_up=0, job_interval = REGEXP_REPLACE(job_interval ,'^(.+?)::','*::') WHERE id='1f4425d5-e576-4785-bb9a-5b3c3b0784b2';

-- Prune Tracker Tables
UPDATE schedulers SET job_interval = REGEXP_REPLACE(job_interval ,'^(.+?)::','*::') WHERE id='600e94d1-6aa3-d743-9781-5e830de19e7e';

-- Run Nightly Process Bounced Campaign Emails
UPDATE schedulers SET job_interval = REGEXP_REPLACE(job_interval ,'^(.+?)::','*::') WHERE id='6e4062f8-b4eb-9629-aca5-5e830d17031b';

-- Run Nightly Mass Email Campaigns
UPDATE schedulers SET job_interval = REGEXP_REPLACE(job_interval ,'^(.+?)::','*::') WHERE id='72ed826e-bd84-758a-d742-5e830d2ce892';

-- Prune Database on 1st of Month
UPDATE schedulers SET job_interval = REGEXP_REPLACE(job_interval ,'^(.+?)::','*::') WHERE id='78b6d594-78ab-c7c0-84cc-5e830d70f289';

-- Prune SuiteCRM Feed Tables
UPDATE schedulers SET job_interval = REGEXP_REPLACE(job_interval ,'^(.+?)::','*::') WHERE id='988ee5ee-336a-4bcd-c698-5e830de4b2d1';

-- Process Workflow Tasks
UPDATE schedulers SET job_interval = REGEXP_REPLACE(job_interval ,'^(.+?)::','*::') WHERE id='555afabf-a050-da1b-4ab3-5e830d5282f9';

-- Clean Jobs Queue
UPDATE schedulers SET job_interval = REGEXP_REPLACE(job_interval ,'^(.+?)::','*::') WHERE id='8eb78e01-492a-9dbd-eddc-5e830d791c43';

-- Removal of Documents from Filesystem
UPDATE schedulers SET job_interval = REGEXP_REPLACE(job_interval ,'^(.+?)::','*::') WHERE id='93890a43-0d74-f862-58e9-5e830d0964a0';

-- Google Calendar Sync
UPDATE schedulers SET job_interval = REGEXP_REPLACE(job_interval ,'^(.+?)::','*::') WHERE id='9d7da6e1-ce31-6c19-0ec9-5e830d2d8240';

-- Perform Lucene Index
UPDATE schedulers SET status='Inactive', job_interval = REGEXP_REPLACE(job_interval ,'^(.+?)::','*::') WHERE id='7e8a98ec-1d10-47d9-b5a6-5e830dbac250';

-- Optimise AOD Index
UPDATE schedulers SET status='Inactive', job_interval = REGEXP_REPLACE(job_interval ,'^(.+?)::','*::') WHERE id='845b6709-63d2-28ab-d999-5e830d6670d2';