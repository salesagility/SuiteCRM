-- Crear constants RECAPTCHA amb valor buit.
REPLACE INTO `stic_settings` (`id`, `date_entered`, `date_modified`, `modified_user_id`, `created_by`, `deleted`, `assigned_user_id`, `type`, `name`, `value`, `description`) VALUES 
  ('696c690e-70ce-4dd1-855b-ff02d4302831', NOW(), NOW(), '1', '1', 0, '1', 'GENERAL', 'GENERAL_RECAPTCHA_VERSION', '', 'Versió de Google reCAPTCHA utilitzada. Valors possibles: 2 o 3. Més informació a: https://wikisuite.sinergiacrm.org/index.php?title=Google_reCAPTCHA'),
  ('572910d4-716b-457d-b66c-4fb54d8e39a5', NOW(), NOW(), '1', '1', 0, '1', 'GENERAL', 'GENERAL_RECAPTCHA_WEBKEY', '', 'Clau per al lloc web proporcionada per Google. Més informació a: https://wikisuite.sinergiacrm.org/index.php?title=Google_reCAPTCHA');
