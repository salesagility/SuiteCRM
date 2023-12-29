-- Suitecrm Upgrade Database changes

ALTER TABLE aos_pdf_templates   modify COLUMN IF EXISTS `pdfheader` longtext  NULL ,  modify COLUMN IF EXISTS `pdffooter` longtext  NULL ;

ALTER TABLE aow_workflow   add COLUMN IF NOT EXISTS `run_on_import` bool  DEFAULT '0' NULL ;

ALTER TABLE users_password_link   add COLUMN IF NOT EXISTS `user_id` varchar(36)  NULL ;
