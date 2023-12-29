-- Aggregated Payments functionality
-- STIC#498

drop procedure IF EXISTS add_payment_exception;
delimiter //
create procedure add_payment_exception()
proc_main:begin  
    if (SELECT count(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = database() AND TABLE_NAME = 'stic_attendances' and COLUMN_NAME='payment_exception')=0 then
        ALTER TABLE stic_attendances   add COLUMN payment_exception varchar(100)  NULL ;
    end if;
end proc_main; //
delimiter ;
call add_payment_exception();

drop procedure IF EXISTS add_amount;
delimiter //
create procedure add_amount()
proc_main:begin  
    if (SELECT count(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = database() AND TABLE_NAME = 'stic_attendances' and COLUMN_NAME='amount')=0 then
        ALTER TABLE stic_attendances   add COLUMN amount decimal(26,2)  NULL ;
    end if;
end proc_main; //
delimiter ;
call add_amount();

drop procedure IF EXISTS add_aggregated_services_complete;
delimiter //
create procedure add_aggregated_services_complete()
proc_main:begin  
    if (SELECT count(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = database() AND TABLE_NAME = 'stic_payments' and COLUMN_NAME='aggregated_services_complete')=0 then
        ALTER TABLE stic_payments add COLUMN aggregated_services_complete bool  DEFAULT '0' NULL ;
    end if;
end proc_main; //
delimiter ;
call add_aggregated_services_complete();

drop procedure IF EXISTS add_session_amount;
delimiter //
create procedure add_session_amount()
proc_main:begin  
    if (SELECT count(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = database() AND TABLE_NAME = 'stic_events' and COLUMN_NAME='session_amount')=0 then
        ALTER TABLE stic_events   add COLUMN session_amount decimal(26,2)  NULL ;
    end if;
end proc_main; //
delimiter ;
call add_session_amount();

drop procedure IF EXISTS add_session_amount_registations;
delimiter //
create procedure add_session_amount_registations()
proc_main:begin  
    if (SELECT count(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = database() AND TABLE_NAME = 'stic_registrations' and COLUMN_NAME='session_amount')=0 then
        ALTER TABLE stic_registrations   add COLUMN session_amount decimal(26,2)  NULL ;
    end if;
end proc_main; //
delimiter ;
call add_session_amount_registations();

CREATE TABLE IF NOT EXISTS stic_payments_stic_attendances_c (id varchar(36)  NOT NULL ,date_modified datetime  NULL ,deleted bool  DEFAULT '0' NULL ,stic_payments_stic_attendancesstic_payments_ida varchar(36)  NULL ,stic_payments_stic_attendancesstic_attendances_idb varchar(36)  NULL  , PRIMARY KEY (id),   KEY stic_payments_stic_attendances_ida1 (stic_payments_stic_attendancesstic_payments_ida),   KEY stic_payments_stic_attendances_alt (stic_payments_stic_attendancesstic_attendances_idb)) CHARACTER SET utf8 COLLATE utf8_general_ci;
CREATE TABLE IF NOT EXISTS stic_payment_commitments_stic_registrations_c (id varchar(36)  NOT NULL ,date_modified datetime  NULL ,deleted bool  DEFAULT '0' NULL ,stic_payme96d2itments_ida varchar(36)  NULL ,stic_paymee0afrations_idb varchar(36)  NULL  , PRIMARY KEY (id),   KEY stic_payment_commitments_stic_registrations_ida1 (stic_payme96d2itments_ida),   KEY stic_payment_commitments_stic_registrations_alt (stic_paymee0afrations_idb)) CHARACTER SET utf8 COLLATE utf8_general_ci;