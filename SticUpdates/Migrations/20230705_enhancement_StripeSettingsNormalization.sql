UPDATE stic_settings SET name = 'STRIPE_SECRET_KEY_TEST' WHERE id = 'e1cb38dc-2635-5210-e09f-64351a29ef4b';
UPDATE stic_settings SET name = 'STRIPE_WEBHOOK_SECRET_TEST' WHERE id = '0f7195f7-60bd-49e8-b4b1-b7353463245c';

-- STRIPE_TEST_ALT_XXXX_SECRET_KEY -> STRIPE_ALT_XXXX_SECRET_KEY_TEST
-- STRIPE_TEST_ALT_XXXX_WEBHOOK_SECRET -> STRIPE_ALT_XXXX_WEBHOOK_SECRET_TEST
UPDATE stic_settings SET name = CONCAT(REPLACE(name , 'TEST_', ''), '_TEST') WHERE name LIKE 'STRIPE_TEST_ALT_%';
