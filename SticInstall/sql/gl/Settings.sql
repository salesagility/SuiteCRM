-- SinergiaCRM: Configuraciones del CRM 

INSERT INTO `stic_settings` (`id`, `date_entered`, `date_modified`, `modified_user_id`, `created_by`, `deleted`, `assigned_user_id`, `type`, `name`, `value`, `description`) VALUES
('dbc49c32-25f7-a1ee-728d-518b824a16fc', NOW(), NOW(), '1', '1', 0, '1', 'GENERAL', 'GENERAL_ORGANIZATION_NAME', '', 'Nombre de la organización. Se usará allá donde sea necesario: remesas bancarias, declaraciones tributarias, etc.'),
('9a3548a7-0588-44d4-29a6-518b827f360c', NOW(), NOW(), '1', '1', 0, '1', 'GENERAL', 'GENERAL_ORGANIZATION_ID', '', 'Código que identifica oficialmente a la organización. En España debe ser el NIF.'),
('46a61ece-821c-11e8-9c7c-00163e7f1a26', NOW(), NOW(), '1', '1', 0, '1', 'GENERAL', 'GENERAL_IBAN_VALIDATION', '1', '1 - Se validarán los IBAN. Valor por defecto y que debe ser usado por todas las organizaciones que operan en el espacio SEPA.\r\n0 - Los IBAN no se validarán, de modo que el campo aceptará cualquier valor introducido. Solo para organizaciones ajenas al espacio SEPA.'),
('46cd35a1-821c-11e8-9c7c-00163e7f1a26', NOW(), NOW(), '1', '1', 0, '1', 'GENERAL', 'GENERAL_PAYMENT_GENERATION_MONTH', '0', 'Generación de pagos recurrentes:\r\n0 - Mes en curso\r\n1 - Mes próximo'),
('96cc6b13-a308-48b6-c0ca-6230bd1fc6b4', NOW(), NOW(), '1', '1', 0, '1', 'GENERAL', 'GENERAL_CUSTOM_THEME_COLOR', '#b5bc31', 'Indica el color de base de SinergiaCRM. Una vez cambiado, se asignará el estilo SticCustom, que es donde se aplica el color elegido, a todos los usuarios. Por si en algún momento se desea restablecer, el color base original es #b5bc31 (hexadecimal) o 181-188-49 (RGB).'),
('a649b1ca-4ada-e40f-5e47-660fc8e8d7cb', NOW(), NOW(), '1', '1', 0, '1', 'GENERAL', 'GENERAL_CUSTOM_SUBTHEME_MODE', '1', 'Indica el modo del subtema de SinergiaCRM:\r\n0 - Subtema claro\r\n1 - Subtema oscuro\r\nUna vez cambiado, se asignará el estilo SticCustom a todos los usuarios.'),
('2c389ba8-78aa-e9fa-d77d-642a92edba46', NOW(), NOW(), '1', '1', 0, '1', 'GENERAL', 'GENERAL_RECAPTCHA', '', 'Clave secreta proporcionada por Google. Más información en: https://wikisuite.sinergiacrm.org/index.php?title=Google_reCAPTCHA'),
('696c690e-70ce-4dd1-855b-ff02d4302831', NOW(), NOW(), '1', '1', 0, '1', 'GENERAL', 'GENERAL_RECAPTCHA_VERSION', '', 'Versión de Google reCAPTCHA utilizada. Valores posibles: 2 o 3. Más información en: https://wikisuite.sinergiacrm.org/index.php?title=Google_reCAPTCHA'),
('572910d4-716b-457d-b66c-4fb54d8e39a5', NOW(), NOW(), '1', '1', 0, '1', 'GENERAL', 'GENERAL_RECAPTCHA_WEBKEY', '', 'Clave de sitio web proporcionada por Google. Más información en: https://wikisuite.sinergiacrm.org/index.php?title=Google_reCAPTCHA');
('34e479af-35a4-2d47-26a5-518b8a4d6bc2', NOW(), NOW(), '1', '1', 0, '1', 'M182', 'M182_CLAVE_DONATIVO', 'A', 'Deberá rellenarse por las entidades acogidas al régimen de deducciones recogidas en el Título III de la Ley 49/2002, de 23 de diciembre, según el siguiente detalle:\r\nA. Donativos no incluidos en las actividades o programas prioritarios de mecenazgo establecidos por la Ley de Presupuestos Generales del Estado. Valor por defecto (habitual para las entidades usuarias de SinergiaCRM).\r\nB. Donativos incluidos en las actividades o programas prioritarios de mecenazgo establecidos por la Ley de Presupuestos Generales del Estado.\r\nTratándose de aportaciones o disposiciones relativas a patrimonios protegidos, deberá consignarse alguna de las siguientes claves:\r\nC. Aportación al patrimonio de discapacitados.\r\nD. Disposición del patrimonio de discapacitados.\r\nE. Gasto de dinero y consumo de bienes fungibles aportados al patrimonio protegido en el año natural al que se refiere la declaración informativa o en los cuatro anteriores para atender las necesidades vitales del beneficiario y que no deban considerarse como disposición de bienes o derechos a efectos de lo dispuesto en el artículo 54.5 de la Ley 35/2006, de 28 de noviembre, del Impuesto sobre la Renta de las Personas Físicas.'),
('bd7a0703-76c8-eed9-a455-518cba43f3ce', NOW(), NOW(), '1', '1', 0, '1', 'M182', 'M182_NATURALEZA_DECLARANTE', '1', 'Se hará constar el dígito numérico indicativo de la naturaleza del declarante, de acuerdo con la siguiente relación:\r\n1. Entidad beneficiaria de los incentivos regulados en el Título III de la Ley 49/2002, de 23 de diciembre, de régimen fiscal de las entidades sin fines lucrativos y de los incentivos fiscales al mecenazgo.\r\n2. Fundación legalmente reconocida que rinde cuentas al órgano del protectorado correspondiente o asociación declarada de utilidad pública a que se refieren elartículo 68.3.b) de la Ley del Impuesto sobre la Renta de las Personas Físicas.\r\n3. Titular o administrador de un patrimonio protegido regulado en la Ley 41/2003, de 18 de noviembre, de protección patrimonial de las personas con discapacidad y de modificación del Código Civil, de la Ley de Enjuiciamiento Civil y de la Normativa Tributaria con esta finalidad.\r\n4. Partidos Políticos, Federaciones, Coaliciones o Agrupaciones de Electores en los términos previstos en la Ley Orgánica 8/2007, de 4 de julio, de financiación de partidos políticos.'),
('846d3469-acef-db6c-41bc-518cccb58b4a', NOW(), NOW(), '1', '1', 0, '1', 'M182', 'M182_PORCENTAJE_DEDUCCION_AUTONOMICA_XX', '', 'Las organizaciones que puedan ofrecer deducciones adicionales a sus donantes en determinadas comunidades autónomas deberán crear claves de configuración del tipo M182_PORCENTAJE_DEDUCCION_AUTONOMICA_XX, donde XX deberá ser el código de la comunidad autónoma y el valor de la clave deberá ser el porcentaje de deducción aplicable (con dos decimales y sin símbolo de %). Se pueden consultar los códigos de las comunidades en https://wikisuite.sinergiacrm.org/index.php?title=Modelo_182#Porcentaje_de_deducci.C3.B3n_auton.C3.B3mica'),
('978a2000-022b-5c5e-0cd7-518b8313e761', NOW(), NOW(), '1', '1', 0, '1', 'M182', 'M182_PERSONA_CONTACTO_APELLIDO_1', '', ''),
('5accf323-9416-3c6d-62d9-518b836467fb', NOW(), NOW(), '1', '1', 0, '1', 'M182', 'M182_PERSONA_CONTACTO_APELLIDO_2', '', ''),
('5cd71028-09ec-2b1c-54bf-518b8344004a', NOW(), NOW(), '1', '1', 0, '1', 'M182', 'M182_PERSONA_CONTACTO_NOMBRE', '', ''),
('4efc55c0-0145-4282-3691-518b83e91075', NOW(), NOW(), '1', '1', 0, '1', 'M182', 'M182_PERSONA_CONTACTO_TELEFONO', '', ''),
('7de47385-e036-bea9-0946-56a129d7b3b1', NOW(), NOW(), '1', '1', 0, '1', 'M182', 'M182_NUMERO_JUSTIFICANTE', '', 'Código numérico de 13 dígitos que identifica la declaración. Debe consignarse un nuevo valor antes de generar el fichero de un nuevo ejercicio. Se puede obtener en https://www2.agenciatributaria.gob.es/L/inwinvoc/es.aeat.adht.nume.web.editran.NumRefEditran?mod=182'),
('bbe94f29-25e2-7680-d32e-5b4069f29df2', NOW(), NOW(), '1', '1', 0, '1', 'PAYPAL', 'PAYPAL_ID', '', 'Identificador de usuario o dirección de correo electrónico de la cuenta PayPal BUSINESS de la organización.'),
('bc2be16f-38dc-3e4b-e0ae-5b4069cc347a', NOW(), NOW(), '1', '1', 0, '1', 'PAYPAL', 'PAYPAL_ID_TEST', '', 'Dirección de correo electrónico de la cuenta PayPal SANDBOX (developer.paypal.com).'),
('bc77f99d-ba05-2f65-a967-5b406973ce68', NOW(), NOW(), '1', '1', 0, '1', 'PAYPAL', 'PAYPAL_TEST', '1', 'Indica el modo de trabajo (0 = Real, 1 = Test).'),
('b78ec43e-957d-94c3-b128-530da9b40a84', NOW(), NOW(), '1', '1', 0, '1', 'SEPA', 'SEPA_BIC_CODE', '', 'Código BIC de la entidad financiera con la que se opera. Este valor solo se usará cuando SEPA_DEBIT_BIC_MODE sea 1.'),
('d4f6e75e-e50d-11e9-b361-fa163e94e8de', NOW(), NOW(), '1', '1', 0, '1', 'SEPA', 'SEPA_DEBIT_BIC_MODE', '0', 'Cuando es 0 (valor por defecto), el BIC no se incluye en las remesas. Cuando es 1 el valor de SEPA_BIC_CODE se incluirá en las remesas. Algunas entidades financieras, como el Santander, lo exigen, aun cuando normativamente no es necesario.'),
('d26ed2ae-2574-43ac-93d6-487baeca28d7', NOW(), NOW(), '1', '1', 0, '1', 'SEPA', 'SEPA_DEBIT_DEFAULT_REMITTANCE_INFO', '', 'Información que aparecerá en los recibos cuando el concepto no esté informado individualmente en el pago.'),
('46aa0f7b-821c-11e8-9c7c-00163e7f1a26', NOW(), NOW(), '1', '1', 0, '1', 'SEPA', 'SEPA_TRANSFER_DEFAULT_REMITTANCE_INFO', '', 'Información que aparecerá en las órdenes de pago cuando el concepto no esté informado individualmente en el pago.'),
('eacb2339-7741-96d7-3fd6-531f07485832', NOW(), NOW(), '1', '1', 0, '1', 'SEPA', 'SEPA_DEBIT_CREDITOR_IDENTIFIER', '', 'Identificador único para remesas de recibos domiciliados SEPA. Más información en https://wikisuite.sinergiacrm.org/index.php?title=Compromisos_de_pago,_Pagos_y_Remesas#Par.C3.A1metros_SEPA_para_remesas_de_recibos_domiciliados'),
('10bbe32b-ad76-43a6-872d-2e569d657069', NOW(), NOW(), '1', '1', 0, '1', 'SEPA', 'SEPA_TRANSFER_DEBITOR_IDENTIFIER', '', 'Identificador de la organización para remesas de transferencias SEPA. El valor puede cambiar en función del criterio de la entidad financiera. Solicitadles cuál es el valor de aplicación en vuestro caso.'),
('4d7d1c1f-335b-c88b-1a53-5ff2d0935406', NOW(), NOW(), '1', '1', 0, '1', 'SEPE', 'SEPE_CODIGO_AGENCIA', '', 'Identificador de la organización para la generación de los informes SEPE para Agencias de Colocación. Codigo de 10 cifras'),
('15e3baf6-6e13-e79c-ee76-5235850cf8cd', NOW(), NOW(), '1', '1', 0, '1', 'TPV', 'TPV_CURRENCY', '978', 'Código de moneda para la pasarela de pago (978 = Euro).'),
('921e5673-9d0c-7e04-94c8-523585ccff61', NOW(), NOW(), '1', '1', 0, '1', 'TPV', 'TPV_MERCHANT_CODE', '', 'Código de comercio (valor numérico único) proporcionado por la pasarela de pago.'),
('778903f8-1fcc-2e3d-3fc1-523585707228', NOW(), NOW(), '1', '1', 0, '1', 'TPV', 'TPV_MERCHANT_NAME', '', 'El nombre de la organización, tal como se desea que aparezca en la pasarela de pago.'),
('294f7c6c-5166-cea4-220a-523589f2854f', NOW(), NOW(), '1', '1', 0, '1', 'TPV', 'TPV_PASSWORD', '', 'Contraseña para el modo de trabajo real, proporcionada por la pasarela de pago.'),
('ba936db7-e756-6d97-c38e-5b40693b0287', NOW(), NOW(), '1', '1', 0, '1', 'TPV', 'TPV_PASSWORD_TEST', '', 'Contraseña para el modo de trabajo test, proporcionada por la pasarela de pago.'),
('cc9ba14d-e56c-5d8e-ae18-52358805cda7', NOW(), NOW(), '1', '1', 0, '1', 'TPV', 'TPV_TERMINAL', '1', 'Número de terminal, proporcionado por la pasarela de pago. Normalmente, 1, pero podría ser 2, 3, etc. en función del número de terminales que opere la organización, sean físicos o virtuales.'),
('b9755f82-72c9-d361-10b7-5b40699f14c4', NOW(), NOW(), '1', '1', 0, '1', 'TPV', 'TPV_TEST', '1', 'Indica el modo de trabajo (0 = Real, 1 = Test).'),
('9386f858-d1af-11ee-b19a-0242ac140002', NOW(), NOW(), '1', '1', 0, '1', 'TPV', 'TPV_EXPIRATION_MONTHS', '0', 'Una tarea programada avisa de los compromisos de pago recurrentes con tarjeta que tienen fecha de caducidad cercana. Este parámetro indica el mes de vencimiento de las tarjetas a revisar en función de la anticipación deseada (0 = Mes actual, 1 = Mes siguiente, etc.).'),
('94b775b6-7093-3942-0987-64351b0df6f1', NOW(), NOW(), '1', '1', 0, '1', 'STRIPE', 'STRIPE_TEST', '1', 'Indica el modo de trabajo (0 = Real, 1 = Test). Es importante tener en cuenta que para realizar la transición al modo real la cuenta de Stripe debe estar configurada correctamente. Más información en https://wikisuite.sinergiacrm.org/index.php?title=Formularios#Stripe.'),
('c529dba2-558e-cdff-6357-64351a06087a', NOW(), NOW(), '1', '1', 0, '1', 'STRIPE', 'STRIPE_SECRET_KEY', '', 'La clave de API secreta de Stripe es una clave de autenticación que se utiliza para interactuar con la API de Stripe en el entorno real. Empieza con \"sk_live_\". Es importante tener en cuenta que no se debe utilizar en el entorno de pruebas, ya que se podrían realizar transacciones reales. La clave se puede encontrar en el panel de control de Stripe, sección \"Desarrolladores\", pestaña \"Claves API\". Más información en https://wikisuite.sinergiacrm.org/index.php?title=Formularios#Stripe.'),
('e1cb38dc-2635-5210-e09f-64351a29ef4b', NOW(), NOW(), '1', '1', 0, '1', 'STRIPE', 'STRIPE_SECRET_KEY_TEST', '', 'La clave de API secreta de pruebas de Stripe es una clave de autenticación que se utiliza para interactuar con la API de Stripe en el entorno de pruebas. Empieza con \"sk_test_\" y no se debe utilizar en el entorno real. La clave se puede encontrar en el panel de control de Stripe, sección \"Desarrolladores\", pestaña \"Claves API\", con el modo Test activado. Más información en https://wikisuite.sinergiacrm.org/index.php?title=Formularios#Stripe.'),
('38615008-06fa-4763-ba69-75b5ffabb99f', NOW(), NOW(), '1', '1', 0, '1', 'STRIPE', 'STRIPE_WEBHOOK_SECRET', '', 'El Webhook Signing Secret de Stripe es una clave utilizada para firmar los mensajes que envía Stripe en el entorno real. Empieza con \"whsec_\". Este dato se puede encontrar en el panel de control de Stripe, sección \"Desarrolladores\", pestaña \"Webhooks\". Más información en https://wikisuite.sinergiacrm.org/index.php?title=Formularios#Stripe.'),
('0f7195f7-60bd-49e8-b4b1-b7353463245c', NOW(), NOW(), '1', '1', 0, '1', 'STRIPE', 'STRIPE_WEBHOOK_SECRET_TEST', '', 'El Webhook Signing Secret de prueba de Stripe es una clave utilizada para firmar los mensajes que envía Stripe en el entorno de pruebas. Empieza con \"whsec_\". Este dato se puede encontrar en el panel de control de Stripe, sección \"Desarrolladores\", pestaña \"Webhooks\". Más información en https://wikisuite.sinergiacrm.org/index.php?title=Formularios#Stripe.'),
('496bf293-1552-453a-96fb-1dde7d78ea63', NOW(), NOW(), '1', '1', 0, '1', 'TPVCECA', 'TPVCECA_ACQUIRER_BIN', '', 'El código de la entidad bancaria proveedora del TPV CECA. Disponible en la aplicación web del TPV CECA (https://comercios.ceca.es/)'),
('2013e269-06b7-42ef-8a6d-44ff2341c8ec', NOW(), NOW(), '1', '1', 0, '1', 'TPVCECA', 'TPVCECA_CURRENCY', '978', 'Código de moneda para la pasarela de pago (978 = Euro).'),
('bb3a7ca4-8668-4e7d-a6f3-c3bfbe7247d8', NOW(), NOW(), '1', '1', 0, '1', 'TPVCECA', 'TPVCECA_MERCHANT_CODE', '', 'Código de comercio (valor numérico único), proporcionado por la pasarela de pago. Se corresponde con el parámetro MerchantID disponible en la aplicación web del TPV CECA (https://comercios.ceca.es/).'),
('7521efd8-671c-4296-9b6f-3bc236fc1fe0', NOW(), NOW(), '1', '1', 0, '1', 'TPVCECA', 'TPVCECA_PASSWORD', '', 'Contraseña para el modo de trabajo real, proporcionada por la pasarela de pago. Se corresponde con el parámetro Clave_encriptacion disponible en la aplicación web del TPV CECA (https://comercios.ceca.es/).'),
('7f72883c-18ba-46c9-b4fc-511b17f6a5ad', NOW(), NOW(), '1', '1', 0, '1', 'TPVCECA', 'TPVCECA_PASSWORD_TEST', '', 'Contraseña para el modo de trabajo test, proporcionada por la pasarela de pago. Se corresponde con el parámetro Clave_encriptacion disponible en la aplicación web del TPV CECA de pruebas (https://comercios.ceca.es/pruebas).'),
('3cbabeae-f992-4958-955b-1a0cd4300dc8', NOW(), NOW(), '1', '1', 0, '1', 'TPVCECA', 'TPVCECA_TERMINAL', '3', 'Número de terminal, proporcionado por la pasarela de pago (usualmente el número 3). Disponible en la aplicación web del TPV CECA (https://comercios.ceca.es/)'),
('d72a1bc8-c20b-49b6-a970-0ff37178b9d5', NOW(), NOW(), '1', '1', 0, '1', 'TPVCECA', 'TPVCECA_TEST', '1', 'Indica el modo de trabajo (0 = Real, 1 = Test).');
