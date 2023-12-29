-- Resources and Bookings functionality
-- STIC#336

CREATE TABLE IF NOT EXISTS stic_bookings (id char(36)  NOT NULL ,name varchar(255)  NULL ,date_entered datetime  NULL ,date_modified datetime  NULL ,modified_user_id char(36)  NULL ,created_by char(36)  NULL ,description text  NULL ,deleted bool  DEFAULT '0' NULL ,assigned_user_id char(36)  NULL ,status varchar(100)  NULL ,all_day bool  NULL ,start_date datetime  NULL ,end_date datetime  NULL ,code int(11)  NOT NULL auto_increment,parent_type varchar(255)  NULL ,parent_id char(36)  NULL  , PRIMARY KEY (id),   UNIQUE code_autoincrement (code)) CHARACTER SET utf8 COLLATE utf8_general_ci;
CREATE TABLE IF NOT EXISTS stic_resources (id char(36)  NOT NULL ,name varchar(255)  NULL ,date_entered datetime  NULL ,date_modified datetime  NULL ,modified_user_id char(36)  NULL ,created_by char(36)  NULL ,description text  NULL ,deleted bool  DEFAULT '0' NULL ,assigned_user_id char(36)  NULL ,code varchar(255)  NULL ,color varchar(255)  DEFAULT '#3788D8' NULL ,type varchar(100)  NULL ,status varchar(100)  NULL ,hourly_rate decimal(18,2)  NULL ,daily_rate decimal(18,2)  NULL ,contact_id_c char(36)  NULL ,account_id_c char(36)  NULL  , PRIMARY KEY (id)) CHARACTER SET utf8 COLLATE utf8_general_ci;
CREATE TABLE IF NOT EXISTS stic_bookings_accounts_c (id varchar(36)  NOT NULL ,date_modified datetime  NULL ,deleted bool  DEFAULT '0' NULL ,stic_bookings_accountsaccounts_ida varchar(36)  NULL ,stic_bookings_accountsstic_bookings_idb varchar(36)  NULL  , PRIMARY KEY (id),   KEY stic_bookings_accounts_ida1 (stic_bookings_accountsaccounts_ida),   KEY stic_bookings_accounts_alt (stic_bookings_accountsstic_bookings_idb)) CHARACTER SET utf8 COLLATE utf8_general_ci;
CREATE TABLE IF NOT EXISTS stic_bookings_contacts_c (id varchar(36)  NOT NULL ,date_modified datetime  NULL ,deleted bool  DEFAULT '0' NULL ,stic_bookings_contactscontacts_ida varchar(36)  NULL ,stic_bookings_contactsstic_bookings_idb varchar(36)  NULL  , PRIMARY KEY (id),   KEY stic_bookings_contacts_ida1 (stic_bookings_contactscontacts_ida),   KEY stic_bookings_contacts_alt (stic_bookings_contactsstic_bookings_idb)) CHARACTER SET utf8 COLLATE utf8_general_ci;
CREATE TABLE IF NOT EXISTS stic_resources_stic_bookings_c (id varchar(36)  NOT NULL ,date_modified datetime  NULL ,deleted bool  DEFAULT '0' NULL ,stic_resources_stic_bookingsstic_resources_ida varchar(36)  NULL ,stic_resources_stic_bookingsstic_bookings_idb varchar(36)  NULL  , PRIMARY KEY (id),   KEY stic_resources_stic_bookings_alt (stic_resources_stic_bookingsstic_resources_ida, stic_resources_stic_bookingsstic_bookings_idb)) CHARACTER SET utf8 COLLATE utf8_general_ci;