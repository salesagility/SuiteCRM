-- Crear constante RECAPTCHA con valor vacío. 
REPLACE INTO `stic_settings` (`id`, `date_entered`, `date_modified`, `modified_user_id`, `created_by`, `deleted`, `assigned_user_id`, `type`, `name`, `value`, `description`) VALUES ('2c389ba8-78aa-e9fa-d77d-642a92edba46', NOW(), NOW(), '1', '1', 0, '1', 'GENERAL', 'GENERAL_RECAPTCHA', '', 'Constante de tipo General que almacena el valor de la clave secreta devuelta por Google durante el proceso de integrar la validación recaptcha en un formulario.  Podemos ver la documentación de como integrar la validación recaptcha en nuestros forumalario en el apartado de la wiki: ');