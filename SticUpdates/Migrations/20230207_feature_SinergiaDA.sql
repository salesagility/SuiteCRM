-- Active: 1632214630318@@localhost@2002@sinergiacrm
-- Add fields_meta_data fields for SDA Users

REPLACE INTO `fields_meta_data` (`id`, `custom_module`, `name`) VALUES
('Userssda_allowed_c', 'Users', 'sda_allowed_c');


ALTER TABLE users_cstm add COLUMN `sda_allowed_c` bool  DEFAULT '1' NULL;

-- set user admin to 1
UPDATE
    users_cstm
SET
    sda_allowed_c = 1
WHERE
    id_c IN(
SELECT
    id
FROM
    users
WHERE is_admin = 1
        AND status='active'
);


-- We delete previous settings in case they exist
delete from stic_settings where type='sinergiada';