INSERT IGNORE INTO `email_templates` (`id`, `date_entered`, `date_modified`, `modified_user_id`, `created_by`, `published`, `name`, `description`, `subject`, `body`, `body_html`, `deleted`, `assigned_user_id`, `text_only`, `type`) VALUES
('52cdc554-bd90-f8f9-e2e0-66d718ae8fe9', NOW(), NOW(), '1', '1', NULL, 'Ejemplo - Nueva subvención', 'Ejemplo de plantilla de correo electrónico para notificar una nueva convocatoria de subvención', 'Nueva convocatoria de subvención: $opportunity_name', 'Nueva convocatoria de subvención: $opportunity_name\r\n\r\n$opportunity_stic_additional_information_c\r\nPuede encontrar más información en: $opportunity_stic_opportunity_url_c', '<p>Nueva convocatoria de subvención: $opportunity_name</p><p></p><p>$opportunity_stic_additional_information_c</p><p>Puede encontrar más información en: $opportunity_stic_opportunity_url_c</p>', 0, '1', 0, 'notification'),
('9f118e85-13f2-baa9-4ee3-66d80c674dea', NOW(), NOW(), '1', '1', NULL, 'Ejemplo - Nuevo evento', 'Ejemplo de plantilla de correo electrónico para notificar un nuevo evento', 'Nuevo evento: $stic_events_name', '$stic_events_type: $stic_events_name\r\n\r\nFecha de inicio: $stic_events_start_date\r\nFecha de finalización: $stic_events_end_date\r\nUbicación: $stic_events_stic_events_fp_event_locations_name', '<p>$stic_events_type: $stic_events_name</p><p></p><p>Fecha de inicio: $stic_events_start_date</p><p>Fecha de finalización: $stic_events_end_date</p><p>Ubicación: $stic_events_stic_events_fp_event_locations_name</p>', 0, '1', 0, 'notification');