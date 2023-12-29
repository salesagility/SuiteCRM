-- Adding new fields
ALTER TABLE stic_job_offers   
add COLUMN inc_status_details varchar(255)  NULL,  
add COLUMN inc_professional_licenses varchar(255)  NULL,  
add COLUMN inc_driving_licenses varchar(255)  NULL,  
add COLUMN inc_maximum_age varchar(255)  NULL,  
add COLUMN inc_minimum_age varchar(255)  NULL,  
add COLUMN inc_working_experience text  NULL,  
add COLUMN inc_education varchar(100)  NULL,  
add COLUMN inc_education_languages text(100)  NULL,  
add COLUMN inc_officer_email varchar(255)  NULL,  
add COLUMN inc_officer_telephone varchar(255)  NULL;

-- Replacing new values for the inc_status field
UPDATE stic_job_offers SET inc_status = "ABIERTA" WHERE inc_status = 'open' OR inc_status = 'reopened';
UPDATE stic_job_offers SET inc_status = "CERRADA" WHERE inc_status = 'closed_covered' OR inc_status = 'closed_partially_covered';
UPDATE stic_job_offers SET inc_status = "PREPARA" WHERE inc_status = 'potential';
UPDATE stic_job_offers SET inc_status = "SELECCION" WHERE inc_status = 'selection_process';
UPDATE stic_job_offers SET inc_status = "OF_BAJA1" WHERE inc_status = 'closed_not_covered';