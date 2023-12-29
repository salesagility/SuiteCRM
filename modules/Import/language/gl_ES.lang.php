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
    'LBL_RECORDS_SKIPPED_DUE_TO_ERROR' => 'Rexistros saltados debido a erro',
    'LBL_UPDATE_SUCCESSFULLY' => 'Rexistros actualizados con éxito',
    'LBL_SUCCESSFULLY_IMPORTED' => 'Rexistros creados con éxito',
    'LBL_STEP_4_TITLE' => 'Paso {0}: Importar Arquivo',
    'LBL_STEP_5_TITLE' => 'Paso {0}: Ver Resultados',
    'LBL_CUSTOM_ENCLOSURE' => 'Arquivos Calificados Por:',
    'LBL_ERROR_UNABLE_TO_PUBLISH' => 'Non foi posible realizar a publicación. Xa hai outro mapa de Importación publicado co mesmo nome.',
    'LBL_ERROR_UNABLE_TO_UNPUBLISH' => 'Non foi posible quitar a publicación dun mapa cuxo propietario é outro usuario. Vostede posúe un mapa de Importación co mesmo nome.',
    'LBL_ERROR_IMPORTS_NOT_SET_UP' => 'Non se configurou a Importación para este tipo de módulo',
    'LBL_IMPORT_TYPE' => 'Acción de Importación',
    'LBL_IMPORT_BUTTON' => 'Crear Rexistros',
    'LBL_UPDATE_BUTTON' => 'Crear e Actualizar Rexistros',
    'LBL_CREATE_BUTTON_HELP' => 'Utilice esta opción para crear novos rexistros. Nota: as filas no arquivo de importación contén valores que coinciden con IDs dos rexistros existentes non se importará se os valores se asignan no campo ID.',
    'LBL_UPDATE_BUTTON_HELP' => 'Utilice esta opción para actualizar os rexistros existentes. o dato no arquivo de importación que será comparado cos rexistros existentes sera o ID.',
    'LBL_ERROR_INVALID_BOOL' => 'Valor non válido (debería ser 1 ou 0)',
    'LBL_IMPORT_ERROR' => 'Ocorreron Erros de Importación',
    'LBL_ERROR' => 'Erro:',
    'LBL_FIELD_NAME' => 'Nome do campo',
    'LBL_VALUE' => 'Valor',
    'LBL_NONE' => 'Ningún',
    'LBL_REQUIRED_VALUE' => 'Falta un valor requirido',
    'LBL_ERROR_SYNC_USERS' => 'Valor non válido para sincronizar con Outlook:',
    'LBL_ID_EXISTS_ALREADY' => 'ID xa existente nesta táboa',
    'LBL_ASSIGNED_USER' => 'Se o usuario non existe, utilizar o usuario actual',
    'LBL_ERROR_DELETING_RECORD' => 'Erro eliminando rexistro:',
    'LBL_ERROR_INVALID_ID' => 'O ID proporcionado é demasiado largo para o campo (a lonxitude máxima é de 36 caracteres)',
    'LBL_ERROR_INVALID_PHONE' => 'Número de teléfono non válido',
    'LBL_ERROR_INVALID_NAME' => 'Cadea demasiado larga para o campo',
    'LBL_ERROR_INVALID_VARCHAR' => 'Cadea demasiado larga para o campo',
    'LBL_ERROR_INVALID_DATE' => 'Invalid date string',
    'LBL_ERROR_INVALID_DATETIME' => 'Data e hora non válida',
    'LBL_ERROR_INVALID_DATETIMECOMBO' => 'Data e hora non válida',
    'LBL_ERROR_INVALID_TIME' => 'Hora non válida',
    'LBL_ERROR_INVALID_INT' => 'Valor enteiro non válido',
    'LBL_ERROR_INVALID_NUM' => 'Valor numérico non válido',
    'LBL_ERROR_INVALID_EMAIL' => 'Enderezo de Email non válida',
    'LBL_ERROR_INVALID_USER' => 'Nome ou ID de usuario non válido',
    'LBL_ERROR_INVALID_TEAM' => 'Nome ou ID de equipo non válido',
    'LBL_ERROR_INVALID_ACCOUNT' => 'Nome ou ID de conta non válido',
    'LBL_ERROR_INVALID_RELATE' => 'Campo relacional non válido',
    'LBL_ERROR_INVALID_CURRENCY' => 'Valor de moeda non válido',
    'LBL_ERROR_INVALID_FLOAT' => 'Número en coma flotante non válido',
    'LBL_ERROR_NOT_IN_ENUM' => 'Valor non perteneciente á lista despregable. Os valores permitidos son:',
    'LBL_IMPORT_MODULE_ERROR_NO_UPLOAD' => 'O arquivo non puido subirse con éxito. Pode que a opción &#39;upload_max_filesize&#39; do seu arquivo php.ini estea establecida a un valor demasiado pequeno',
    'LBL_MODULE_NAME' => 'Importar',
    'LBL_TRY_AGAIN' => 'Probe de novo',
    'LBL_IMPORT_ERROR_MAX_REC_LIMIT_REACHED' => 'O arquivo de importación contén {0} filas. o número óptimo de filas é {1}. Máis filas pode retardar o proceso de importación. Faga clic en Aceptar para continuar importando. Faga clic en Cancelar para revisar e volver a cargar o arquivo de importación.',
    'ERR_IMPORT_SYSTEM_ADMININSTRATOR' => 'Non pode importar un usuario administrador do sistema',
    'ERR_MULTIPLE' => 'Definíronse múltiples columnas co mesmo nome de campo.',
    'ERR_MISSING_REQUIRED_FIELDS' => 'Faltan campos requiridos:',
    'ERR_SELECT_FILE' => 'Seleccione o arquivo a subir.',
    'LBL_SELECT_FILE' => 'Seleccione un arquivo:',
    'LBL_EXTERNAL_SOURCE' => 'Unha aplicación ou servizo externo',
    'LBL_CUSTOM_DELIMITER' => 'Delimitador personalizado:',
    'LBL_DONT_MAP' => '-- non asocie este campo --',
    'LBL_STEP_MODULE' => '¿En que módulo se desexa importar os datos?',
    'LBL_STEP_1_TITLE' => 'Paso 1: Seleccione a Orixe de Datos e a Acción de Importación',
    'LBL_CONFIRM_TITLE' => 'Paso {0}: Confirmar as propiedades de importación do arquivo',
    'LBL_MICROSOFT_OUTLOOK' => 'Microsoft Outlook',
    'LBL_MICROSOFT_OUTLOOK_HELP' => 'As asignacións personalizadas para Microsoft Outlook baséanse no arquivo de importación delimitado por comas (.csv). Se o arquivo de importación está delimitado por tabuladores, as asignacións non se aplicará como se esperaba.',
    'LBL_SALESFORCE' => 'Salesforce.com',
    'LBL_PUBLISH' => 'Publicar',
    'LBL_DELETE' => 'Eliminar',
    'LBL_PUBLISHED_SOURCES' => 'Mapeos Publicados:',
    'LBL_UNPUBLISH' => 'Quitar Publicación',
    'LBL_NEXT' => 'Seguinte >',
    'LBL_BACK' => '< Anterior',
    'LBL_STEP_2_TITLE' => 'Paso {0}: Subida de Arquivo de Importación',
    'LBL_HAS_HEADER' => 'Ten cabeceira:',
    'LBL_NUM_1' => '1.',
    'LBL_NUM_2' => '2.',
    'LBL_NUM_3' => '3.',
    'LBL_NUM_4' => '4.',
    'LBL_NUM_5' => '5.',
    'LBL_NUM_6' => '6.',
    'LBL_NUM_7' => '7.',
    'LBL_NUM_8' => '8.',
    'LBL_NUM_9' => '9.',
    'LBL_NUM_10' => '10.',
    'LBL_NUM_11' => '11.',
    'LBL_NUM_12' => '12.',
    'LBL_NOTES' => 'Notas:',
    'LBL_STEP_3_TITLE' => 'Paso {0}: Confirme os Campos e Importe',
    'LBL_STEP_DUP_TITLE' => 'Paso {0}: Comprobe se hai posibles duplicados',
    'LBL_DATABASE_FIELD' => 'Campo de Base de Datos',
    'LBL_HEADER_ROW' => 'Fila de Cabeceira',
    'LBL_HEADER_ROW_OPTION_HELP' => 'Seleccione se a primeira fila do arquivo de importación é unha fila de encabezado que contén as etiquetas de campo.',
    'LBL_ROW' => 'Fila',
    'LBL_CONTACTS_NOTE_1' => 'Debe asociar ou Apelido ou Nome Completo.',
    'LBL_CONTACTS_NOTE_2' => 'Se asocia Nome Completo, Nome e Apelido serán ignorados.',
    'LBL_CONTACTS_NOTE_3' => 'Se asocia Nome Completo, os datos en Nome Completo dividiranse en Nome e Apelido cando se inserten na base de datos.',
    'LBL_CONTACTS_NOTE_4' => 'Os campos que conteñen Rúa Enderezo 2 e Rúa Enderezo 3 concatenaranse no campo Enderezo Principal cando se inserten na base de datos.',
    'LBL_ACCOUNTS_NOTE_1' => 'Os campos que conteñen Rúa Enderezo 2 e Rúa Enderezo 3 concatenaranse no campo Enderezo Principal cando se inserten na base de datos.',
    'LBL_IMPORT_NOW' => 'Importar Agora',
    'LBL_' => '',
    'LBL_CANNOT_OPEN' => 'Non pode abrirse o arquivo de importación para lectura',
    'LBL_NO_LINES' => 'Non hai liñas no seu arquivo de importación',
    'LBL_SUCCESS' => 'Éxito:',
    'LBL_LAST_IMPORT_UNDONE' => 'A súa última importación foi desfeita.',
    'LBL_NO_IMPORT_TO_UNDO' => 'Non hai importación que desfacer.',
    'LBL_CREATED_TAB' => 'Rexistros creados',
    'LBL_DUPLICATE_TAB' => 'Duplicados',
    'LBL_ERROR_TAB' => 'Erros',
    'LBL_IMPORT_MORE' => 'Importar Máis',
    'LBL_FINISHED' => 'Volver a',
    'LBL_UNDO_LAST_IMPORT' => 'Desfacer Última Importación',
    'LBL_DUPLICATES' => 'Encontráronse Duplicados',
    'LNK_DUPLICATE_LIST' => 'Descargar Lista de Duplicados',
    'LNK_ERROR_LIST' => 'Descargar Lista de Erros',
    'LNK_RECORDS_SKIPPED_DUE_TO_ERROR' => 'Descargar rexistros que non puideron ser importados.',
    'LBL_INDEX_USED' => 'Índices usados:',
    'LBL_INDEX_NOT_USED' => 'Índices non usados:',
    'LBL_IMPORT_FIELDDEF_ID' => 'Número de ID único',
    'LBL_IMPORT_FIELDDEF_RELATE' => 'Nome ou ID',
    'LBL_IMPORT_FIELDDEF_PHONE' => 'Número de Teléfono',
    'LBL_IMPORT_FIELDDEF_TEAM_LIST' => 'ID ou Nome de Equipo',
    'LBL_IMPORT_FIELDDEF_NAME' => 'Calquera Texto',
    'LBL_IMPORT_FIELDDEF_VARCHAR' => 'Calquera Texto',
    'LBL_IMPORT_FIELDDEF_TEXT' => 'Calquera Texto',
    'LBL_IMPORT_FIELDDEF_TIME' => 'Hora',
    'LBL_IMPORT_FIELDDEF_DATE' => 'Data',
    'LBL_IMPORT_FIELDDEF_ASSIGNED_USER_NAME' => 'Nome de Usuario ou ID',
    'LBL_IMPORT_FIELDDEF_BOOL' => '&#39;0&#39; ou &#39;1&#39;',
    'LBL_IMPORT_FIELDDEF_ENUM' => 'Lista',
    'LBL_IMPORT_FIELDDEF_EMAIL' => 'Enderezo de EMail',
    'LBL_IMPORT_FIELDDEF_INT' => 'Numérico (Sen Decimais)',
    'LBL_IMPORT_FIELDDEF_DOUBLE' => 'Numérico (Sen Decimais)',
    'LBL_IMPORT_FIELDDEF_NUM' => 'Numérico (Sen Decimais)',
    'LBL_IMPORT_FIELDDEF_CURRENCY' => 'Numérico (Decimais Permitidos)',
    'LBL_IMPORT_FIELDDEF_FLOAT' => 'Numérico (Decimais Permitidos)',
    'LBL_DATE_FORMAT' => 'Formato de Data:',
    'LBL_TIME_FORMAT' => 'Formato de Hora:',
    'LBL_TIMEZONE' => 'Zona Horaria:',
    'LBL_ADD_ROW' => 'Agregar Campo',
    'LBL_REMOVE_ROW' => 'Quitar Campo',
    'LBL_DEFAULT_VALUE' => 'Valor por Defecto',
    'LBL_SHOW_ADVANCED_OPTIONS' => 'Mostrar Opcións Avanzadas',
    'LBL_HIDE_ADVANCED_OPTIONS' => 'Ocultar Opcións Avanzadas',
    'LBL_SHOW_NOTES' => 'Ver notas',
    'LBL_HIDE_NOTES' => 'Ocultar notas',
    'LBL_SAVE_MAPPING_AS' => 'Gardar Mapeo Como',
    'LBL_IMPORT_COMPLETE' => 'Importación Completada',
    'LBL_IMPORT_COMPLETED' => 'Importación completada',
    'LBL_IMPORT_RECORDS' => 'Importando Rexistros',
    'LBL_IMPORT_RECORDS_OF' => 'de',
    'LBL_IMPORT_RECORDS_TO' => 'a',
    'LBL_CURRENCY' => 'Moeda',
    'LBL_CURRENCY_SIG_DIGITS' => 'Díxitos Significativos da Moeda',
    'LBL_NUMBER_GROUPING_SEP' => 'Separador de miles',
    'LBL_DECIMAL_SEP' => 'Símbolo Decimal',
    'LBL_LOCALE_DEFAULT_NAME_FORMAT' => 'Formato de Visualización de Nome',
    'LBL_LOCALE_EXAMPLE_NAME_FORMAT' => 'Exemplo',
    'LBL_LOCALE_NAME_FORMAT_DESC' => '<i>"s" Saúdo, "f" Nome, "l" Apelido</i>',
    'LBL_CHARSET' => 'Codificación de Arquivo',
    'LBL_MY_SAVED_HELP' => 'Un mapeo gardado permite especificar unha combinación utilizada anteriormente dunha orixe de datos específica e un conxunto de campos de base de datos para mapear os campos do arquivo de importación.<br>Faga clic en <b>Publicar</b> para deixar dispoñible o mapeo a outros usuarios.<br>Faga clic en <b>Quitar Publicación</b> para que o mapeo deixe de estar dispoñible para outros usuarios.',
    'LBL_MY_SAVED_ADMIN_HELP' => 'Utilice esta opción para aplicar os axustes predefinidos de importación, incluíndo as propiedades de importación, as asignacións, e a configuración de control de duplicado, á importación. <br> Faga clic en <b> Publicar </ b> para facer dispoñible ao resto de usuarios a plantilla. <br> Faga clic en <b> Un-Publicar </ b> para desactivar a plantilla a outros usuarios. <br> Faga clic en <b> Eliminar </ b> para eliminar a plantilla para todos os usuarios.',
    'LBL_ENCLOSURE_HELP' => '<p>O <b>carácter calificador</b> utilízase para encerrar o contido dun campo, incluíndo calquera carácter que se utilicen como delimitadores.<br><br>Exemplo: Se o carácter delimitador é unha coma (,) e o calificador é unha comilla doble ("),<br><b>"Cupertino, California"</b> importarase nun só campo da aplicación e aparecerá como <b>Cupertino, California</b>.<br>Se non se establece ningún carácter calificador, ou éste é un carácter distinto,<br><b>"Cupertino, California"</b> será importado en dous campos adxacentes como <b>"Cupertino</b> e <b>California"</b>.<br><br>Nota: o arquivo de importación pode non conter caracteres calificadores.<br>O carácter calificador por defecto para arquivos delimitados por coma ou tabulador creados en Excel é a comilla doble.</p>',
    'LBL_DATABASE_FIELD_HELP' => 'Seleccione un campo da lista de todos os campos existentes na base de datos para o módulo.',
    'LBL_HEADER_ROW_HELP' => 'Estos son os campos de título da fila correspondente á cabeceira do arquivo de importación.',
    'LBL_DEFAULT_VALUE_HELP' => 'Indique un valor a usar para o campo no rexistro creado ou actualizado se o campo no arquivo de importación non contén datos.',
    'LBL_ROW_HELP' => 'Estos son os datos da primeira fila do arquivo de importación que non pertence á cabeceira.',
    'LBL_SAVE_MAPPING_HELP' => 'Introduza un nome para o conxunto de campos de base de datos utilizados arriba para que sexan mapeados aos campos do arquivo de importación.<br>O conxunto de campos, incluíndo a súa orde e a orixe de datos seleccionado no Paso 1 de Importación, serán gardados durante o intento de importación.<br>O mapeo gardado poderá entón ser seleccionado no Paso 1 de Importación para unha nova importación.',
    'LBL_IMPORT_FILE_SETTINGS_HELP' => 'Especifique a configuración do arquivo de importación para asegurarse de que os datos son importados <br> correctamente.  Esta configuración non reemplazará as súas preferencias. Os rexistros<br> creados ou actualizados conterán a configuración especificada na páxina A Miña Conta.',
    'LBL_IMPORT_STARTED' => 'Importación Iniciada:',
    'LBL_RECORD_CANNOT_BE_UPDATED' => 'O rexistro non puido ser actualizado debido a un problema de permisos',
    'LBL_DELETE_MAP_CONFIRMATION' => '¿Está seguro que desexa eliminar este conxunto gardado da configuración de importación?',
    'LBL_THIRD_PARTY_CSV_SOURCES' => 'Se os datos de importación de arquivos se exporta desde unha das seguintes fontes, seleccionar cal delas.',
    'LBL_THIRD_PARTY_CSV_SOURCES_HELP' => 'Seleccione a fonte para aplicar automaticamente as asignacións personalizadas co fin de simplificar o proceso de asignación (paso seguinte).',
    'LBL_EXAMPLE_FILE' => 'Descargar plantilla de importación de arquivos',
    'LBL_CONFIRM_IMPORT' => 'Vostede seleccionou para actualizar os rexistros durante o proceso de importación. As actualizacións realizadas nos rexistros existentes non se poden desfacer. Porén, os rexistros creados durante o proceso de importación pódense desfacer (eliminando), se o desexa. Faga clic en Cancelar para seleccionar crear novos rexistros só, ou faga clic en OK para continuar.',
    'LBL_CONFIRM_MAP_OVERRIDE' => 'Advertencia: Vostede xa seleccionou unha asignación personalizada para esta importación, ¿quere que continúe?',
    'LBL_SAMPLE_URL_HELP' => 'Descargue o exemplo de arquivo de importación o cal contén unha fila de cabeceira cos campos do módulo. O arquivo pode ser utilizado como unha plantilla para crear o arquivo de importación que contén os datos que desexa importar.',
    'LBL_AUTO_DETECT_ERROR' => 'O delimitador de campo e de clasificación no arquivo de importación non podía ser detectado. Por favor, verifique a configuración das propiedades do arquivo de importación.',
    'LBL_MIME_TYPE_ERROR_1' => 'O arquivo seleccionado non parece conter unha lista delimitada. Por favor, comprobe o tipo de arquivo. Recomendamos arquivos delimitados por comas (.csv).',
    'LBL_MIME_TYPE_ERROR_2' => 'Para proceder coa importación do arquivo seleccionado, faga clic en Aceptar. Para cargar un novo arquivo, faga clic en volver a cargar.',
    'LBL_FIELD_DELIMETED_HELP' => 'O delimitador de campo especifica o carácter utilizado para separar as columnas de campos.',
    'LBL_FILE_UPLOAD_WIDGET_HELP' => 'Seleccione un arquivo que conteña datos separados por un delimitador, xa sexa por comas ou por tabulacións. Recoméndase arquivos .csv.',
    'LBL_ERROR_IMPORT_CACHE_NOT_WRITABLE' => 'O directorio caché de importaciones non ten permisos de escritura',
    'LBL_ADD_FIELD_HELP' => 'Utilice esta opción para agregar un valor a un campo en todos os rexistros creados e/ou actualizados. Seleccione o campo e logo escriba ou seleccione un valor para ese campo na columna valor predeterminado.',
    'LBL_MISSING_HEADER_ROW' => 'Non se encontrou cabeceira',
    'LBL_CANCEL' => 'Cancelar',
    'LBL_SELECT_DS_INSTRUCTION' => '¿Listo para empezar a importar? Seleccione a orixe de datos que desexa importar.',
    'LBL_SELECT_UPLOAD_INSTRUCTION' => 'Seleccione un arquivo do seu ordenador que conteña os datos que desexa importar, ou descargue a plantilla para dispoñer dun exemplo para a creación do arquivo de importación.',
    'LBL_SELECT_PROPERTY_INSTRUCTION' => 'Así é como as primeras filas dos arquivos de importación aparecen coas propiedades detectadas. Se se detectou a fila de cabeceira, móstrase na fila superior da táboa. Ver as propiedades do arquivo de importación para realizar cambios nas propiedades detectadas e para configurar propiedades adicionais. Ao actualizar os valores actualizaranse os datos que aparecen na táboa.',
    'LBL_SELECT_MAPPING_INSTRUCTION' => 'A seguinte táboa contén todos os campos do módulo que se pode relacionar aos datos no arquivo de importación. Se o arquivo contén unha fila de cabeceira, as columnas no arquivo foron asignadas aos campos de importación. Comprobe as asignacións para asegurarse de que son o que vostede espera, e facer os cambios, segundo sexa necesario. Para axudarte a comprobar as asignacións, a fila 1 mostra os datos no arquivo. Asegúrese de asignar todos os campos obrigatorios (sinalados cun asterisco).',
    'LBL_SELECT_DUPLICATE_INSTRUCTION' => 'Para evitar a creación de rexistros duplicados, seleccionar cal dos campos asignados que lle gustaría utilizar para realizar unha comprobación de duplicados mentres os datos se están importando. Os valores dentro dos rexistros existentes nos campos seleccionados cotexarase cos datos no arquivo de importación. Se nos datos se encontra coincidencia, as filas no arquivo de importación mostraranse xunto cos resultados de importación (páxina seguinte). A continuación poderá seleccionar cal destas filas para seguir importando.',
    'LBL_DUP_HELP' => 'Aquí están as filas do arquivo de importación que non foron importados, xa que conteñen datos que coinciden cos valores dos rexistros existentes sobre a base da comprobación de duplicados. Os datos que se poñen de relevo son os implicados. Para volver a importar estas filas, descargar a lista, realice os cambios e faga clic en <b> Importar de novo </ b>.',
    'LBL_SUMMARY' => 'Resumo',
    'LBL_OK' => 'Aceptar',
    'LBL_ERROR_HELP' => 'Aquí están as filas do arquivo de importación que non foron importados debido aos erros. Para volver a importar estas filas, descargar a lista, realice os cambios e faga clic en <b> Importar de novo </ b>.',
    'LBL_EXTERNAL_ASSIGNED_TOOLTIP' => 'Para asignar os novos rexistros a un usuario que non sexa vostede mesmo, utilice a columna Valor predeterminado para seleccionar un usuario diferente.',
    'LBL_EXTERNAL_TEAM_TOOLTIP' => 'Para asignar os novos rexistros a outros equipo(s) por defecto, utilice a columna Valor predeterminado para seleccionar os diferentes equipos.',
    // STIC-Custom 20221103 MHP - STIC#904
    'LBL_ERROR_CYCLIC_DEPENDENCY' => ' non pode informar ',
    // END STIC-Custom
);

global $timedate;
