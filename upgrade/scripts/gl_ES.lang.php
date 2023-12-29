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
    'DEFAULT_CHARSET' => 'UTF-8',
    'LBL_DISABLED_TITLE' => 'Instalación de SuiteCRM Deshabilitada',
    'LBL_DISABLED_TITLE_2' => 'A instalación de SuiteCRM foi deshabilitada',
    'LBL_DISABLED_DESCRIPTION' => 'A instalación xa se executou unha vez. Como medida de seguridade deshabilitouse unha segunda execución. Se está absolutamente seguro de que quere volver a executala, por favor vaia ao seu arquivo config.php e encontre (ou agregue) unha variable chamada \'installer_locked\' e colóquea en \'false\'. A liña debería quedar así:',
    'LBL_DISABLED_DESCRIPTION_2' => 'Despois de realizado este cambio, poderá facer click non botón "Comezar" de abaixo para comezar a instalación. <i>Unha vez finalizada a instalación, pode cambiar o valor de \'installer_locked\' a \'true\'.</i>',
    'LBL_DISABLED_HELP_1' => 'Para axuda coa instalación, por favor visite ',
    'LBL_DISABLED_HELP_2' => 'foros de soporte',

    'LBL_REG_TITLE' => 'Rexistración',
    'LBL_REG_CONF_1' => 'Por favor tome un momento para rexgistrarse en SuiteCRM. deixándonos saber un pouco acerca de como a súa empresa planea utilizar SuiteCRM, podemos asegurar que sempre lle estamos entregando o produto correcto para as súas necesidades de negocio.',
    'LBL_REG_CONF_2' => 'O seu nome e enderezo de email son os únicos campos requiridos para a rexistración. O resto dos campos son opcionais, pero de moita axuda. Non vendemos, alugamos, compartimos nin distribuimos de ningunha forma a información recolectada aquí.',
    'LBL_REG_CONF_3' => 'Grazas por rexgistrarse. Faga click no botón Finalizar para ingresar a SuiteCRM. Necesitará ingresar por primeira vez utilizando o nome de usuario "admin" e o contrasinal que ingresou no paso 2.',


    'ERR_ADMIN_PASS_BLANK' => 'O contrasinal de administrador SuiteCRM non pode estar en branco.',
    'ERR_CHECKSYS_CALL_TIME' => 'Permite chamar a pasar referencia está apagado (por favor, habilitar no php.ini)',
    'ERR_CHECKSYS_CURL' => 'Non encontrado: o planificador de tarefas de SuiteCRM executarase con funcionalidade limitada.',
    'ERR_CHECKSYS_MEM_LIMIT_1' => 'Advertencia: $memory_limit (poñer en ',
    'ERR_CHECKSYS_MEM_LIMIT_2' => 'M ou máis no seu arquivo php.ini)',
    'ERR_CHECKSYS_NO_SESSIONS' => 'Fallou a escritura e lectura de variables de sesión. non se pode avanzar coa instalación.',
    'ERR_CHECKSYS_NOT_VALID_DIR' => 'Non é un directorio válido',
    'ERR_CHECKSYS_NOT_WRITABLE' => 'Advertencia: non se pode escribir',
    'ERR_CHECKSYS_PHP_INVALID_VER' => 'Non Válido PHP versión instalada: (ver',
    'ERR_CHECKSYS_PHP_UNSUPPORTED' => 'Versión de PHP non soportada: ( ver',
    'ERR_CHECKSYS_SAFE_MODE' => 'Modo seguro está activado (por favor deshabilita en php.ini)',
    'ERR_DB_ADMIN' => 'Nome de usuario de administrador de base de datos ou o contrasinal non é válido (Erro ',
    'ERR_DB_EXISTS_NOT' => 'Base de datos especificada non existe.',
    'ERR_DB_EXISTS_WITH_CONFIG' => 'A base de datos xa existe con información de configuración. Para executar unha instalación coa base de datos seleccionada volva a executar a instalación e seleccione "Eliminar as táboas existentes e volver a crealas?". Para actualizar utilice o Asistente de Actualizacións na Consola de Administración. Por favor lea a documentación de actualización <a href="https://docs.suitecrm.com/admin/installation-guide/upgrading/" target="_new">aquí</a>.',
    'ERR_DB_EXISTS' => 'Nome da base de datos xa existe, non se pode crear outra co mesmo nome.',
    'ERR_DB_HOSTNAME' => 'O nome de Host non pode ser baleiro.',
    'ERR_DB_INVALID' => 'Tipo de base de datos seleccionado non válido.',
    'ERR_DB_LOGIN_FAILURE_MYSQL' => 'Nome de usuario de base de datos de SuiteCRM ou contrasinal inválido (Erro ',
    'ERR_DB_MYSQL_VERSION1' => 'Versión de MySQL ',
    'ERR_DB_MYSQL_VERSION2' => ' non é compatible.  Só MySQL 4.1.x e superior.',
    'ERR_DB_NAME' => 'O nome de base de datos non pode estar baleiro.',
    'ERR_DB_NAME2' => "O nome de base de datos non pode conter '\\', '/', ou '.'",
    'ERR_DB_PASSWORD' => 'Non coinciden os contrasinais de SuiteCRM.',
    'ERR_DB_PRIV_USER' => 'Nome de usuario de administrador de base de datos requirido.',
    'ERR_DB_USER_EXISTS' => 'Nome de usuario para SuiteCRM xa existe, non pode crear outro co mesmo nome.',
    'ERR_DB_USER' => 'Nome de usuario para SuiteCRM non pode estar en branco.',
    'ERR_DBCONF_VALIDATION' => 'Por favor corrixa os seguintes erros antes de continuar:',
    'ERR_ERROR_GENERAL' => 'Encontráronse os seguintes erros:',
    'ERR_LICENSE_MISSING' => 'Faltan Campos Obrigatorios',
    'ERR_LICENSE_NOT_FOUND' => 'Non se encontrou a licenza!',
    'ERR_LOG_DIRECTORY_NOT_EXISTS' => 'O directorio de Log provisto non é un directorio válido.',
    'ERR_LOG_DIRECTORY_NOT_WRITABLE' => 'O directorio de Log provisto non ten permisos de escritura.',
    'ERR_LOG_DIRECTORY_REQUIRED' => 'Requírese un directorio de Log se vostede desexa especificar un.',
    'ERR_NO_DIRECT_SCRIPT' => 'Non se pode procesar o script de forma directa.',
    'ERR_PASSWORD_MISMATCH' => 'Non coinciden os contrasinais de administrador de SuiteCRM.',
    'ERR_PERFORM_CONFIG_PHP_1' => 'Non se pode escribir o arquivo <span class=stop>config.php</span>.',
    'ERR_PERFORM_CONFIG_PHP_2' => 'Pode continuar con esta instalación creando manualmente o arquivo config.php e pegando a seguinte información de configuración dentro do arquivo.  De todos modos, vostede <strong>debería </strong>crear o arquivo config.php antes de continuar co seguinte paso.',
    'ERR_PERFORM_CONFIG_PHP_3' => 'Acordouse de crear o arquivo config.php?',
    'ERR_PERFORM_CONFIG_PHP_4' => 'Advertencia: non se puido escribir o arquivo config.php.  Asegúrese de que existe.',
    'ERR_PERFORM_HTACCESS_1' => 'Non se pode escribir o arquivo ',
    'ERR_PERFORM_HTACCESS_2' => ' .',
    'ERR_PERFORM_HTACCESS_3' => 'Se desexa protexer o seu arquivo de log de ser accedido via navegador, cree un arquivo .htaccess na súa carpeta log coa liña:',
    'ERR_PERFORM_NO_TCPIP' => '<b>Non puidemos detectar unha conexión a Internet.</b> Cando teña unha conexión, por favor visite <a href=\\"http://www.suitecrm.com\\">http://www.suitecrm.com</a> para rexgistrarse con SuiteCRM. Se nos conta un pouco como a súa compañía planea utilizar SuiteCRM poderemos asegurarnos de entregarlle a aplicación correcta para as necesidades do seu negocio.',
    'ERR_SESSION_DIRECTORY_NOT_EXISTS' => 'O directorio de Sesión provisto non é un directorio válido.',
    'ERR_SESSION_DIRECTORY' => 'O directorio de Sesión provisto non ten permisos de escritura.',
    'ERR_SESSION_PATH' => 'Requírese unha ruta de Sesión, se é que desexa especificar unha.',
    'ERR_SI_NO_CONFIG' => 'Non incluiu o arquivo config_si.php no directorio raíz, ou non definiu a variable $sugar_config_si en config.php',
    'ERR_SITE_GUID' => 'Requíreseun ID de Aplicación se é que desexa especificar un.',
    'ERR_URL_BLANK' => 'A URL non pode estar en branco.',
    'LBL_BACK' => 'Atrás',
    'LBL_CHECKSYS_1' => 'Para que a súa instalación de SuiteCRM funcione correctamente, por favor asegúrese de que todos os items por verificar listados máis abaixo estean en verde. Se encontra algún en vermello, por favor realice os pasos necesarios para solucionalos.',
    'LBL_CHECKSYS_CACHE' => 'Sub-Directories de Cache Editables',
    'LBL_CHECKSYS_CALL_TIME' => 'PHP Allow Call Time Pass Reference desactivado',
    'LBL_CHECKSYS_COMPONENT' => 'Compoñente',
    'LBL_CHECKSYS_CONFIG' => 'Arquivo de Configuración editable (config.php)',
    'LBL_CHECKSYS_CURL' => 'Módulo cURL',
    'LBL_CHECKSYS_CUSTOM' => 'Directorio Custom editable',
    'LBL_CHECKSYS_DATA' => 'Subdirectorios de Data editables',
    'LBL_CHECKSYS_MEM_OK' => 'OK (Sen Límite)',
    'LBL_CHECKSYS_MEM_UNLIMITED' => 'OK (Ilimitado)',
    'LBL_CHECKSYS_MEM' => 'Límite de Memoria PHP >= ',
    'LBL_CHECKSYS_MODULE' => 'Subdirectorios e Arquivos de módulos editables',
    'LBL_CHECKSYS_NOT_AVAILABLE' => 'Non dispoñible',
    'LBL_CHECKSYS_OK' => 'Aceptar',
    'LBL_CHECKSYS_PHP_INI' => '<b>Nota:</b> Ubicación do seu arquivo de configuración PHP (php.ini):',
    'LBL_CHECKSYS_PHP_OK' => 'OK (ver ',
    'LBL_CHECKSYS_PHPVER' => 'Versión de PHP',
    'LBL_CHECKSYS_RECHECK' => 'Volver a Verificar',
    'LBL_CHECKSYS_SAFE_MODE' => 'PHP Safe Mode desactivado',
    'LBL_CHECKSYS_SESSION' => 'Directorio de Sesión Editable (',
    'LBL_CHECKSYS_STATUS' => 'Estado',
    'LBL_CHECKSYS_TITLE' => 'Aceptación de Verificación do Sistema',
    'LBL_CHECKSYS_XML' => 'Análise XML',
    'LBL_CLOSE' => 'Cerrar',
    'LBL_CONFIRM_BE_CREATED' => 'creada',
    'LBL_CONFIRM_DB_TYPE' => 'Tipo de Base de Datos',
    'LBL_CONFIRM_DIRECTIONS' => 'Por favor confirme a seguinte configuración.  Se desexa cambiar algún dos valores, faga click en "Atrás" para editar. Do contrario faga click en "Seguinte" para comezar a instalación.',
    'LBL_CONFIRM_LICENSE_TITLE' => 'Información de Licenza',
    'LBL_CONFIRM_NOT' => 'non',
    'LBL_CONFIRM_TITLE' => 'Confirmar configuración',
    'LBL_CONFIRM_WILL' => 'será',
    'LBL_DBCONF_CREATE_DB' => 'Crear Base de Datos',
    'LBL_DBCONF_CREATE_USER' => 'Crear Usuario',
    'LBL_DBCONF_DB_DROP_CREATE_WARN' => 'Atención: Toda a información de SuiteCRM será eliminada<br>se se marca esta casilla.',
    'LBL_DBCONF_DB_DROP_CREATE' => 'Eliminar as táboas existentes e volver a crealas?',
    'LBL_DBCONF_DB_NAME' => 'Nome de Base de Datos',
    'LBL_DBCONF_DB_PASSWORD' => 'Contrasinal do Usuario de Base de Datos',
    'LBL_DBCONF_DB_PASSWORD2' => 'Volva a Ingresar Contrasinal do Usuario de Base de Datos',
    'LBL_DBCONF_DB_USER' => 'Nome de Usuario de Base de Datos',
    'LBL_DBCONF_DEMO_DATA' => 'Encher a Base de Datos con Información de Proba?',
    'LBL_DBCONF_HOST_NAME' => 'Nome do Host',
    'LBL_DBCONF_INSTRUCTIONS' => 'Por favor ingrese a información da súa configuración a continuación. Se non está seguro do que debe completar, lle suxerimos que use os valores por defecto.',
    'LBL_DBCONF_MB_DEMO_DATA' => 'Usar texto multi-byte na información de proba?',
    'LBL_DBCONF_PRIV_PASS' => 'Contrasinal do usuario privilexiado da Base de Datos',
    'LBL_DBCONF_PRIV_USER_2' => '¿A conta de base de datos de arriba é dun Usuario Privilexiado?',
    'LBL_DBCONF_PRIV_USER_DIRECTIONS' => 'Este usuario privilexiado de base de datos debe ter os permisos adecuados para crear unha base de datos, eliminar/crear táboas, e crear un usuario. Este usuario privilexiado de base de datos só será utilizado para realizar as tarefas necesarias durante o proceso de instalación. Se este usuario ten permisos suficientes, tamén pode utilizalo como usuario de base de datos.',
    'LBL_DBCONF_PRIV_USER' => 'Nome do Usuario Privilexiado de Base de Datos',
    'LBL_DBCONF_TITLE' => 'Configuración da Base de Datos',
    'LBL_HELP' => 'Axuda',
    'LBL_LICENSE_ACCEPTANCE' => 'Aceptación de Licenza',
    'LBL_LICENSE_DIRECTIONS' => 'Se ten a información da súa licenza, por favor ingrésea nos seguintes campos.',
    'LBL_LICENSE_DOWNLOAD_KEY' => 'Clave de Descarga',
    'LBL_LICENSE_EXPIRY' => 'Data de Vencemento',
    'LBL_LICENSE_I_ACCEPT' => 'Acepto',
    'LBL_LICENSE_NUM_USERS' => 'Cantidade de Usuarios',
    'LBL_LICENSE_OC_DIRECTIONS' => 'Por favor ingrese a cantidade de clientes offline adquiridos.',
    'LBL_LICENSE_OC_NUM' => 'Cantidade de Licenzas de Clientes Offline',
    'LBL_LICENSE_OC' => 'Licenzas de Clientes Offline',
    'LBL_LICENSE_PRINTABLE' => ' Versión Imprimible ',
    'LBL_LICENSE_TITLE' => 'Información de Licenza',
    'LBL_LICENSE_TITLE_2' => 'Licenza SuiteCRM',
    'LBL_LICENSE_USERS' => 'Licenzas de Usuario',
    'LBL_MYSQL' => 'MySQL',
    'LBL_NEXT' => 'Seguinte',
    'LBL_NO' => 'No',
    'LBL_ORACLE' => 'Oracle',
    'LBL_PERFORM_ADMIN_PASSWORD' => 'Establecendo password de admin',
    'LBL_PERFORM_AUDIT_TABLE' => 'táboa de auditoría / ',
    'LBL_PERFORM_CONFIG_PHP' => 'Creando o arquivo de configuración de SuiteCRM',
    'LBL_PERFORM_CREATE_DB_1' => 'Creando a base de datos ',
    'LBL_PERFORM_CREATE_DB_2' => ' en ',
    'LBL_PERFORM_CREATE_DB_USER' => 'Creando nome de usuario e password da Base de datos...',
    'LBL_PERFORM_CREATE_DEFAULT' => 'Creando información por defecto de SuiteCRM',
    'LBL_PERFORM_CREATE_LOCALHOST' => 'Creando nome de usuario e password de base de datos para localhost...',
    'LBL_PERFORM_CREATE_RELATIONSHIPS' => 'Creando táboas de relación para suiteCRM',
    'LBL_PERFORM_CREATING' => 'creando / ',
    'LBL_PERFORM_DEFAULT_REPORTS' => 'Creando reportes por defecto',
    'LBL_PERFORM_DEFAULT_SCHEDULER' => 'Creando tarefas planificadas por defecto',
    'LBL_PERFORM_DEFAULT_SETTINGS' => 'Insertando configuración por defecto',
    'LBL_PERFORM_DEFAULT_USERS' => 'Creando usuarios por defecto',
    'LBL_PERFORM_DEMO_DATA' => 'Enchendo as táboas da base de datos con Información de Proba (isto pode tomar varios minutos)...',
    'LBL_PERFORM_DONE' => 'listo<br>',
    'LBL_PERFORM_DROPPING' => 'eliminando / ',
    'LBL_PERFORM_FINISH' => 'Finalizar',
    'LBL_PERFORM_LICENSE_SETTINGS' => 'Actualizando a información da licenza',
    'LBL_PERFORM_OUTRO_1' => 'A configuración de SuiteCRM ',
    'LBL_PERFORM_OUTRO_2' => ' finalizou!',
    'LBL_PERFORM_OUTRO_3' => 'Tempo total: ',
    'LBL_PERFORM_OUTRO_4' => ' segundos.',
    'LBL_PERFORM_OUTRO_5' => 'Memoria utilizada (aprox): ',
    'LBL_PERFORM_OUTRO_6' => ' bytes.',
    'LBL_PERFORM_OUTRO_7' => 'O seu sistema xa está instalado e configurado para ser utilizado.',
    'LBL_PERFORM_REL_META' => 'metadatos de relacións ... ',
    'LBL_PERFORM_SUCCESS' => 'Éxito!',
    'LBL_PERFORM_TABLES' => 'Creando as táboas da aplicación, táboas de auditoría e metadatos de relacións...',
    'LBL_PERFORM_TITLE' => 'Configurar',
    'LBL_PRINT' => 'Imprimir',
    'LBL_REQUIRED' => '* Campo Requirido',
    'LBL_SITECFG_ADMIN_PASS_2' => 'Volva a Ingresar o contrasinal do <em>Usuario Administrador</em>',
    'LBL_SITECFG_ADMIN_PASS_WARN' => 'Atención: Isto sobreescribirá o contrasinal do administrador de calquera instalación anterior.',
    'LBL_SITECFG_ADMIN_PASS' => 'Contrasinal do <em>Usuario Administrador</em> de SuiteCRM',
    'LBL_SITECFG_APP_ID' => 'ID da Aplicación',
    'LBL_SITECFG_CUSTOM_ID_DIRECTIONS' => 'Se se selecciona, deberá proveer un ID de Aplicación para sobreescribir o ID autoxerado. O ID asegura que as sesións dunha instancia de SuiteCRM non sexan usadas por outras instancia. Se ten un cluster de instalacións de SuiteCRM, todas deberían compartir o mesmo ID de aplicación.',
    'LBL_SITECFG_CUSTOM_ID' => 'Provea o seu propio ID de Aplicación',
    'LBL_SITECFG_CUSTOM_LOG_DIRECTIONS' => 'Se se selecciona, deberá especificar un directorio de logs para sobreescribir o directorio por defecto do log de SuiteCRM. Sen importar dónde estea ubicado o arquivo de log, o acceso a través de navegador deberase restrinxir utilizando unha redirección .htacces.',
    'LBL_SITECFG_CUSTOM_LOG' => 'Utilizar un Directorio Personalizado para Logs',
    'LBL_SITECFG_CUSTOM_SESSION_DIRECTIONS' => 'Se se selecciona, deberá proveer un directorio seguro para almacenar a información de sesións de SuiteCRM. Isto pódese facer para evitar que a información da sesión sexa vulnerada en servidores compartidos.',
    'LBL_SITECFG_CUSTOM_SESSION' => 'Utilizar un Directorio Personalizado para as Sesións de SuiteCRM',
    'LBL_SITECFG_DIRECTIONS' => 'Por favor ingrese a configuración do seu sitio a continuación. Se non está seguro dos campos, suxerímoslle utilizar os valores por defecto.',
    'LBL_SITECFG_FIX_ERRORS' => 'Por favor corrixa os seguintes erros antes de continuar:',
    'LBL_SITECFG_LOG_DIR' => 'Directorio de Log',
    'LBL_SITECFG_SESSION_PATH' => 'Ruta do Directorio de Sesións<br>(debe ser editable)',
    'LBL_SITECFG_SITE_SECURITY' => 'Seleccionar Opcións de Seguridade',
    'LBL_SITECFG_SUGAR_UP_DIRECTIONS' => 'Cando está habilitado o sistema SuiteCRM Inc. enviará periódicamente estadísticas anónimas acerca da instalación que nos axudará a entender os patróns de uso e melloras do produto.  A cambio desta información, os administradores recibirán avisos de actualización cando haxa novas versións ou actualizacións.',
    'LBL_SITECFG_SUGAR_UP' => '¿Verificar Automaticamente novas Actualizacións?',
    'LBL_SITECFG_SUGAR_UPDATES' => 'Configuración de Actualizacións de SuiteCRM',
    'LBL_SITECFG_TITLE' => 'Configuración do Sitio',
    'LBL_SITECFG_URL' => 'URL da Instancia de SuiteCRM',
    'LBL_SITECFG_USE_DEFAULTS' => '¿Utilizar valores por defecto?',
    'LBL_START' => 'Comezar',
    'LBL_STEP' => 'Paso',
    'LBL_TITLE_WELCOME' => 'Benvido a SuiteCRM ',
    'LBL_WELCOME_1' => 'Este instalador crea as táboas da base de datos de SuiteCRM e establece os valores de configuración que vostede necesita para comezar. O proceso completo debería tomar aproximadamente dez minutos.',
    'LBL_WELCOME_2' => 'Para obter documentación da instalación, por favor visite os <a href="https://suitecrm.com/suitecrm/forum/suite-forum" target="_blank">Foros de apoio SuiteCRM</a>.',
    'LBL_WELCOME_CHOOSE_LANGUAGE' => 'Seleccione o seu idioma',
    'LBL_WELCOME_SETUP_WIZARD' => 'Asistente de Configuración',
    'LBL_WELCOME_TITLE_WELCOME' => 'Benvido a SuiteCRM ',
    'LBL_WELCOME_TITLE' => 'Asistente de Configuración de SuiteCRM',
    'LBL_WIZARD_TITLE' => 'Asistente de Configuración de SuiteCRM: paso ',
    'LBL_YES' => 'Si',
);
