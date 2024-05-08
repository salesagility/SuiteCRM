-- SinergiaCRM: CRM Settings 

INSERT INTO `stic_settings` (`id`, `date_entered`, `date_modified`, `modified_user_id`, `created_by`, `deleted`, `assigned_user_id`, `type`, `name`, `value`, `description`) VALUES
('dbc49c32-25f7-a1ee-728d-518b824a16fc', NOW(), NOW(), '1', '1', 0, '1', 'GENERAL', 'GENERAL_ORGANIZATION_NAME', '', 'The name of your organization. It will be used wherever is needed: bank remittances, tax files, etc.'),
('9a3548a7-0588-44d4-29a6-518b827f360c', NOW(), NOW(), '1', '1', 0, '1', 'GENERAL', 'GENERAL_ORGANIZATION_ID', '', 'Any code suitable for officially identifying your organization. In Spain, NIF should be used.'),
('46a61ece-821c-11e8-9c7c-00163e7f1a26', NOW(), NOW(), '1', '1', 0, '1', 'GENERAL', 'GENERAL_IBAN_VALIDATION', '1', '1 - The IBAN will be validated. This is the default value and the value used for all those organizations inside SEPA.\r\n0 - The IBAN will not be validated, so the field will accept any value. Only for organizations outside SEPA.'),
('46cd35a1-821c-11e8-9c7c-00163e7f1a26', NOW(), NOW(), '1', '1', 0, '1', 'GENERAL', 'GENERAL_PAYMENT_GENERATION_MONTH', '0', 'Generate recurring payments for:\r\n0 - Current month\r\n1 - Next month.'),
('96cc6b13-a308-48b6-c0ca-6230bd1fc6b4', NOW(), NOW(), '1', '1', 0, '1', 'GENERAL', 'GENERAL_CUSTOM_THEME_COLOR', '#b5bc31', 'Sets the base color of SinergiaCRM. Once changed, the SticCustom style, which is where the chosen color is applied, will be assigned to all users. In case you want to reset it at some point, the original base color is #b5bc31 (hexadecimal) or 181-188-49 (RGB).'),
('a649b1ca-4ada-e40f-5e47-660fc8e8d7cb', NOW(), NOW(), '1', '1', 0, '1', 'GENERAL', 'GENERAL_CUSTOM_SUBTHEME_MODE', '1', 'Sets the subtheme mode of SinergiaCRM:\r\n0 - Light subtheme\r\n1 - Dark subtheme.\r\nOnce changed, the SticCustom style will be assigned to all users.'),
('2c389ba8-78aa-e9fa-d77d-642a92edba46', NOW(), NOW(), '1', '1', 0, '1', 'GENERAL', 'GENERAL_RECAPTCHA', '', 'Secret key given by Google. More information at:  https://wikisuite.sinergiacrm.org/index.php?title=Google_reCAPTCHA'),
('696c690e-70ce-4dd1-855b-ff02d4302831', NOW(), NOW(), '1', '1', 0, '1', 'GENERAL', 'GENERAL_RECAPTCHA_VERSION', '', 'Google reCAPTCHA version. Accepted values: 2 or 3. More information at: https://wikisuite.sinergiacrm.org/index.php?title=Google_reCAPTCHA'),
('572910d4-716b-457d-b66c-4fb54d8e39a5', NOW(), NOW(), '1', '1', 0, '1', 'GENERAL', 'GENERAL_RECAPTCHA_WEBKEY', '', 'Website key given by Google. More information at: https://wikisuite.sinergiacrm.org/index.php?title=Google_reCAPTCHA'),
('34e479af-35a4-2d47-26a5-518b8a4d6bc2', NOW(), NOW(), '1', '1', 0, '1', 'M182', 'M182_CLAVE_DONATIVO', 'A', 'Deberá rellenarse por las entidades acogidas al régimen de deducciones recogidas en el Título III de la Ley 49/2002, de 23 de diciembre, según el siguiente detalle:\n\rA. Donativos no incluidos en las actividades o programas prioritarios de mecenazgo establecidos por la Ley de Presupuestos Generales del Estado. Valor por defecto (habitual para las entidades usuarias de SinergiaCRM).\n\rB. Donativos incluidos en las actividades o programas prioritarios de mecenazgo establecidos por la Ley de Presupuestos Generales del Estado.\n\rTratándose de aportaciones o disposiciones relativas a patrimonios protegidos, deberá consignarse alguna de las siguientes claves:\n\rC. Aportación al patrimonio de discapacitados.\n\rD. Disposición del patrimonio de discapacitados.\n\rE. Gasto de dinero y consumo de bienes fungibles aportados al patrimonio protegido en el año natural al que se refiere la declaración informativa o en los cuatro anteriores para atender las necesidades vitales del beneficiario y que no deban considerarse como disposición de bienes o derechos a efectos de lo dispuesto en el artículo 54.5 de la Ley 35/2006, de 28 de noviembre, del Impuesto sobre la Renta de las Personas Físicas.'),
('bd7a0703-76c8-eed9-a455-518cba43f3ce', NOW(), NOW(), '1', '1', 0, '1', 'M182', 'M182_NATURALEZA_DECLARANTE', '1', 'Se hará constar el dígito numérico indicativo de la naturaleza del declarante, de acuerdo con la siguiente relación:\n\r1. Entidad beneficiaria de los incentivos regulados en el Título III de la Ley 49/2002, de 23 de diciembre, de régimen fiscal de las entidades sin fines lucrativos y de los incentivos fiscales al mecenazgo.\n\r2. Fundación legalmente reconocida que rinde cuentas al órgano del protectorado correspondiente o asociación declarada de utilidad pública a que se refieren elartículo 68.3.b) de la Ley del Impuesto sobre la Renta de las Personas Físicas.\n\r3. Titular o administrador de un patrimonio protegido regulado en la Ley 41/2003, de 18 de noviembre, de protección patrimonial de las personas con discapacidad y de modificación del Código Civil, de la Ley de Enjuiciamiento Civil y de la Normativa Tributaria con esta finalidad.\n\r4. Partidos Políticos, Federaciones, Coaliciones o Agrupaciones de Electores en los términos previstos en la Ley Orgánica 8/2007, de 4 de julio, de financiación de partidos políticos.'),
('846d3469-acef-db6c-41bc-518cccb58b4a', NOW(), NOW(), '1', '1', 0, '1', 'M182', 'M182_PORCENTAJE_DEDUCCION_AUTONOMICA_XX', '', 'Las organizaciones que puedan ofrecer deducciones adicionales a sus donantes en determinadas comunidades autónomas deberán crear claves de configuración del tipo M182_PORCENTAJE_DEDUCCION_AUTONOMICA_XX, donde XX deberá ser el código de la comunidad autónoma y el valor de la clave deberá ser el porcentaje de deducción aplicable (con dos decimales y sin símbolo de %). Se pueden consultar los códigos de las comunidades en https://wikisuite.sinergiacrm.org/index.php?title=Modelo_182#Porcentaje_de_deducci.C3.B3n_auton.C3.B3mica'),
('978a2000-022b-5c5e-0cd7-518b8313e761', NOW(), NOW(), '1', '1', 0, '1', 'M182', 'M182_PERSONA_CONTACTO_APELLIDO_1', '', ''),
('5accf323-9416-3c6d-62d9-518b836467fb', NOW(), NOW(), '1', '1', 0, '1', 'M182', 'M182_PERSONA_CONTACTO_APELLIDO_2', '', ''),
('5cd71028-09ec-2b1c-54bf-518b8344004a', NOW(), NOW(), '1', '1', 0, '1', 'M182', 'M182_PERSONA_CONTACTO_NOMBRE', '', ''),
('4efc55c0-0145-4282-3691-518b83e91075', NOW(), NOW(), '1', '1', 0, '1', 'M182', 'M182_PERSONA_CONTACTO_TELEFONO', '', ''),
('7de47385-e036-bea9-0946-56a129d7b3b1', NOW(), NOW(), '1', '1', 0, '1', 'M182', 'M182_NUMERO_JUSTIFICANTE', '', 'Código numérico de 13 dígitos que identifica la declaración. Debe consignarse un nuevo valor antes de generar el fichero de un nuevo ejercicio. Se puede obtener en https://www2.agenciatributaria.gob.es/L/inwinvoc/es.aeat.adht.nume.web.editran.NumRefEditran?mod=182'),
('bbe94f29-25e2-7680-d32e-5b4069f29df2', NOW(), NOW(), '1', '1', 0, '1', 'PAYPAL', 'PAYPAL_ID', '', 'User identifier or email address of your PayPal BUSINESS account.'),
('bc2be16f-38dc-3e4b-e0ae-5b4069cc347a', NOW(), NOW(), '1', '1', 0, '1', 'PAYPAL', 'PAYPAL_ID_TEST', '', 'Email address of your PayPal SANDBOX account (developer.paypal.com).'),
('bc77f99d-ba05-2f65-a967-5b406973ce68', NOW(), NOW(), '1', '1', 0, '1', 'PAYPAL', 'PAYPAL_TEST', '1', 'Indicates the working mode (0 = Real, 1 = Test).'),
('b78ec43e-957d-94c3-b128-530da9b40a84', NOW(), NOW(), '1', '1', 0, '1', 'SEPA', 'SEPA_BIC_CODE', '', 'BIC code of your bank. This will only be used when SEPA_DEBIT_BIC_MODE is 1.'),
('d4f6e75e-e50d-11e9-b361-fa163e94e8de', NOW(), NOW(), '1', '1', 0, '1', 'SEPA', 'SEPA_DEBIT_BIC_MODE', '0', 'When set to 0 (default value), BIC is not included in remittances. When set to 1 the value of SEPA_BIC_CODE will be included. Some banks, like Santander, demand it, although it is not necessary.'),
('d26ed2ae-2574-43ac-93d6-487baeca28d7', NOW(), NOW(), '1', '1', 0, '1', 'SEPA', 'SEPA_DEBIT_DEFAULT_REMITTANCE_INFO', '', 'Information that will appear in the debit order if there is no info in the payment record.'),
('46aa0f7b-821c-11e8-9c7c-00163e7f1a26', NOW(), NOW(), '1', '1', 0, '1', 'SEPA', 'SEPA_TRANSFER_DEFAULT_REMITTANCE_INFO', '', 'Information that will appear in the payment order if there is no info in the payment record.'),
('eacb2339-7741-96d7-3fd6-531f07485832', NOW(), NOW(), '1', '1', 0, '1', 'SEPA', 'SEPA_DEBIT_CREDITOR_IDENTIFIER', '', 'Unique identifier for SEPA direct debit remittances. More information in https://wikisuite.sinergiacrm.org/index.php?title=Compromisos_de_pago,_Pagos_y_Remesas#Par.C3.A1metros_SEPA_para_remesas_de_recibos_domiciliados'),
('10bbe32b-ad76-43a6-872d-2e569d657069', NOW(), NOW(), '1', '1', 0, '1', 'SEPA', 'SEPA_TRANSFER_DEBITOR_IDENTIFIER', '', 'Organization identifier for SEPA transfer remittances. The value may differ from one bank to another. Please ask them which value you should use.'),
('4d7d1c1f-335b-c88b-1a53-5ff2d0935406', NOW(), NOW(), '1', '1', 0, '1', 'SEPE', 'SEPE_CODIGO_AGENCIA', '', 'Organization identifier for SEPE reports. 10 digits code'),
('15e3baf6-6e13-e79c-ee76-5235850cf8cd', NOW(), NOW(), '1', '1', 0, '1', 'TPV', 'TPV_CURRENCY', '978', 'Currency code for the payment gateway (978 = Euro).'),
('921e5673-9d0c-7e04-94c8-523585ccff61', NOW(), NOW(), '1', '1', 0, '1', 'TPV', 'TPV_MERCHANT_CODE', '', 'Unique numeric code provided by the payment gateway.'),
('778903f8-1fcc-2e3d-3fc1-523585707228', NOW(), NOW(), '1', '1', 0, '1', 'TPV', 'TPV_MERCHANT_NAME', '', 'The name of your organization, that will be shown in the payment gateway.'),
('294f7c6c-5166-cea4-220a-523589f2854f', NOW(), NOW(), '1', '1', 0, '1', 'TPV', 'TPV_PASSWORD', '', 'Password for real mode, provided by the payment gateway.'),
('ba936db7-e756-6d97-c38e-5b40693b0287', NOW(), NOW(), '1', '1', 0, '1', 'TPV', 'TPV_PASSWORD_TEST', '', 'Password for test mode, provided by the payment gateway.'),
('cc9ba14d-e56c-5d8e-ae18-52358805cda7', NOW(), NOW(), '1', '1', 0, '1', 'TPV', 'TPV_TERMINAL', '1', 'Terminal number, provided by the payment gateway. Usually number 1, but could be 2, 3, etc. depending on wether your organization has one or more POS terminals.'),
('b9755f82-72c9-d361-10b7-5b40699f14c4', NOW(), NOW(), '1', '1', 0, '1', 'TPV', 'TPV_TEST', '1', 'Indicates the working mode (0 = Real, 1 = Test).'),
('9386f858-d1af-11ee-b19a-0242ac140002', NOW(), NOW(), '1', '1', 0, '1', 'TPV', 'TPV_EXPIRATION_MONTHS', '0', 'A scheduled task notifies of recurring card payment commitments that have an upcoming expiration date. This parameter indicates the expiry month of the cards to be reviewed depending on the desired anticipation (0 = Current month, 1 = Next month, etc.).'),
('94b775b6-7093-3942-0987-64351b0df6f1', NOW(), NOW(), '1', '1', 0, '1', 'STRIPE', 'STRIPE_TEST', '1', 'Indicates the working mode (0 = Real, 1 = Test). It is important to notice that to transition to real mode the Stripe account must be properly configured. Learn more at https://wikisuite.sinergiacrm.org/index.php?title=Formularios#Stripe.'),
('c529dba2-558e-cdff-6357-64351a06087a', NOW(), NOW(), '1', '1', 0, '1', 'STRIPE', 'STRIPE_SECRET_KEY', '', 'The Stripe API secret key is an authentication key used to interact with the Stripe API in the real environment. It starts with \"sk_live_\". It is important to notice that should not be used in the test environment, as real transactions could be made. The key can be found in the Stripe control panel, \"Developers\" section, \"API Keys" tab. Learn more at https://wikisuite.sinergiacrm.org/index.php?title=Formularios#Stripe.'),
('e1cb38dc-2635-5210-e09f-64351a29ef4b', NOW(), NOW(), '1', '1', 0, '1', 'STRIPE', 'STRIPE_SECRET_KEY_TEST', '', 'The Stripe API test secret key is an authentication key used to interact with the Stripe API in the test environment. It starts with \"sk_test_\" and must not be used in the real environment. The key can be found in the Stripe control panel, \"Developers\" section, \"API Keys\" tab, with Test mode turned on. Learn more at https://wikisuite.sinergiacrm.org/index.php?title=Formularios#Stripe.'),
('38615008-06fa-4763-ba69-75b5ffabb99f', NOW(), NOW(), '1', '1', 0, '1', 'STRIPE', 'STRIPE_WEBHOOK_SECRET', '', 'The Stripe Webhook Signing Secret is a key used to sign messages sent by Stripe in the real environment. It starts with \"whsec_\". This value can be found in the Stripe control panel, section \"Developers\" ", \"Webhooks\" tab. Learn more at https://wikisuite.sinergiacrm.org/index.php?title=Formularios#Stripe.'),
('0f7195f7-60bd-49e8-b4b1-b7353463245c', NOW(), NOW(), '1', '1', 0, '1', 'STRIPE', 'STRIPE_WEBHOOK_SECRET_TEST', '', 'The Stripe Webhook test Signing Secret is a key used to sign messages sent by Stripe in the test environment. It starts with \"whsec_\". This value can be found in the Stripe control panel, section \"Developers \", \"Webhooks\" tab. Learn more at https://wikisuite.sinergiacrm.org/index.php?title=Formularios#Stripe.'),
('496bf293-1552-453a-96fb-1dde7d78ea63', NOW(), NOW(), '1', '1', 0, '1', 'TPVCECA', 'TPVCECA_ACQUIRER_BIN', '', 'The code of the bank providing the TPV CECA. Available on the TPV CECA web application (https://comercios.ceca.es/).'),
('2013e269-06b7-42ef-8a6d-44ff2341c8ec', NOW(), NOW(), '1', '1', 0, '1', 'TPVCECA', 'TPVCECA_CURRENCY', '978', 'Currency code for the payment gateway (978 = Euro).'),
('bb3a7ca4-8668-4e7d-a6f3-c3bfbe7247d8', NOW(), NOW(), '1', '1', 0, '1', 'TPVCECA', 'TPVCECA_MERCHANT_CODE', '', 'Unique numeric code provided by the payment gateway. Corresponds to the MerchantID parameter available on the TPV CECA web application (https://comercios.ceca.es/).'),
('7521efd8-671c-4296-9b6f-3bc236fc1fe0', NOW(), NOW(), '1', '1', 0, '1', 'TPVCECA', 'TPVCECA_PASSWORD', '', 'Password for real mode, provided by the payment gateway. Corresponds to the Clave_encriptacion parameter available on the TPV CECA web application (https://comercios.ceca.es/).'),
('7f72883c-18ba-46c9-b4fc-511b17f6a5ad', NOW(), NOW(), '1', '1', 0, '1', 'TPVCECA', 'TPVCECA_PASSWORD_TEST', '', 'Password for test mode, provided by the payment gateway. Corresponds to the Clave_encriptacion parameter available on the testing TPV CECA web application (https://comercios.ceca.es/pruebas).'),
('3cbabeae-f992-4958-955b-1a0cd4300dc8', NOW(), NOW(), '1', '1', 0, '1', 'TPVCECA', 'TPVCECA_TERMINAL', '3', 'Terminal number, provided by the payment gateway (usually number 3). Available on the TPV CECA web application (https://comercios.ceca.es/).'),
('d72a1bc8-c20b-49b6-a970-0ff37178b9d5', NOW(), NOW(), '1', '1', 0, '1', 'TPVCECA', 'TPVCECA_TEST', '1', 'Indicates the working mode (0 = Real, 1 = Test).');
