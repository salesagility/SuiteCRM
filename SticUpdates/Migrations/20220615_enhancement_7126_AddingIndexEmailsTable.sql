-- This release adds a new index to help improve performance in emails, instances with significantly large volume of emails 
-- may wish to run ALTER TABLE emails ADD INDEX idx_email_uid (uid); directly on their database prior to the upgrade to help 
-- avoid a potential timeout / long upgrade.
-- STIC#762
ALTER TABLE emails ADD INDEX idx_email_uid (uid);