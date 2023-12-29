<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2019 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$mod_strings = array(
    /*'ADMIN_EXPORT_ONLY'=>'Admin export only',*/
    'ADVANCED' => 'Avanzado',
    'DEFAULT_CURRENCY_ISO4217' => 'Código de moeda ISO 4217',
    'DEFAULT_CURRENCY_NAME' => 'Nome de Moeda',
    'DEFAULT_CURRENCY_SYMBOL' => 'Símbolo de moeda',
    'DEFAULT_DATE_FORMAT' => 'Formato de data predeterminado',
    'DEFAULT_DECIMAL_SEP' => 'Símbolo decimal',
    'DEFAULT_LANGUAGE' => 'Idioma predeterminado',
    'DEFAULT_SYSTEM_SETTINGS' => 'Interfaz de Usuario',
    'DEFAULT_THEME' => 'Tema predeterminado',
    'DEFAULT_TIME_FORMAT' => 'Formato de hora predeterminado',
    'DISPLAY_RESPONSE_TIME' => 'Mostrar os tempos de resposta do servidor',
    'IMAGES' => 'Logos',
    'LBL_ALLOW_USER_TABS' => 'Permitir aos usuarios ocultar pestanas',
    'LBL_CONFIGURE_SETTINGS_TITLE' => 'Configuración do Sistema',
    'LBL_LOGVIEW' => 'Ver rexistro',
    'LBL_MAIL_SMTPAUTH_REQ' => '¿Usar Autenticación SMTP?',
    'LBL_MAIL_SMTPPASS' => 'Contrasinal SMTP:',
    'LBL_MAIL_SMTPPORT' => 'Porto SMTP:',
    'LBL_MAIL_SMTPSERVER' => 'Servidor SMTP:',
    'LBL_MAIL_SMTPUSER' => 'Nome de Usuario SMTP:',
    'LBL_MAIL_SMTP_SETTINGS' => 'Especificación de Servidor SMTP',
    'LBL_CHOOSE_EMAIL_PROVIDER' => 'Escolla o seu proveedor de Email:',
    'LBL_YAHOOMAIL_SMTPPASS' => 'Contrasinal de Yahoo! Mail:',
    'LBL_YAHOOMAIL_SMTPUSER' => 'ID de Yahoo! Mail:',
    'LBL_GMAIL_SMTPPASS' => 'Contrasinal de Gmail:',
    'LBL_GMAIL_SMTPUSER' => 'Enderezo de Email de Gmail:',
    'LBL_EXCHANGE_SMTPPASS' => 'Contrasinal de Exchange:',
    'LBL_EXCHANGE_SMTPUSER' => 'Nome de usuario de Exchange:',
    'LBL_EXCHANGE_SMTPPORT' => 'Porto de Servidor Exchange:',
    'LBL_EXCHANGE_SMTPSERVER' => 'Servidor Exchange:',
    'LBL_ALLOW_DEFAULT_SELECTION' => 'Permitir aos usuarios usar esta conta para correo saínte:',
    'LBL_ALLOW_DEFAULT_SELECTION_HELP' => 'Cando esta opción está seleccionada, todos os usuarios poderán enviar correos usando a mesma conta de correo saínte para o envío de notificacións do sistema e alertas.  Se a opción non está seleccionada, os usuarios poden usar o servidor de correo saínte tras proporcionar a información da súa propia conta.',
    'LBL_MAILMERGE' => 'Combinar Correspondencia',
    'LBL_MIN_AUTO_REFRESH_INTERVAL' => 'Intervalo minimo de actualización do Dashlet',
    'LBL_MIN_AUTO_REFRESH_INTERVAL_HELP' => 'Este é o valor mínimo que un pode escoller para a actualización automática dos dashlets. Axustar a &#39;No&#39; desactiva que se actualicen automaticamente os dashlets.',
    'LBL_MODULE_FAVICON' => 'Mostrar o icono do módulo como un favicon',
    'LBL_MODULE_FAVICON_HELP' => 'Se está visitando un módulo con icono, utiliza o icono do módulo como favicon, en lugar do favicon do tema, na pestana do navegador.',
    'LBL_MODULE_NAME' => 'Configuración do Sistema',
    'LBL_MODULE_ID' => 'Configurador',
    'LBL_MODULE_TITLE' => 'Interfaz de Usuario',
    'LBL_NOTIFY_FROMADDRESS' => 'Enderezo do Remitente:',
    'LBL_NOTIFY_SUBJECT' => 'Asunto de correo:',
    'LBL_PROXY_AUTH' => '¿Autenticación?',
    'LBL_PROXY_HOST' => 'Servidor Proxy',
    'LBL_PROXY_ON_DESC' => 'Configura a enderezo do servidor proxy e a configuración da autenticación',
    'LBL_PROXY_ON' => '¿Utilizar servidor proxy?',
    'LBL_PROXY_PASSWORD' => 'Contrasinal',
    'LBL_PROXY_PORT' => 'Porto',
    'LBL_PROXY_TITLE' => 'Configuración do Proxy',
    'LBL_PROXY_USERNAME' => 'Nome de Usuario',
    'LBL_RESTORE_BUTTON_LABEL' => 'Restaurar',
    'LBL_SYSTEM_SETTINGS' => 'Configuración do Sistema',
    'LBL_USE_REAL_NAMES' => 'Show Nome Completo',
    'LBL_USE_REAL_NAMES_DESC' => 'Mostrar o nome completo dos usuarios en lugar dos seus Nomes de Usuario nos campos de asignación.',
    'LBL_DISALBE_CONVERT_LEAD' => 'Desactivar a acción de convertir clientes potenciais para clientes potenciais convertidos.',
    'LBL_DISALBE_CONVERT_LEAD_DESC' => 'Se un cliente potencial xa se convertiu, o que permite esta opción, eliminar a acción principal de conversión.',
    'LBL_ENABLE_ACTION_MENU' => 'Mostrar accións dentro dos menús',
    'LBL_ENABLE_ACTION_MENU_DESC' => 'Seleccione para mostrar a Vista de Detalle e o subpanel de accións dentro dun menú despregable. Se non se selecciona, as accións mostraranse como botóns independentes.',
    'LBL_ENABLE_INLINE_EDITING_LIST' => 'Activar edición rápida non listado',
    'LBL_ENABLE_INLINE_EDITING_LIST_DESC' => 'Escolle para activar a edición rápida nos campos da lista. Se non hai campos seleccionados, será desactivado no listado.',
    'LBL_ENABLE_INLINE_EDITING_DETAIL' => 'Activar edición rápida na vista detallada',
    'LBL_ENABLE_INLINE_EDITING_DETAIL_DESC' => 'Escolle para activar a edición rápida nos campos da vista detallada. Se non hai campos seleccionados, será desactivado na vista detallada.',
    'LBL_HIDE_SUBPANELS' => 'Subpaneis colapsados',
    'LIST_ENTRIES_PER_LISTVIEW' => 'Elementos por páxina para listas',
    'LIST_ENTRIES_PER_SUBPANEL' => 'Elementos por páxina para subpaneis',
    'LOG_MEMORY_USAGE' => 'Rexistrar utilización de memoria',
    'LOG_SLOW_QUERIES' => 'Rexistrar consultas lentas',
    'CURRENT_LOGO' => 'Logo Actual:',
    'CURRENT_LOGO_HELP' => 'Este logotipo móstrase no centro da pantalla de inicio de sesión da aplicación SuiteCRM.',
    'NEW_LOGO' => 'Seleccionar Logo:',
    'NEW_LOGO_HELP' => 'O formato do arquivo de imaxe pode ser tanto .png como .jpg. A altura máxima é 170px, e a anchura máxima é 450px. Calquera imaxe cargada que se sobrepase nalgunha das medidas será modificada ao tamaño indicado, segundo a medida que exceda.',
    'NEW_LOGO_HELP_NO_SPACE' => 'O formato do arquivo de imaxe pode ser tanto .png como .jpg. A altura máxima é 170px, e a anchura máxima é 450px. Calquera imaxe cargada que se sobrepase nalgunha das medidas será modificada ao tamaño indicado, segundo a medida que exceda.',
    'SLOW_QUERY_TIME_MSEC' => 'Tempo umbral para consultas lentas (ms)',
    'STACK_TRACE_ERRORS' => 'Mostrar traza da pila de erros',
    'UPLOAD_MAX_SIZE' => 'Tamaño máximo para subida de arquivos',
    'VERIFY_CLIENT_IP' => 'Validar enderezo IP do usuario',
    'LOCK_HOMEPAGE' => 'Non permitir o deseño personalizado da Páxina de Inicio',
    'LOCK_SUBPANELS' => 'Non permitir o deseño personalizado de subpaneis',
    'MAX_DASHLETS' => 'Máximo número de SuiteCRM Dashlets na Páxina de Inicio',
    'SYSTEM_NAME' => 'Nome do Sistema:',
    'SYSTEM_NAME_WIZARD' => 'Nome:',
    'SYSTEM_NAME_HELP' => 'Éste é o nome mostrado na barra de título do seu navegador.',
    'LBL_LDAP_TITLE' => 'Soporte de Autenticación LDAP',
    'LBL_LDAP_ENABLE' => 'Habilitar LDAP',
    'LBL_LDAP_SERVER_HOSTNAME' => 'Servidor:',
    'LBL_LDAP_SERVER_PORT' => 'Número de Porto:',
    'LBL_LDAP_ADMIN_USER' => 'Nome de Usuario:',
    'LBL_LDAP_ADMIN_USER_DESC' => 'Usado para buscar o usuario de LDAP. Podería ser necesario escribir o nome completamente cualificado do dominio.',
    'LBL_LDAP_ADMIN_PASSWORD' => 'Contrasinal:',
    'LBL_LDAP_AUTHENTICATION' => 'Autenticación:',
    'LBL_LDAP_AUTHENTICATION_DESC' => 'Conecta ao servidor LDAP usando credenciais especificas. Se non se proporcionan, a conexión sera anónima.',
    'LBL_LDAP_AUTO_CREATE_USERS' => 'Crear Usuarios Automaticamente:',
    'LBL_LDAP_USER_DN' => 'DN de Usuario:',
    'LBL_LDAP_GROUP_DN' => 'DN de Grupo:',
    'LBL_LDAP_GROUP_DN_DESC' => 'Exemplo: <em>ou=grupos,dc=exemplo,dc=com</em>',
    'LBL_LDAP_USER_FILTER' => 'Filtro de Usuarios:',
    'LBL_LDAP_GROUP_MEMBERSHIP' => 'Pertenenza a Grupos:',
    'LBL_LDAP_GROUP_MEMBERSHIP_DESC' => 'Os usuarios deben de ser membros dun grupo específico',
    'LBL_LDAP_GROUP_USER_ATTR' => 'Atributo de Usuario:',
    'LBL_LDAP_GROUP_USER_ATTR_DESC' => 'O identificador único dunha persoa que será utilizado para comprobar se son membros do grupo. Exemplo: <em>uid</em>',
    'LBL_LDAP_GROUP_ATTR_DESC' => 'O atributo do Grupo será utilizado como filtro sobre o Atributo de Usuario. Exemplo: <em>memberUid</em>',
    'LBL_LDAP_GROUP_ATTR' => 'Atributo de Grupo:',
    'LBL_LDAP_USER_FILTER_DESC' => 'Calquera parámetro de filtrado adicional a aplicar á hora de autenticar usuarios. Por exemplo:\nis_SuiteCRM_user=1 ou (is_SuiteCRM_user=1)(is_sales=1)',
    'LBL_LDAP_LOGIN_ATTRIBUTE' => 'Atributo de Inicio de Sesión:',
    'LBL_LDAP_BIND_ATTRIBUTE' => 'Atributo de Conexión (Bind):',
    'LBL_LDAP_BIND_ATTRIBUTE_DESC' => 'Para exemplos de uso de autentificación usando LDAP:[<b>AD:</b>&nbsp;userPrincipalName] [<b>openLDAP:</b>&nbsp;dn] [<b>Mac&nbsp;OS&nbsp;X:</b>&nbsp;uid] ',
    'LBL_LDAP_LOGIN_ATTRIBUTE_DESC' => 'Para exemplos de buscas de usuarios usando LDAP:[<b>AD:</b>&nbsp;userPrincipalName] [<b>openLDAP:</b>&nbsp;cn] [<b>Mac&nbsp;OS&nbsp;X:</b>&nbsp;dn] ',
    'LBL_LDAP_SERVER_HOSTNAME_DESC' => 'Exemplo: ldap.example.com ou ldaps://ldap.example.com cando se usa SSL',
    'LBL_LDAP_SERVER_PORT_DESC' => 'Exemplo: 389 ou 636 cando se usa SSL',
    'LBL_LDAP_GROUP_NAME' => 'Nome do Grupo:',
    'LBL_LDAP_GROUP_NAME_DESC' => 'Exemplo: cn=SuiteCRM',
    'LBL_LDAP_USER_DN_DESC' => 'Exemplo: ou=xente,dc=exemplo,dc=com',
    'LBL_LDAP_AUTO_CREATE_USERS_DESC' => 'Se un usuario autenticado non existe, crearase un en SuiteCRM.',
    'LBL_LDAP_ENC_KEY' => 'Clave de Encriptación:',
    'DEVELOPER_MODE' => 'Modo Desarrollador',

    'SHOW_DOWNLOADS_TAB' => 'Visualizar a pestana de descargas',
    'SHOW_DOWNLOADS_TAB_HELP' => 'Cando é seleccionada, a pestana de descarga aparecerá na configuración de Usuario e proporcionará acceso aos usuarios aos plug-ins de SuiteCRM e outros arquivos dispoñibles',
    'LBL_LDAP_ENC_KEY_DESC' => 'Para a autenticación SOAP ao usar LDAP.',
    'LDAP_ENC_KEY_NO_FUNC_DESC' => 'A extensión php_mcrypt debe estar habilitada no seu arquivo php.ini.',
    'LDAP_ENC_KEY_NO_FUNC_OPENSSL_DESC' => 'A extensión openssl debe habilitarse no arquivo php.ini.',
    'LBL_ALL' => 'Todo',
    'LBL_MARK_POINT' => 'Marcar Punto',
    'LBL_NEXT_' => 'Seguinte>>',
    'LBL_REFRESH_FROM_MARK' => 'Actualizar Desde Marca',
    'LBL_SEARCH' => 'Buscar:',
    'LBL_REG_EXP' => 'Exp. Reg.:',
    'LBL_IGNORE_SELF' => 'Ignorar Datos Propios:',
    'LBL_MARKING_WHERE_START_LOGGING' => 'Marcando Desde onde Iniciar a Traza',
    'LBL_DISPLAYING_LOG' => 'Mostrando Traza',
    'LBL_YOUR_PROCESS_ID' => 'O seu ID de proceso',
    'LBL_YOUR_IP_ADDRESS' => 'O seu enderezo IP é',
    'LBL_IT_WILL_BE_IGNORED' => 'Será ignorado',
    'LBL_LOG_NOT_CHANGED' => 'A traza non cambiou',
    'LBL_ALERT_JPG_IMAGE' => 'O formato de arquivo da imaxe debe ser JPEG.  Suba un novo arquivo cuxa extensión sexa .jpg.',
    'LBL_ALERT_TYPE_IMAGE' => 'O formato de arquivo da imaxe debe ser JPEG ou PNG.  Suba un novo arquivo cuxa extensión sexa .jpg ou .png.',
    'LBL_ALERT_SIZE_RATIO' => 'A relación de aspecto da imaxe debería estar entre 1:1 e 10:1.  a imaxe será redimensionada.',
    'ERR_ALERT_FILE_UPLOAD' => 'Erro ao subir a imaxe.',
    'LBL_LOGGER' => 'Configuración de Traza',
    'LBL_LOGGER_FILENAME' => 'Nome de Arquivo de Traza',
    'LBL_LOGGER_FILE_EXTENSION' => 'Extensión',
    'LBL_LOGGER_MAX_LOG_SIZE' => 'Tamaño máximo de traza',
    'LBL_LOGGER_DEFAULT_DATE_FORMAT' => 'Formato de data por defecto',
    'LBL_LOGGER_LOG_LEVEL' => 'Nivel de Traza',
    'LBL_LEAD_CONV_OPTION' => 'Opcións de conversión do cliente potencial',
    'LEAD_CONV_OPT_HELP' => "<b>Copiar</b> - Crea e relaciónase con copias de todas as actividades do cliente potencial para os novos rexistros que se seleccionaron polo usuario durante a conversión. As copias créanse para cada un dos rexistros seleccionados .<br><br><b>Mover</b> - Move todas as actividades do cliente potencial ao novo rexistro que seleccionou o usuario durante a conversión.<br><br><b>Non facer nada</b> - non se fai nada coas actividades do cliente potencial durante a conversión. As actividades continuaran vinculadas só ao cliente potencial.",
    'LBL_CONFIG_AJAX' => 'Configurar a interfaz de usuario AJAX',
    'LBL_CONFIG_AJAX_DESC' => 'Activar ou desactivar o uso da interfaz de usuario AJAX para módulos específicos',
    'LBL_LOGGER_MAX_LOGS' => 'Número máximo de trazas (antes de rotación)',
    'LBL_LOGGER_FILENAME_SUFFIX' => 'Agregar tras o nome de arquivo',
    'LBL_VCAL_PERIOD' => 'Período de Tempo para Actualizacións vCal:',
    'LBL_IMPORT_MAX_RECORDS' => 'Importación - Número máximo de rexistros:',
    'LBL_IMPORT_MAX_RECORDS_HELP' => 'Especificar cantas filas se permiten dentro dos arquivos a importar.<br>Se o número de filas nun arquivo de importación supera este número, o usuario recibirá unha alerta.<br>Se non se introduce un valor tenrase un número ilimitado de filas.',
    'vCAL_HELP' => 'Utilice esta opción para determinar o número de meses de antelación sobre a data actual coa que se publica a información relativa ao estado de Dispoñible/Ocupado sobre chamadas e reunións.<BR>Para desactivar a publicación do estado Dispoñible/Ocupado, introduza "0".  o mínimo é 1 mes; o máximo 12 meses.',
    'LBL_PDFMODULE_NAME' => 'Configuración PDF',
    'SUITEPDF_BASIC_SETTINGS' => 'Propiedades do Documento',
    'SUITEPDF_ADVANCED_SETTINGS' => 'Configuración Avanzada',
    'SUITEPDF_LOGO_SETTINGS' => 'Imaxes',

    'PDF_AUTHOR' => 'Autor',
    'PDF_AUTHOR_INFO' => 'O Autor aparece nas propiedades do documento.',

    'PDF_HEADER_LOGO' => 'Para Documentos PDF de Presupostos',
    'PDF_HEADER_LOGO_INFO' => 'Esta imaxe aparece na cabeceira por defecto dos documentos PDF de presupostos.',

    'PDF_NEW_HEADER_LOGO' => 'Seleccione unha nova Imaxe para as presupostos',
    'PDF_NEW_HEADER_LOGO_INFO' => 'O formato de arquivo pode ser .jpg ou .png. (Só .jpg para EZPDF)<BR>O tamaño recomendado é 867x60 px.',

    'PDF_SMALL_HEADER_LOGO' => 'Para Documentos PDF de Informes',
    'PDF_SMALL_HEADER_LOGO_INFO' => 'Esta imaxe aparece na Cabeceira por defecto dos Documentos PDF de Informes.<br> Esta imaxe tamén aparece na esquina superior esquerda da aplicación SuiteCRM.',

    'PDF_NEW_SMALL_HEADER_LOGO' => 'Seleccione unha nova imaxe para informes',
    'PDF_NEW_SMALL_HEADER_LOGO_INFO' => 'O formato de arquivo pode ser .jpg ou .png. (Só .jpg para EZPDF)<BR>O tamaño recomendado é 212x40 px.',

    'PDF_FILENAME' => 'Nome de Arquivo Por Defecto',
    'PDF_FILENAME_INFO' => 'Nome de arquivo por defecto para os arquivos PDF xerados',

    'PDF_TITLE' => 'Título',
    'PDF_TITLE_INFO' => 'O título aparece nas propiedades do documento.',

    'PDF_SUBJECT' => 'Asunto',
    'PDF_SUBJECT_INFO' => 'O Asunto aparece nas propiedades do documento.',

    'PDF_KEYWORDS' => 'Palabra(s) clave',
    'PDF_KEYWORDS_INFO' => 'Asociar Palabras clave co documento, xeralmente na forma "palabra1 palabra2..."',

    'PDF_COMPRESSION' => 'Compresión',
    'PDF_COMPRESSION_INFO' => 'Activa ou desactiva a compresión de páxina. <br>Cando foi activada, a representación interna de cada páxina comprímese, levando a niveis de ratios de compresión de aprox. 2 para o documento resultante.',

    'PDF_JPEG_QUALITY' => 'Calidade JPEG (1-100)',
    'PDF_JPEG_QUALITY_INFO' => 'Establece a calidade de compresión JPEG por defecto (1-100)',

    'PDF_PDF_VERSION' => 'Versión PDF',
    'PDF_PDF_VERSION_INFO' => 'Establece a versión de PDF (consulte a referencia PDF para valores válidos).',

    'PDF_PROTECTION' => 'Protección de Documento',
    'PDF_PROTECTION_INFO' => 'Establece a protección de documento<br>- copiar: copiar texto e imaxes ao portapapeis<br>- imprimir: imprimir o documento<br>- modificar: modificar o documento (excepto as anotacións e formularios)<br>- anot.-forms.: engadir anotacións e formularios<br>Nota: a protección ante a modificación é para xente que posúe o produto Acrobat completo.',

    'PDF_USER_PASSWORD' => 'Contrasinal de Usuario',
    'PDF_USER_PASSWORD_INFO' => 'Se non establece ningún contrasinal, o documento abrirase como de costume. <br>Se establece un contrasinal de usuario, o visor PDF solicitarase antes de mostrar o documento. <br>Se o contrasinal mestre é diferente do de usuario poderá utilizalo para obter acceso completo.',

    'PDF_OWNER_PASSWORD' => 'Contrasinal de Propietario',
    'PDF_OWNER_PASSWORD_INFO' => 'Se non establece ningún contrasinal, o documento abrirase como de costume. <br>Se establece un contrasinal de usuario, o visor PDF solicitarase antes de mostrar o documento. <br>Se o contrasinal mestre é diferente do de usuario poderá utilizalo para obter acceso completo.',

    'PDF_ACL_ACCESS' => 'Control de Acceso',
    'PDF_ACL_ACCESS_INFO' => 'Control de Acceso por defecto para a xeración do PDF.',

    'K_CELL_HEIGHT_RATIO' => 'Ratio de Altura da Celda',
    'K_CELL_HEIGHT_RATIO_INFO' => 'Se a altura dunha celda é menor que (Altura da Fonte x Ratio de Altura da Celda), entón utilizarase (Altura da Fonte x Ratio de Altura da Celda) como a altura da celda.<br>(Altura da Fonte x Ratio de Altura da Celda) tamén se utiliza como a altura da celda cando non hai ningunha altura definida.',

    'K_SMALL_RATIO' => 'Coeficiente para Fontes Pequenas',
    'K_SMALL_RATIO_INFO' => 'Coeficiente de Reducción para fontes pequenas.',

    'PDF_IMAGE_SCALE_RATIO' => 'Ratio de escalado de imaxe',
    'PDF_IMAGE_SCALE_RATIO_INFO' => 'Ratio utilizado para escalar as imaxes',

    'PDF_UNIT' => 'Unidade',
    'PDF_UNIT_INFO' => 'unidade de medida do documento',
    'PDF_GD_WARNING' => 'Non instalou a librería GD para PHP. Sen a librería GD, só se mostrarán os logos JPEG nos documentos PDF.',
    'ERR_EZPDF_DISABLE' => 'Aviso : a clase EZPDF foi deshabilitada na táboa de configuración e está establecida como a clase para PDF. Por favor, "Garde" este formulario para establecer TCPDF como a Clase PDF e volva nun estado estable.',
    'LBL_IMG_RESIZED' => "(redimensionado para ser mostrado)",


    'LBL_FONTMANAGER_BUTTON' => 'Administrador de Fontes PDF',
    'LBL_FONTMANAGER_TITLE' => 'Administrador de Fontes PDF',
    'LBL_FONT_BOLD' => 'Negrita',
    'LBL_FONT_ITALIC' => 'Cursiva',
    'LBL_FONT_BOLDITALIC' => 'Negrita/Cursiva',
    'LBL_FONT_REGULAR' => 'Normal',

    'LBL_FONT_TYPE_CID0' => 'CID-0',
    'LBL_FONT_TYPE_CORE' => 'Núcleo',
    'LBL_FONT_TYPE_TRUETYPE' => 'TrueType',
    'LBL_FONT_TYPE_TYPE1' => 'Tipo 1',
    'LBL_FONT_TYPE_TRUETYPEU' => 'TrueTypeUnicode',

    'LBL_FONT_LIST_NAME' => 'Nome',
    'LBL_FONT_LIST_FILENAME' => 'Nome de arquivo',
    'LBL_FONT_LIST_TYPE' => 'Tipo',
    'LBL_FONT_LIST_STYLE' => 'Estilo',
    'LBL_FONT_LIST_STYLE_INFO' => 'Estilo da fonte',
    'LBL_FONT_LIST_ENC' => 'Codificación',
    'LBL_FONT_LIST_EMBEDDED' => 'Incrustado',
    'LBL_FONT_LIST_EMBEDDED_INFO' => 'Marque esta opción para incrustar a fonte no arquivo PDF',
    'LBL_FONT_LIST_CIDINFO' => 'Información CID',
    'LBL_FONT_LIST_CIDINFO_INFO' => 'Para exemplos e máis axuda: www.tcpdf.org',
    'LBL_FONT_LIST_FILESIZE' => 'Tamaño de Fonte (KB)',
    'LBL_ADD_FONT' => 'Engadir unha fonte',
    'LBL_BACK' => 'Atrás',
    'LBL_REMOVE' => 'Quitar',
    'LBL_JS_CONFIRM_DELETE_FONT' => '¿Está seguro de que desexa eliminar esta fonte?',

    'LBL_ADDFONT_TITLE' => 'Engadir unha Fonte PDF',
    'LBL_PDF_ENCODING_TABLE' => 'Táboa de Codificación',
    'LBL_PDF_ENCODING_TABLE_INFO' => 'Nome da táboa de codificación.<br>Esta opción é ignorada en Unicode TrueType, Unicode OpenType e fontes con símbolos.<br>A codificación define a asociación entre un código (de 0 a 255) e un carácter contido na fonte.<br>Os primeiros 128 son fixos e correspóndense con ASCII.',
    'LBL_PDF_FONT_FILE' => 'Arquivo de Fonte',
    'LBL_PDF_FONT_FILE_INFO' => 'arquivo .ttf ou .otf ou .pfb',
    'LBL_PDF_METRIC_FILE' => 'Arquivo de Métrica',
    'LBL_PDF_METRIC_FILE_INFO' => 'arquivo .afm ou .ufm',
    'LBL_ADD_FONT_BUTTON' => 'Engadir',
    'JS_ALERT_PDF_WRONG_EXTENSION' => 'Este arquivo non ten unha extensión de arquivo adecuada.',

    'ERR_MISSING_CIDINFO' => 'O campo Información CID Information non pode estar baleiro.',
    'LBL_ADDFONTRESULT_TITLE' => 'Resultado do proceso de adición de fonte',
    'LBL_STATUS_FONT_SUCCESS' => 'ÉXITO : a fonte foi engadida a SuiteCRM.',
    'LBL_STATUS_FONT_ERROR' => 'ERRO : a fonte non foi engadida. Mire no seguinte rexistro.',

// Font manager
    'ERR_PDF_NO_UPLOAD' => 'Erro durante a subida do arquivo de fonte ou de métricas.',

// Wizard
    //Wizard Scenarios
    'LBL_WIZARD_SCENARIOS' => 'Os Teus escenarios',
    'LBL_WIZARD_SCENARIOS_EMPTY_LIST' => 'Non se configuraron escenarios',
    'LBL_WIZARD_SCENARIOS_DESC' => 'Escolle cales escenarios son os indicados para a túa instalación. Estas opcións poden ser cambias despois da instalación.',

    'LBL_WIZARD_TITLE' => 'Asistente de Administración',
    'LBL_WIZARD_WELCOME_TAB' => 'Benvido',
    'LBL_WIZARD_WELCOME_TITLE' => '¡Benvido a SuiteCRM!',
    'LBL_WIZARD_WELCOME' => 'Faga clic en <b>Seguinte</b> para establecer unha imaxe de marca, localizar e configurar SuiteCRM agora. Se desexa configurar SuiteCRM máis tarde, faga clic en <b>Saltar</b>.',
    'LBL_WIZARD_NEXT_BUTTON' => 'Seguinte >',
    'LBL_WIZARD_BACK_BUTTON' => '< Anterior',
    'LBL_WIZARD_SKIP_BUTTON' => 'Saltar',
    'LBL_WIZARD_CONTINUE_BUTTON' => 'Continuar',
    'LBL_WIZARD_FINISH_TITLE' => 'A configuración básica do sistema foi completada',
    'LBL_WIZARD_SYSTEM_TITLE' => 'Imaxe de marca',
    'LBL_WIZARD_SYSTEM_DESC' => 'Proporcione o nome e logo da súa organización para establecer a imaxe da súa marca en SuiteCRM.',
    'LBL_WIZARD_LOCALE_DESC' => 'Especifique como desexa que os datos sexan mostrados en SuiteCRM, baseándose na súa ubicación xeográfica. A configuración que proporcione aquí será a utilizada por defecto. Os usuarios poderán establecer as súas propias preferencias.',
    'LBL_WIZARD_SMTP_DESC' => 'Proporcione a conta de correo que se utilizará para enviar correos, como as notificacións de asignación e os contrasinais de novos usuarios. Os usuarios recibirán correos de SuiteCRM, como se foran enviados desde a conta de correo especificada.',
    'LBL_LOADING' => 'Cargando ...' /*for 508 compliance fix*/,
    'LBL_DELETE' => 'Eliminar' /*for 508 compliance fix*/,
    'LBL_WELCOME' => 'Benvido' /*for 508 compliance fix*/,
    'LBL_LOGO' => 'Logotipo' /*for 508 compliance fix*/,
    'LBL_ENABLE_HISTORY_CONTACTS_EMAILS' => 'Mostra os emails de contactos relacionados no subpanel History para módulos',

    // Google auth PR 6146
    'LBL_GOOGLE_AUTH_TITLE' => 'Autenticación de Google',
    'LBL_GOOGLE_AUTH_JSON' => 'Arquivo JSON',
    'LBL_GOOGLE_AUTH_JSON_HELP' => 'Cargar o arquivo JSON descargado desde consola dos desarrolladores de Google.',

);