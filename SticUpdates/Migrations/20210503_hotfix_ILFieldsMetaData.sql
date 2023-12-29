-- Missing fields_meta_data fields for IL modules

INSERT INTO `fields_meta_data` (`id`, `custom_module`, `name`) VALUES
('Contactssepe_benefit_perceiver_c', 'Contacts', 'sepe_benefit_perceiver_c'),
('Contactssepe_disability_c', 'Contacts', 'sepe_disability_c'),
('Contactssepe_education_level_c', 'Contacts', 'sepe_education_level_c'),
('Contactssepe_immigrant_c', 'Contacts', 'sepe_immigrant_c'),
('Contactssepe_insertion_difficulties_c', 'Contacts', 'sepe_insertion_difficulties_c');

ALTER TABLE contacts_cstm add COLUMN sepe_benefit_perceiver_c varchar(100)  NULL ;
ALTER TABLE contacts_cstm add COLUMN sepe_disability_c varchar(100)  NULL ;
ALTER TABLE contacts_cstm add COLUMN sepe_education_level_c varchar(100)  NULL ;
ALTER TABLE contacts_cstm add COLUMN sepe_immigrant_c varchar(100)  NULL ;
ALTER TABLE contacts_cstm add COLUMN sepe_insertion_difficulties_c varchar(100)  NULL ;