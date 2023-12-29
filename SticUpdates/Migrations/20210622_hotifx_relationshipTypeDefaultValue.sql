-- Standarize all the empty value of the fields
UPDATE accounts_cstm SET stic_relationship_type_c = '^^' WHERE stic_relationship_type_c = '' OR stic_relationship_type_c = NULL;
UPDATE contacts_cstm SET stic_relationship_type_c = '^^' WHERE stic_relationship_type_c = '' OR stic_relationship_type_c = NULL;