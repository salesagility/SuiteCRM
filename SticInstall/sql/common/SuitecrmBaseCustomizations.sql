-- SinergiaCRM: This file contains the customizations done directly to the SuiteCRM base dump.

-- Prune Tracker Tables
UPDATE schedulers SET catch_up = 0, job_interval='*::2::1::*::*' WHERE id='600e94d1-6aa3-d743-9781-5e830de19e7e';

-- Run Nightly Process Bounced Campaign Emails
UPDATE schedulers SET catch_up = 0, job_interval='*::2-6::*::*::*' WHERE id='6e4062f8-b4eb-9629-aca5-5e830d17031b';

-- Run Nightly Mass Email Campaigns
UPDATE schedulers SET catch_up = 0, job_interval='*::2-6::*::*::*' WHERE id='72ed826e-bd84-758a-d742-5e830d2ce892';

-- Prune Database on 1st of Month
UPDATE schedulers SET job_interval='*::4::1::*::*' WHERE id='78b6d594-78ab-c7c0-84cc-5e830d70f289';

-- Prune SuiteCRM Feed Tables
UPDATE schedulers SET catch_up = 0, job_interval='*::2::1::*::*' WHERE id='988ee5ee-336a-4bcd-c698-5e830de4b2d1';

-- Process Workflow Tasks
UPDATE schedulers SET catch_up = 0, job_interval='*::0::*::*::*' WHERE id='555afabf-a050-da1b-4ab3-5e830d5282f9';

-- Clean Jobs Queue
UPDATE schedulers SET job_interval='*::5::*::*::*' WHERE id='8eb78e01-492a-9dbd-eddc-5e830d791c43';

-- Removal of Documents from Filesystem
UPDATE schedulers SET job_interval='*::3::1::*::*' WHERE id='93890a43-0d74-f862-58e9-5e830d0964a0';

-- Google Calendar Sync
UPDATE schedulers SET job_interval='*::*::*::*::*' WHERE id='9d7da6e1-ce31-6c19-0ec9-5e830d2d8240';

-- Perform Lucene Index
UPDATE schedulers SET status='Inactive', job_interval='*::0::*::*::*' WHERE id='7e8a98ec-1d10-47d9-b5a6-5e830dbac250';

-- Optimise AOD Index
UPDATE schedulers SET status='Inactive', job_interval='*::*/3::*::*::*' WHERE id='845b6709-63d2-28ab-d999-5e830d6670d2';

-- Run Report Generation Scheduled Tasks
UPDATE schedulers SET catch_up = 0 WHERE id='5ad4580e-22d4-fb83-423e-5e830d68041e';