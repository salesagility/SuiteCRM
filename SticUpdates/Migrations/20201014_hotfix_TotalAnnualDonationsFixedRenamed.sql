/* This script changes the name of the field stic_total_annual_donation_c from the Accounts module to stic_total_annual_donations_c
This modification includes the update of the due record in fields_meta_data table and the change of the column name of the field in accounts_cstm table */

drop procedure IF EXISTS update_fields_metadata;
drop procedure IF EXISTS change_column_name;

delimiter //

create procedure update_fields_metadata()
proc_main:begin  
    if (select count(*) from fields_meta_data where id='Accountsstic_total_annual_donation_c')=1 then
        if (select count(*) from fields_meta_data where id='Accountsstic_total_annual_donations_c')=0 then
            UPDATE fields_meta_data SET name='stic_total_annual_donations_c',id='Accountsstic_total_annual_donations_c' WHERE id='Accountsstic_total_annual_donation_c';
        end if;
    end if;
end proc_main; //

create procedure change_column_name()
proc_main:begin  
    if (SELECT count(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = database() AND TABLE_NAME = 'accounts_cstm' and COLUMN_NAME='stic_total_annual_donation_c')=1 then
        if (SELECT count(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = database() AND TABLE_NAME = 'accounts_cstm' and COLUMN_NAME='stic_total_annual_donations_c')=0 then
            ALTER TABLE accounts_cstm CHANGE stic_total_annual_donation_c stic_total_annual_donations_c decimal(26,2) DEFAULT 0.00 NULL;  
        end if;
    end if;
end proc_main; //

delimiter ;

call update_fields_metadata();
call change_column_name();

drop procedure update_fields_metadata;
drop procedure change_column_name;