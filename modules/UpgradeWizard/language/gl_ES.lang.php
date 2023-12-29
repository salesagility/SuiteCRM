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
    'ERR_UW_CANNOT_DETERMINE_GROUP' => 'Non se puido determinar o Grupo',
    'ERR_UW_CANNOT_DETERMINE_USER' => 'Non se puido determinar o Propietario',
    'ERR_UW_CONFIG_WRITE' => 'Erro ao actualizar config.php coa información da nova versión.',
    'ERR_UW_CONFIG' => 'Por favor, habilite os permisos de escritura para o seu arquivo config.php, e recargue esta páxina.',
    'ERR_UW_DIR_NOT_WRITABLE' => 'Directorio non escribible/editable',
    'ERR_UW_FILE_NOT_COPIED' => 'Arquivo non copiado',
    'ERR_UW_FILE_NOT_DELETED' => 'Problema ao quitar o paquete',
    'ERR_UW_FILE_NOT_READABLE' => 'O arquivo non puido ser lido.',
    'ERR_UW_FILE_NOT_WRITABLE' => 'O arquivo non puido ser movido ou escrito/editado',
    'ERR_UW_FLAVOR_2' => 'Edición da Actualización:',
    'ERR_UW_FLAVOR' => 'Edición do Sistema SuiteCRM: ',
    'ERR_UW_LOG_FILE_UNWRITABLE' => './upgradeWizard.log non puido ser creado/escrito.  Por favor, corrixa os permisos no seu directorio de SuiteCRM.',
    'ERR_UW_MBSTRING_FUNC_OVERLOAD' => 'mbstring.func_overload está establecido a un valor maior que 1.  Por favor, cambie isto no seu arquivo php.ini e reinicie o seu servidor web.',
    'ERR_UW_NO_FILE_UPLOADED' => '¡Por favor, especifique un arquivo e inténteo de novo!',
    'ERR_UW_NO_FILES' => 'Ocurreu un erro, non se encontraron arquivos para comprobar.',
    'ERR_UW_NO_MANIFEST' => 'O arquivo zip non contén un arquivo manifest.php.  non se pode continuar.',
    'ERR_UW_NO_VIEW' => 'A vista especificada non é válida.',
    'ERR_UW_NOT_VALID_UPLOAD' => 'Subida non válida.',
    'ERR_UW_NO_CREATE_TMP_DIR' => 'Non puido crearse o directorio temporal. Comprobe os permisos de ficheiros.',
    'ERR_UW_ONLY_PATCHES' => 'Só pode subir parches nesta páxina.',
    'ERR_UW_PREFLIGHT_ERRORS' => 'Encontráronse erros durante a comprobación previa',
    'ERR_UW_UPLOAD_ERR' => 'Ocurreu un erro na subida do arquivo, por favor, ¡inténteo de novo!<br>' . PHP_EOL,
    'ERR_UW_VERSION' => 'Versión do Sistema SuiteCRM: ',
    'ERR_UW_PHP_VERSION' => 'Versión de PHP: ',
    'ERR_UW_SUITECRM_VERSION' => 'Versión do Sistema SuiteCRM: ',
    'ERR_UW_WRONG_TYPE' => 'Esta páxina non é para executar',
    'LBL_BUTTON_BACK' => '< Atrás',
    'LBL_BUTTON_CANCEL' => 'Cancelar',
    'LBL_BUTTON_DELETE' => 'Eliminar Paquete',
    'LBL_BUTTON_DONE' => 'Feito',
    'LBL_BUTTON_EXIT' => 'Saír',
    'LBL_BUTTON_NEXT' => 'Seguinte>',
    'LBL_BUTTON_RECHECK' => 'Comprobar de novo',
    'LBL_BUTTON_RESTART' => 'Reiniciar',

    'LBL_UPLOAD_UPGRADE' => 'Subir un Paquete de Actualización',
    'LBL_UW_BACKUP_FILES_EXIST_TITLE' => 'Copia de seguridade',
    'LBL_UW_BACKUP_FILES_EXIST' => 'A copia de seguridade dos arquivos desta actualización poden encontrarse en',
    'LBL_UW_BACKUP' => 'Copia de seguridade',
    'LBL_UW_CANCEL_DESC' => 'A actualización foi cancelada. Os arquivos temporais copiados e os arquivos de actualización subidos foron eliminados.',
    'LBL_UW_CHECK_ALL' => 'Comprobar Todo',
    'LBL_UW_CHECKLIST' => 'Pasos da Actualización',
    'LBL_UW_COMMIT_ADD_TASK_DESC_1' => 'Copias de seguridade de arquivos sobrescritos están no seguinte directorio: ' . PHP_EOL,
    'LBL_UW_COMMIT_ADD_TASK_DESC_2' => 'Combinar manualmente os seguintes arquivos: ' . PHP_EOL,
    'LBL_UW_COMMIT_ADD_TASK_NAME' => 'Proceso de Actualización: Combinar Manualmente Arquivos',
    'LBL_UW_COMMIT_ADD_TASK_OVERVIEW' => 'Por favor, utilice calquera método diff que lle sexa máis familiar para combinar estos arquivos.  Ata que non teña completado este proceso, a súa instalación de SuiteCRM estará nun estado incerto, e a actualización incompleta.',
    'LBL_UW_COMPLETE' => 'Completado',
    'LBL_UW_COMPLIANCE_ALL_OK' => 'Todos os Requirimentos do Sistema foron Satisfeitos',
    'LBL_UW_COMPLIANCE_CALLTIME' => 'Configuración de PHP: Paso por Referencia en Tempo de Chamada',
    'LBL_UW_COMPLIANCE_CURL' => 'Módulo cURL',
    'LBL_UW_COMPLIANCE_IMAP' => 'Módulo IMAP',
    'LBL_UW_COMPLIANCE_MBSTRING' => 'Módulo MBStrings',
    'LBL_UW_COMPLIANCE_MBSTRING_FUNC_OVERLOAD' => 'Parámetro mbstring.func_overload de MBStrings',
    'LBL_UW_COMPLIANCE_MEMORY' => 'Configuración de PHP: Límite de Memoria',
    'LBL_UW_COMPLIANCE_STREAM' => 'Configuración PHP: Stream',
    'LBL_UW_COMPLIANCE_DB' => 'Versión minima de Base de Datos',
    'LBL_UW_COMPLIANCE_PHP_INI' => 'Ruta de php.ini',
    'LBL_UW_COMPLIANCE_PHP_VERSION' => 'Versión Mínima de PHP',
    'LBL_UW_COMPLIANCE_SAFEMODE' => 'Configuración de PHP: Modo Seguro',
    'LBL_UW_COMPLIANCE_TITLE2' => 'Configuración Detectada',
    'LBL_UW_COMPLIANCE_XML' => 'Análise XML',
    'LBL_UW_COMPLIANCE_ZIPARCHIVE' => 'Soporte Zip',
    'LBL_UW_COMPLIANCE_PCRE_VERSION' => 'Versión PCRE',
    'LBL_UW_COPIED_FILES_TITLE' => 'Arquivos Copiados con Éxito',

    'LBL_UW_DB_CHOICE1' => 'O Asistente de Actualizacións executará o SQL',
    'LBL_UW_DB_CHOICE2' => 'Consultas de SQL Lanzadas Manualmente',
    'LBL_UW_DB_ISSUES_PERMS' => 'Privilexios de Base de datos',
    'LBL_UW_DB_METHOD' => 'Método de Actualización en Base de Datos',
    'LBL_UW_DB_NO_ADD_COLUMN' => 'ALTER TABLE [table] ADD COLUMN [column]',
    'LBL_UW_DB_NO_CHANGE_COLUMN' => 'ALTER TABLE [table] CHANGE COLUMN [column]',
    'LBL_UW_DB_NO_CREATE' => 'CREATE TABLE [table]',
    'LBL_UW_DB_NO_DELETE' => 'DELETE FROM [table]',
    'LBL_UW_DB_NO_DROP_COLUMN' => 'ALTER TABLE [table] DROP COLUMN [column]',
    'LBL_UW_DB_NO_DROP_TABLE' => 'DROP TABLE [table]',
    'LBL_UW_DB_NO_ERRORS' => 'Todos os Privilexios Dispoñibles',
    'LBL_UW_DB_NO_INSERT' => 'INSERT INTO [table]',
    'LBL_UW_DB_NO_SELECT' => 'SELECT [x] FROM [table]',
    'LBL_UW_DB_NO_UPDATE' => 'UPDATE [table]',
    'LBL_UW_DB_PERMS' => 'Privilexio Necesario',

    'LBL_UW_DESC_MODULES_INSTALLED' => 'Os seguintes paquetes de actualización foron instalados:',
    'LBL_UW_END_LOGOUT_PRE' => 'A actualización completouse.',
    'LBL_UW_END_LOGOUT_PRE2' => 'Faga clic en Feito para saír do Asistente de Actualizacións.',
    'LBL_UW_END_LOGOUT' => 'Se ten previsto aplicar calquera outro paquete de actualización utilizando o Asistente de Actualizacións, cerre antes a sesión e iníciea de novo.',

    'LBL_UW_FILE_DELETED' => ' foi eliminado.<br>',
    'LBL_UW_FILE_GROUP' => 'Grupo',
    'LBL_UW_FILE_ISSUES_PERMS' => 'Permisos de Arquivo',
    'LBL_UW_FILE_NO_ERRORS' => '<b>Todos os Arquivos son Escribibles</b>',
    'LBL_UW_FILE_OWNER' => 'Propietario',
    'LBL_UW_FILE_PERMS' => 'Permisos',
    'LBL_UW_FILE_UPLOADED' => ' foi subido',
    'LBL_UW_FILE' => 'Nome de Arquivo',
    'LBL_UW_FILES_QUEUED' => 'Os seguintes paquetes de actualización están listos para ser instalados:',
    'LBL_UW_FILES_REMOVED' => 'Os seguintes arquivos eliminaranse do sistema: <br>' . PHP_EOL,
    'LBL_UW_NEXT_TO_UPLOAD' => '<b>Faga clic en Seguinte para subir os paquetes de actualización.</b>',
    'LBL_UW_FROZEN' => 'Suba un paquete antes de continuar.',
    'LBL_UW_HIDE_DETAILS' => 'Ocultar Detalles',
    'LBL_UW_IN_PROGRESS' => 'En Progreso',
    'LBL_UW_INCLUDING' => 'Incluíndo',
    'LBL_UW_INCOMPLETE' => 'Incompleto',
    'LBL_UW_MANUAL_MERGE' => 'Combinación de Arquivos',
    'LBL_UW_MODULE_READY' => 'O módulo está listo para ser instalado. Pulsa en Proceder para realizar a instalación.',
    'LBL_UW_NO_INSTALLED_UPGRADES' => 'Non se detectaron Actualizacións rexistradas.',
    'LBL_UW_NONE' => 'Ningún',
    'LBL_UW_OVERWRITE_DESC' => 'Todos os arquivos cambiados serán sobrescritos, incluíndo calquera personalización ao código fonte e cambios as plantillas que puido realizar. ¿Está seguro de que desexa proceder?',

    'LBL_UW_PREFLIGHT_ADD_TASK' => '¿Crear Tarefa para Combinación Manual?',
    'LBL_UW_PREFLIGHT_EMAIL_REMINDER' => 'Enviarse a si mesmo un Email Recordatorio para a Combinación Manual?',
    'LBL_UW_PREFLIGHT_FILES_DESC' => 'Os seguintes arquivos foron modificados.  Desmarque os elementos que requiren unha combinación manual. <i>Os cambios de deseño detectados son desmarcados automaticamente; marque os que deberían ser sobrescritos.',
    'LBL_UW_PREFLIGHT_NO_DIFFS' => 'Non se require Combinación Manual de Arquivos.',
    'LBL_UW_PREFLIGHT_NOT_NEEDED' => 'Non é necesario.',
    'LBL_UW_PREFLIGHT_PRESERVE_FILES' => 'Arquivos Auto-preservados:',
    'LBL_UW_PREFLIGHT_TESTS_PASSED' => 'Todos os tests de inspección previa foron satisfactorios.',
    'LBL_UW_PREFLIGHT_TESTS_PASSED2' => 'Faga clic en Seguinte para copiar os arquivos actualizados ao sistema.',
    'LBL_UW_PREFLIGHT_TESTS_PASSED3' => '<b>Nota: </b>O resto do proceso de actualización é obrigatorio, e se pulsa Seguinte terá que completar o proceso. Se non desexa continuar, faga clic non botón Cancelar.',
    'LBL_UW_PREFLIGHT_TOGGLE_ALL' => 'Cambiar Todos os Arquivos',

    'LBL_UW_REBUILD_TITLE' => 'Reconstruir Resultado',
    'LBL_UW_SCHEMA_CHANGE' => 'Cambios no Esquema',

    'LBL_UW_SHOW_COMPLIANCE' => 'Mostrar Configuración Detectada',
    'LBL_UW_SHOW_DB_PERMS' => 'Mostrar Permisos de Base de datos que Faltan',
    'LBL_UW_SHOW_DETAILS' => 'Mostrar Detalles',
    'LBL_UW_SHOW_DIFFS' => 'Mostrar Arquivos que Requiren Combinanción Manual',
    'LBL_UW_SHOW_NW_FILES' => 'Mostrar Arquivos con Permisos Incorrectos',
    'LBL_UW_SHOW_SCHEMA' => 'Mostrar Script de Cambios ao Esquema',
    'LBL_UW_SHOW_SQL_ERRORS' => 'Mostrar Consultas Erróneas',
    'LBL_UW_SHOW' => 'Mostrar',

    'LBL_UW_SKIPPED_FILES_TITLE' => 'Arquivos Omitidos',
    'LBL_UW_SQL_RUN' => 'Comprobar cando se teña executado o SQL manualmente',
    'LBL_UW_START_DESC' => 'Este asistente axudaralleá a actualizar esta instancia de SuiteCRM.',
    'LBL_UW_START_DESC2' => 'Nota: recomendámoslle que cree unha copia da instancia de SuiteCRM que se utiliza en produción e probe o paquete de actualización antes de implementar a nova versión. Se cambiou o arquivo "composer.json", execute despois de finalizado o proceso de actualización:<br/><br/><pre>composer install --no-dev</pre>', // Keep the <pre>composer install --no-dev</pre> words at the end of the sentence and do not translate it
    'LBL_UW_START_DESC3' => 'Faga clic en Seguinte para realizar unha comprobación do seu sistema e asegurar que está listo para a actualización. As comprobacións inclúen permisos de arquivos, privilexios de base de datos, e configuración do servidor.',
    'LBL_UW_START_UPGRADED_UW_DESC' => 'O novo Asistente de Actualizacións continuará co proceso de instalación. Por favor, continue coa súa actualización.',
    'LBL_UW_START_UPGRADED_UW_TITLE' => 'Benvido ao novo Asistente de Actualizacións',

    'LBL_UW_TITLE_CANCEL' => 'Cancelar',
    'LBL_UW_TITLE_COMMIT' => 'Realizar Actualización',
    'LBL_UW_TITLE_END' => 'Informe',
    'LBL_UW_TITLE_PREFLIGHT' => 'Comprobacións Previas',
    'LBL_UW_TITLE_START' => 'Benvido',
    'LBL_UW_TITLE_SYSTEM_CHECK' => 'Comprobación do Sistema',
    'LBL_UW_TITLE_UPLOAD' => 'Subir Paquete',
    'LBL_UW_TITLE' => 'Asistente de Actualizacións',
    'LBL_UW_UNINSTALL' => 'Desinstalar',
    //500 upgrade labels
    'LBL_UW_ACCEPT_THE_LICENSE' => 'Aceptar Licenza',
    'LBL_UW_CONVERT_THE_LICENSE' => 'Convertir Licenza',

    'LBL_START_UPGRADE_IN_PROGRESS' => 'Inicio en progreso',
    'LBL_SYSTEM_CHECKS_IN_PROGRESS' => 'Comprobación do Sistema en Progreso',
    'LBL_LICENSE_CHECK_IN_PROGRESS' => 'Comprobación de Licenza en progreso',
    'LBL_PREFLIGHT_CHECK_IN_PROGRESS' => 'Comprobacións Previas en Progreso',
    'LBL_PREFLIGHT_FILE_COPYING_PROGRESS' => 'Copia de Arquivos en Proceso',
    'LBL_COMMIT_UPGRADE_IN_PROGRESS' => 'Realización da Actualización en Progreso',
    'LBL_UW_COMMIT_DESC' => 'Pulse Seguinte para executar "scripts" ou comandos de actualización.',
    'LBL_UPGRADE_SCRIPTS_IN_PROGRESS' => 'Scripts de Actualización en Progreso',
    'LBL_UPGRADE_SUMMARY_IN_PROGRESS' => 'Resumo da Actualización en Progreso',
    'LBL_UPGRADE_IN_PROGRESS' => 'en progreso',
    'LBL_UPGRADE_TIME_ELAPSED' => 'Tempo transcorrido',
    'LBL_UPGRADE_CANCEL_IN_PROGRESS' => 'Cancelación de Actualización e Limpeza en Progreso',
    'LBL_UPGRADE_TAKES_TIME_HAVE_PATIENCE' => 'A actualización pode durar un rato',
    'LBL_UPLOADE_UPGRADE_IN_PROGRESS' => 'Comprobacións de Subida en Progreso',
    'LBL_UPLOADING_UPGRADE_PACKAGE' => 'Subindo Paquete de Actualización',
    'LBL_UW_DROP_SCHEMA_UPGRADE_WIZARD' => 'O Asistente de Actualizacións Eliminará o antiguo esquema 4.5.1',
    'LBL_UW_DROP_SCHEMA_MANUAL' => 'Eliminación Manual do Esquema Post-instalación',
    'LBL_UW_DROP_SCHEMA_METHOD' => 'Método de Eliminación de Antiguo Esquema',
    'LBL_UW_SHOW_OLD_SCHEMA_TO_DROP' => 'Mostrar o Antiguo Esquema que sería eliminado',
    'LBL_UW_SKIPPED_QUERIES_ALREADY_EXIST' => 'Consultas Saltadas',
    'LBL_INCOMPATIBLE_PHP_VERSION' => 'Requírese a versión de PHP 5 ou superior.',
    'ERR_CHECKSYS_PHP_INVALID_VER' => 'A súa versión de PHP non está soportada por SuiteCRM.  Necesitará instalar unha versión que sexa compatible coa aplicación SuiteCRM.  Por favor, consulte a Matriz de Compatibilidade nas Notas de Lanzamento para información sobre as Versións de PHP soportadas. A súa versión é a ',
    'LBL_BACKWARD_COMPATIBILITY_ON' => 'O modo de compatibilidade cara atrás de PHP está habilitado. Estableza zend.ze1_compatibility_mode a Off antes de continuar',
    //including some strings from moduleinstall that are used in Upgrade
    'LBL_ML_ACTION' => 'Acción',
    'LBL_ML_CANCEL' => 'Cancelar',
    'LBL_ML_COMMIT' => 'Proceder',
    'LBL_ML_DESCRIPTION' => 'Descrición',
    'LBL_ML_INSTALLED' => 'Data de Instalación',
    'LBL_ML_NAME' => 'Nome',
    'LBL_ML_PUBLISHED' => 'Data de Publicación',
    'LBL_ML_TYPE' => 'Tipo',
    'LBL_ML_UNINSTALLABLE' => 'Desinstalable',
    'LBL_ML_VERSION' => 'Versión',
    'LBL_ML_INSTALL' => 'Instalar',
    //adding the string used in tracker. copying from homepage
    'LBL_CURRENT_PHP_VERSION' => 'A súa versión actual de PHP é: ',
    'LBL_RECOMMENDED_PHP_VERSION_1' => 'A version php recomendada é ',
    'LBL_RECOMMENDED_PHP_VERSION_2' => ' ou superior', // End of a sentence as in Recommended PHP version is version X.Y or above

    'LBL_MODULE_NAME' => 'Asistente de Actualizacións',
    'LBL_UPLOAD_SUCCESS' => 'Paquete de actualización subido con éxito. Faga clic en Seguinte para realizar unha comprobación final.',
    'LBL_UW_TITLE_LAYOUTS' => 'Confirmar Deseño',
    'LBL_LAYOUT_MODULE_TITLE' => 'Deseño',
    'LBL_LAYOUT_MERGE_DESC' => 'Hai dispoñibles campos novos que se engadiron como parte desta actualización e que poden ser automaticamente engadidos aos seus deseños de módulo actuais. Para saber máis sobre os novos campos, consulte as Notas de Lanzamento desta versión á que se está actualizando. <br /><br />Se non desexa engadir os novos campos, por favor desmarque a casilla do módulo, e os seus deseños personalizados mantenranse sen cambios. Os campos estarán dispoñibles no Estudio trala actualización.',
    'LBL_LAYOUT_MERGE_TITLE' => 'Faga clic en Seguinte para confirmar os cambios e finalizar a actualización.',
    'LBL_LAYOUT_MERGE_TITLE2' => 'Faga clic en Seguinte para completar a actualización.',
    'LBL_UW_CONFIRM_LAYOUTS' => 'Confirmar Deseño',
    'LBL_UW_CONFIRM_LAYOUT_RESULTS' => 'Resultados da Confirmación de Deseño',
    'LBL_UW_CONFIRM_LAYOUT_RESULTS_DESC' => 'Os seguintes deseño combinouse con éxito:',
    'LBL_SELECT_FILE' => 'Seleccionar Arquivo:',
    'ERROR_VERSION_INCOMPATIBLE' => 'O arquivo subido non é compatible con esta versión de SuiteCRM: ',
    'ERROR_PHP_VERSION_INCOMPATIBLE' => 'O arquivo subido non é compatible con esta versión de PHP: ',
    'ERROR_SUITECRM_VERSION_INCOMPATIBLE' => 'O arquivo subido non é compatible con esta versión de SuiteCRM:',
    'LBL_LANGPACKS' => 'Paquetes de Linguaxe' /*for 508 compliance fix*/,
    'LBL_MODULELOADER' => 'Cargador de Módulos' /*for 508 compliance fix*/,
    'LBL_PATCHUPGRADES' => 'Actualizacións de Parche' /*for 508 compliance fix*/,
    'LBL_THEMES' => 'Temas' /*for 508 compliance fix*/,
    'LBL_WORKFLOW' => 'Fluxo de traballo' /*for 508 compliance fix*/,
    'LBL_UPGRADE' => 'Actualización:' /*for 508 compliance fix*/,
    'LBL_PROCESSING' => 'Procesando' /*for 508 compliance fix*/,
    'ERROR_NO_VERSION_SET' => 'Version Compatible non está definido en arquivo de manifesto',
    'LBL_UPGRD_CSTM_CHK' => 'O proceso de Upgrade actualizará algúns arquivos pero esos arquivos tamén existen na carpeta custom. Por favor revise os cambios antes de continuar:',
    'ERR_UW_PHP_FILE_ERRORS' => array(
        1 => 'O arquivo subido excede o límite definido pola directiva upload_max_filesize en php.ini.',
        2 => 'O arquivo subido excede o límite definido pola directiva MAX_FILE_SIZE especificada no formulario HTML.',
        3 => 'O arquivo foi só parcialmente subido.',
        4 => 'Non se subiu ningún arquivo.',
        5 => 'Erro descoñecido.',
        6 => 'Falta unha carpeta temporal.',
        7 => 'Erro ao escribir o arquivo.',
        8 => 'O arquivo subido foi bloqueado pola súa extensión.',
    ),
    'LBL_PASSWORD_EXPIRATON_CHANGED' => 'Advertencia: ¡non se estableceu caducidade da contrasinal!',
    'LBL_PASSWORD_EXPIRATON_REDIRECT' => 'Por favor actualice a súa configuración aquí',
);
