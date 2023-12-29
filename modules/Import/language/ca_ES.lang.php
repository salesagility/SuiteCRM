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
    'LBL_RECORDS_SKIPPED_DUE_TO_ERROR' => 'Registres omesos a causa d\'error',
    'LBL_UPDATE_SUCCESSFULLY' => 'Registres actualitzats correctament',
    'LBL_SUCCESSFULLY_IMPORTED' => 'Registres creats correctament',
    'LBL_STEP_4_TITLE' => 'Pas 4: Importa el fitxer',
    'LBL_STEP_5_TITLE' => 'Pas 5: Resultats',
    'LBL_CUSTOM_ENCLOSURE' => 'Arxius classificats per:',
    'LBL_ERROR_UNABLE_TO_PUBLISH' => "No s'ha pogut desar el mapa perquè ja n'hi ha un altre amb el mateix nom.",
    'LBL_ERROR_UNABLE_TO_UNPUBLISH' => "No s'ha pogut esborrar el mapa perquè el propietari és un altre usuari. En teniu un amb el mateix nom.",
    'LBL_ERROR_IMPORTS_NOT_SET_UP' => 'Aquest mòdul no té habilitada la importació.',
    'LBL_IMPORT_TYPE' => "Acció d'importació",
    'LBL_IMPORT_BUTTON' => 'Crea registres',
    'LBL_UPDATE_BUTTON' => 'Crea i actualitza registres',
    'LBL_CREATE_BUTTON_HELP' => "Utilitzeu aquesta opció per crear nous registres. Les files del fitxer que continguin valors que coincideixin amb els ID dels registres existents no s'importaran si els valors s'assignen al camp ID.",
    'LBL_UPDATE_BUTTON_HELP' => 'Utilitzeu aquesta opció per actualitzar els registres existents. Us caldrà relacionar la columna adequada del fitxer amb el camp ID del CRM.',
    'LBL_ERROR_INVALID_BOOL' => 'El valor booleà no és vàlid',
    'LBL_IMPORT_ERROR' => "Errors d\'importació:", // STIC 2020/08/27 - Escaping exception. Do not touch. 
    'LBL_ERROR' => 'Error',
    'LBL_FIELD_NAME' => 'Nom del camp',
    'LBL_VALUE' => 'Valor',
    'LBL_NONE' => 'Cap',
    'LBL_REQUIRED_VALUE' => 'Falta un valor obligatori',
    'LBL_ERROR_SYNC_USERS' => 'Valor no vàlid per sincronitzar amb Outlook:',
    'LBL_ID_EXISTS_ALREADY' => "L'ID ja existeix en aquesta taula",
    'LBL_ASSIGNED_USER' => "Si l'usuari no existeix, feu servir l'usuari actual",
    'LBL_ERROR_DELETING_RECORD' => "Error a l'eliminar el registre:",
    'LBL_ERROR_INVALID_ID' => "L'ID indicat és massa llarg; la longitud màxima és de 36 caràcters.",
    'LBL_ERROR_INVALID_PHONE' => 'El telèfon no és vàlid',
    'LBL_ERROR_INVALID_NAME' => 'La cadena és massa llarga',
    'LBL_ERROR_INVALID_VARCHAR' => 'La cadena és massa llarga',
    'LBL_ERROR_INVALID_DATE' => 'La data no és vàlida',
    'LBL_ERROR_INVALID_DATETIME' => "La data i l'hora no són vàlides",
    'LBL_ERROR_INVALID_DATETIMECOMBO' => "La data i l'hora no són vàlides",
    'LBL_ERROR_INVALID_TIME' => "L'hora no és vàlida",
    'LBL_ERROR_INVALID_INT' => 'El valor enter no és vàlid',
    'LBL_ERROR_INVALID_NUM' => 'El valor numèric no és vàlid',
    'LBL_ERROR_INVALID_EMAIL' => "L'adreça de correu electrònic no és vàlida",
    'LBL_ERROR_INVALID_USER' => "El nom o l'ID de l'usuari no és vàlid",
    'LBL_ERROR_INVALID_TEAM' => "El nom o l'ID de l'equip no és vàlid",
    'LBL_ERROR_INVALID_ACCOUNT' => "El nom o l'ID del compte no és vàlid",
    'LBL_ERROR_INVALID_RELATE' => 'El camp relacionat no és vàlid',
    'LBL_ERROR_INVALID_CURRENCY' => 'El valor de moneda no és vàlid',
    'LBL_ERROR_INVALID_FLOAT' => 'El valor de coma flotant no vàlid',
    'LBL_ERROR_NOT_IN_ENUM' => 'El valor no pertany a la llista desplegable. Els valors permesos són: ',
    'LBL_IMPORT_MODULE_ERROR_NO_UPLOAD' => "El fitxer no s'ha pogut pujar. Pot ser que l'opció 'upload_max_filesize' del php.ini estigui establerta a un valor massa petit.",
    'LBL_MODULE_NAME' => 'Importa',
    'LBL_TRY_AGAIN' => 'Torna a provar-ho',
    'LBL_IMPORT_ERROR_MAX_REC_LIMIT_REACHED' => 'El fitxer conté {0} files. El nombre òptim de files és {1}. Un nombre superior pot alentir el procés. Feu clic a Accepta per continuar important. Feu clic a Cancel·la per revisar i tornar a carregar el fitxer.',
    'ERR_IMPORT_SYSTEM_ADMININSTRATOR' => 'No podeu importar un usuari administrador del sistema',
    'ERR_MULTIPLE' => 'Hi ha diverses columnes amb el mateix nom de camp.',
    'ERR_MISSING_REQUIRED_FIELDS' => 'Falten camps obligatoris:',
    'ERR_SELECT_FILE' => 'Seleccioneu el fitxer.',
    'LBL_SELECT_FILE' => 'Seleccioneu el fitxer:',
    'LBL_EXTERNAL_SOURCE' => 'una aplicació o servei extern',
    'LBL_CUSTOM_DELIMITER' => 'Delimitador personalitzat:',
    'LBL_DONT_MAP' => '-- No associïs aquest camp --',
    'LBL_STEP_MODULE' => 'A quin mòdul voleu importar les dades?',
    'LBL_STEP_1_TITLE' => "Pas 1: Seleccioneu l'origen i l'acció d'importació",
    'LBL_CONFIRM_TITLE' => "Pas {0}: Confirmeu les propietats d'importació del fitxer",
    'LBL_MICROSOFT_OUTLOOK' => 'Microsoft Outlook',
    'LBL_MICROSOFT_OUTLOOK_HELP' => "Les assignacions personalitzades per a Microsoft Outlook es basen en un fitxer delimitat per comes (.csv). Si el fitxer està delimitat per tabuladors, les assignacions no s'aplicaran com seria d'esperar.",
    'LBL_SALESFORCE' => 'Salesforce.com',
    'LBL_PUBLISH' => 'Publica',
    'LBL_DELETE' => 'Elimina',
    'LBL_PUBLISHED_SOURCES' => 'Mapes publicats:',
    'LBL_UNPUBLISH' => 'Despublica',
    'LBL_NEXT' => 'Següent >',
    'LBL_BACK' => '< Anterior',
    'LBL_STEP_2_TITLE' => "Pas {0}: Pugeu el fitxer d'importació",
    'LBL_HAS_HEADER' => 'Té capçalera:',
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
    'LBL_NOTES' => 'Notes:',
    'LBL_STEP_3_TITLE' => 'Pas 3: Confirmeu els camps i importeu',
    'LBL_STEP_DUP_TITLE' => 'Pas {0}: Comprova si hi ha possibles duplicats',
    'LBL_DATABASE_FIELD' => 'Camp de base de dades',
    'LBL_HEADER_ROW' => 'Fila de capçalera',
    'LBL_HEADER_ROW_OPTION_HELP' => 'Indiqueu si la primera fila del fitxer és una capçalera que conté els noms dels camps.',
    'LBL_ROW' => 'Fila',
    'LBL_CONTACTS_NOTE_1' => "Heu d'associar el Cognom o el Nom Complet.",
    'LBL_CONTACTS_NOTE_2' => 'Si associeu el camp Nom Complet, els camps Nom i Cognom seran ignorats.',
    'LBL_CONTACTS_NOTE_3' => "Si associeu el camp Nom Complet, el valor d'aquest camp es repartirà entre els camps Nom i Cognoms.",
    'LBL_CONTACTS_NOTE_4' => 'Els camps que contenen Carrer 2 i Carrer 3 es concatenaran amb el camp Adreça Principal quan es desin a la base de dades.',
    'LBL_ACCOUNTS_NOTE_1' => 'Els camps que contenen Carrer 2 i Carrer 3 es concatenaran amb el camp Adreça Principal quan es desin a la base de dades.',
    'LBL_IMPORT_NOW' => 'Importa ara',
    'LBL_' => '',
    'LBL_CANNOT_OPEN' => "No s'ha pogut obrir el fitxer.",
    'LBL_NO_LINES' => 'El fitxer no té registres.',
    'LBL_SUCCESS' => 'Èxit:',
    'LBL_LAST_IMPORT_UNDONE' => "S'ha desfet la darrera importació.",
    'LBL_NO_IMPORT_TO_UNDO' => 'No hi ha cap importació per desfer.',
    'LBL_CREATED_TAB' => 'Registres creats',
    'LBL_DUPLICATE_TAB' => 'Duplicats',
    'LBL_ERROR_TAB' => 'Errors',
    'LBL_IMPORT_MORE' => 'Fes una altra importació',
    'LBL_FINISHED' => 'Finalitzat',
    'LBL_UNDO_LAST_IMPORT' => 'Desfés la darrera importació',
    'LBL_DUPLICATES' => 'S\'han trobat duplicats',
    'LNK_DUPLICATE_LIST' => 'Descarrega la llista de duplicats',
    'LNK_ERROR_LIST' => "Descarrega la llista d'errors",
    'LNK_RECORDS_SKIPPED_DUE_TO_ERROR' => "Descarrega els registres que no s'han pogut importar.",
    'LBL_INDEX_USED' => 'Índexs utilitzats',
    'LBL_INDEX_NOT_USED' => 'Índexs no utilitzats',
    'LBL_IMPORT_FIELDDEF_ID' => 'ID',
    'LBL_IMPORT_FIELDDEF_RELATE' => 'Nom o ID',
    'LBL_IMPORT_FIELDDEF_PHONE' => 'Telèfon',
    'LBL_IMPORT_FIELDDEF_TEAM_LIST' => "ID o Nom d'equip",
    'LBL_IMPORT_FIELDDEF_NAME' => 'Qualsevol text',
    'LBL_IMPORT_FIELDDEF_VARCHAR' => 'Qualsevol text',
    'LBL_IMPORT_FIELDDEF_TEXT' => 'Qualsevol text',
    'LBL_IMPORT_FIELDDEF_TIME' => 'Hora',
    'LBL_IMPORT_FIELDDEF_DATE' => 'Data',
    'LBL_IMPORT_FIELDDEF_ASSIGNED_USER_NAME' => "Nom d'Usuari o ID",
    'LBL_IMPORT_FIELDDEF_BOOL' => '\'0\' o \'1\'',
    'LBL_IMPORT_FIELDDEF_ENUM' => 'Llista',
    'LBL_IMPORT_FIELDDEF_EMAIL' => 'Adreça de correu electrònic',
    'LBL_IMPORT_FIELDDEF_INT' => 'Numèric (sense decimals)',
    'LBL_IMPORT_FIELDDEF_DOUBLE' => 'Numèric (sense decimals)',
    'LBL_IMPORT_FIELDDEF_NUM' => 'Numèric (sense decimals)',
    'LBL_IMPORT_FIELDDEF_CURRENCY' => 'Numèric (amb decimals)',
    'LBL_IMPORT_FIELDDEF_FLOAT' => 'Numèric (amb decimals)',
    'LBL_DATE_FORMAT' => 'Format de data:',
    'LBL_TIME_FORMAT' => "Format d'hora:",
    'LBL_TIMEZONE' => 'Zona horària:',
    'LBL_ADD_ROW' => 'Afegeix un camp',
    'LBL_REMOVE_ROW' => 'Treu el camp',
    'LBL_DEFAULT_VALUE' => 'Valor per defecte',
    'LBL_SHOW_ADVANCED_OPTIONS' => 'Mostra les opcions avançades',
    'LBL_HIDE_ADVANCED_OPTIONS' => 'Amaga les opcions avançades',
    'LBL_SHOW_NOTES' => 'Notes',
    'LBL_HIDE_NOTES' => 'Amaga les notes',
    'LBL_SAVE_MAPPING_AS' => "Indiqueu un nom pel mapa d'importació:",
    'LBL_IMPORT_COMPLETE' => 'Importació completada',
    'LBL_IMPORT_COMPLETED' => 'Importació completada',
    'LBL_IMPORT_RECORDS' => 'Important els registres',
    'LBL_IMPORT_RECORDS_OF' => 'de',
    'LBL_IMPORT_RECORDS_TO' => 'a',
    'LBL_CURRENCY' => 'Moneda',
    'LBL_CURRENCY_SIG_DIGITS' => 'Dígits significatius de la moneda',
    'LBL_NUMBER_GROUPING_SEP' => 'Separador de milers',
    'LBL_DECIMAL_SEP' => 'Separador de decimals',
    'LBL_LOCALE_DEFAULT_NAME_FORMAT' => 'Nom del format de visualització',
    'LBL_LOCALE_EXAMPLE_NAME_FORMAT' => 'Exemple',
    'LBL_LOCALE_NAME_FORMAT_DESC' => '<i>"s" Salutació, "f" Nom, "l" Cognom</i>',
    'LBL_CHARSET' => 'Codificació del fitxer',
    'LBL_MY_SAVED_HELP' => "Utilitzeu aquesta opció per aplicar a aquesta importació una configuració desada prèviament, incloses les propietats d'importació, el mapatge de camps i la detecció de duplicats.<br>Feu clic a <b>Elimina</b> per esborrar la configuració completament.",
    'LBL_MY_SAVED_ADMIN_HELP' => "Utilitzeu aquesta opció per aplicar a aquesta importació una configuració desada prèviament, incloses les propietats d'importació, el mapatge de camps i la detecció de duplicats.<br>Feu clic a <b>Publica</b> per posar la configuració a disposició d'altres usuaris, a <b>Despublica</b> per no facilitar-los-la i a <b>Elimina</b> per esborrar-la completament.",
    'LBL_ENCLOSURE_HELP' => '<p>El caràcter qualificador s\'utilitza per marcar el principi i el final del contingut d\'un camp, que pot incloure el caràcter utilitzat com a delimitador.<br><br>Exemple: Si el caràcter delimitador és la coma (,) i el qualificador és les cometes ("),<br><b>"Cupertino, Califòrnia"</b> s\'importarà en un sol camp que tindrà per valor <b>Cupertino, Califòrnia</b>.<br>Si no hi ha caràcter qualificador o és un caràcter diferent,<br><b>"Cupertino, California"</b > s\'importarà en dos camps consecutius com <b>"Cupertino</b> i <b>Califòrnia"</b>.<br><br>Nota: El fitxer d\'importació pot ser que no contingui caràcters qualificadors.<br>El caràcter qualificador per defecte per a arxius separats per comes o tabuladors a Excel és les cometes.</p>',
    'LBL_DATABASE_FIELD_HELP' => 'Aquesta columna mostra tots els camps del mòdul. Seleccioneu quins camps han de rebre les dades de cada columna del fitxer.',
    'LBL_HEADER_ROW_HELP' => 'Aquests són els noms dels camps que apareixen a la fila de capçalera del fitxer.',
    'LBL_DEFAULT_VALUE_HELP' => "Indiqueu el valor que s'hagi d'aplicar als registres importats quan la fila del fitxer tingui el camp en blanc.",
    'LBL_ROW_HELP' => 'Aquestes són les dades de la primera fila del fitxer sense comptar la capçalera.',
    'LBL_SAVE_MAPPING_HELP' => "Introduïu un nom per a la configuració d'importació, incloent-hi el mapatge de camps i la detecció de duplicats. La configuració desada podrà ser aplicada en futures importacions.",
    'LBL_IMPORT_FILE_SETTINGS_HELP' => "Durant la càrrega del fitxer algunes de les seves propietats s'han detectat automàticament. Reviseu i modifiqueu aquestes propietats, si cal. Nota: aquesta configuració correspon només a aquesta importació i no anul·larà la configuració general d'usuari.",
    'LBL_IMPORT_STARTED' => 'Importació iniciada:',
    'LBL_RECORD_CANNOT_BE_UPDATED' => "El registre no s'ha pogut actualitzar per un problema de permisos.",
    'LBL_DELETE_MAP_CONFIRMATION' => "Segur que voleu eliminar aquest mapatge d'importació?",
    'LBL_THIRD_PARTY_CSV_SOURCES' => 'Si el fitxer ha estat exportat des de qualsevol dels següents orígens, indiqueu de quin.',
    'LBL_THIRD_PARTY_CSV_SOURCES_HELP' => "Seleccioneu l'origen de les dades per aplicar un mapatge automàtic i així simplificar el procés de mapatge manual del següent pas.",
    'LBL_EXAMPLE_FILE' => "Descarrega la plantilla d'importació de fitxers",
    'LBL_CONFIRM_IMPORT' => "Heu seleccionat l'opció d'actualitzar els registres durant el procés d'importació. Les actualitzacions realitzades als registres existents no es podran desfer. En canvi, els registres creats sí que es poden eliminar, si cal. Feu clic a 'Cancel·la' per canviar l'opció seleccionada o a 'D'acord' per continuar.",
    'LBL_CONFIRM_MAP_OVERRIDE' => 'Atenció! Ja heu seleccionat un mapatge personalitzat per a aquesta importació. Voleu continuar?',
    'LBL_SAMPLE_URL_HELP' => "Podeu descarregar un fitxer d'exemple que conté una fila de capçalera amb els camps del mòdul i que podeu utilitzar com a plantilla per crear el fitxer d'importació.",
    'LBL_AUTO_DETECT_ERROR' => "Els caràcters de delimitació dels camps no s'han pogut detectar. Verifiqueu la configuració de les propietats del fitxer.",
    'LBL_MIME_TYPE_ERROR_1' => 'El fitxer seleccionat no sembla que contingui una llista delimitada. Comproveu que el fitxer és de tipus delimitat per comes (.csv).',
    'LBL_MIME_TYPE_ERROR_2' => 'Per importar el fitxer seleccionat, feu clic a "Accepta". Per carregar un altre fitxer, feu clic a "Torna a carregar".',
    'LBL_FIELD_DELIMETED_HELP' => 'El delimitador de camp especifica el caràcter utilitzat per separar les columnes al fitxer.',
    'LBL_FILE_UPLOAD_WIDGET_HELP' => 'Seleccioneu un fitxer que contingui dades separades per un delimitador (coma, tabulador...). Es recomana fer servir fitxers .csv.',
    'LBL_ERROR_IMPORT_CACHE_NOT_WRITABLE' => "El directori cau d'importació no té permisos d'escriptura.",
    'LBL_ADD_FIELD_HELP' => 'Utilitzeu aquesta opció per afegir un valor a un camp de tots els registres creats i/o actualitzats. Seleccioneu el camp i després escriviu o seleccioneu un valor per aquest camp a la columna "Valor per defecte".',
    'LBL_MISSING_HEADER_ROW' => "No s'ha trobat la capçalera.",
    'LBL_CANCEL' => 'Cancel·la',
    'LBL_SELECT_DS_INSTRUCTION' => "Preparat per començar a importar? Seleccioneu l'origen de les dades que voleu importar.",
    'LBL_SELECT_UPLOAD_INSTRUCTION' => "Seleccioneu el fitxer que conté les dades a importar o descarregueu la plantilla d'exemple per crear el fitxer d'importació.",
    'LBL_SELECT_PROPERTY_INSTRUCTION' => "Així és com es veuen les primeres files del fitxer d'importació d'acord amb les propietats detectades. Si s'ha detectat una fila de capçalera, es mostra a la part superior de la taula. Mireu les propietats del fitxer i configureu-les adequadament. L'actualització de la configuració modificarà la previsualització de les dades de la taula.",
    'LBL_SELECT_MAPPING_INSTRUCTION' => 'La següent taula conté tots els camps del mòdul que es poden assignar a les dades del fitxer. Si el fitxer conté una fila de capçalera, les columnes del fitxer ja han estat assignades als camps del CRM. Comproveu les assignacions i feu-hi els canvis necessaris. Per ajudar-vos a comprovar les assignacions es mostren les dades de la fila 1 del fitxer. Assegureu-vos que tots els camps obligatoris (assenyalats amb un asterisc) estan assignats.',
    'LBL_SELECT_DUPLICATE_INSTRUCTION' => 'Seleccioneu quins dels següents camps voleu utilitzar per realitzar una comprovació que eviti la creació de registres duplicats. Les dades del fitxer es confrontaran amb els valors dels camps seleccionats en els registres existents. Les files del fitxer que continguin registres possiblement ja existents es mostraran juntament amb els resultats de la importació a la pàgina següent, on podreu decidir quines files voleu tornar a importar.',
    'LBL_DUP_HELP' => 'Aquí teniu les files del fitxer que no han estat importades perquè són possibles duplicats de registres existents. Les dades coincidents es mostren ressaltades. Per tornar a importar aquestes files descarregueu la llista, realitzeu-hi els canvis necessaris i feu clic a "Torna a importar".',
    'LBL_SUMMARY' => 'Resum',
    'LBL_OK' => 'Accepta',
    'LBL_ERROR_HELP' => 'Aquí teniu les files del fitxer que no han estat importades perquè contenen errors. Per tornar a importar aquestes files descarregueu la llista, realitzeu-hi els canvis necessaris i feu clic a "Torna a importar".',
    'LBL_EXTERNAL_ASSIGNED_TOOLTIP' => 'Per assignar els nous registres a un altre usuari, utilitzeu la columna "Valor per defecte".',
    'LBL_EXTERNAL_TEAM_TOOLTIP' => 'Per assignar els nous registres a un altre equip, utilitzeu la columna "Valor per defecte".',
    // STIC-Custom 20221103 MHP - STIC#904
    'LBL_ERROR_CYCLIC_DEPENDENCY' => ' no pot informar a ',
    // END STIC-Custom
);

global $timedate;
