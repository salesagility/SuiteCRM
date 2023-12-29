<?php
/**
 * This file is part of SinergiaCRM.
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation.
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
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 */

$mod_strings = array(
    'LBL_ASSIGNED_TO_ID' => 'Assignat a (ID)',
    'LBL_ASSIGNED_TO_NAME' => 'Assignat a',
    'LBL_ASSIGNED_TO' => 'Assignat a',
    'LBL_LIST_ASSIGNED_TO_NAME' => 'Assignat a',
    'LBL_LIST_ASSIGNED_USER' => 'Assignat a',
    'LBL_CREATED' => 'Creat per',
    'LBL_CREATED_USER' => 'Creat per',
    'LBL_CREATED_ID' => 'Creat per (ID)',
    'LBL_MODIFIED' => 'Modificat per',
    'LBL_MODIFIED_NAME' => 'Modificat per',
    'LBL_MODIFIED_USER' => 'Modificat per',
    'LBL_MODIFIED_ID' => 'Modificat per (ID)',
    'LBL_SECURITYGROUPS' => 'Grups de seguretat',
    'LBL_SECURITYGROUPS_SUBPANEL_TITLE' => 'Grups de seguretat',
    'LBL_ID' => 'ID',
    'LBL_DATE_ENTERED' => 'Data de Creació',
    'LBL_DATE_MODIFIED' => 'Data de Modificació',
    'LBL_DESCRIPTION' => 'Descripció',
    'LBL_DELETED' => 'Suprimit',
    'LBL_NAME' => 'Nom',
    'LBL_LIST_NAME' => 'Nom',
    'LBL_EDIT_BUTTON' => 'Edita',
    'LBL_REMOVE' => 'Desvincula',
    'LBL_LIST_FORM_TITLE' => "Llista d'Arxius XML SEPE",
    'LBL_MODULE_NAME' => "Generador XML SEPE",
    'LBL_MODULE_TITLE' => "Generador XML SEPE",
    'LBL_HOMEPAGE_TITLE' => 'Els meus Arxius XML SEPE',
    'LNK_NEW_RECORD' => 'Crea un Arxiu XML SEPE',
    'LNK_LIST' => 'Mostra els Arxius XML SEPE',
    'LNK_IMPORT_STIC_SEPE_FILES' => 'Importa Arxius XML SEPE',
    'LBL_SEARCH_FORM_TITLE' => 'Cerca Arxius XML SEPE',
    'LBL_HISTORY_SUBPANEL_TITLE' => 'Historial',
    'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Activitats',
    'LBL_STIC_SEPE_FILES_SUBPANEL_TITLE' => 'Generador XML SEPE',
    'LBL_NEW_FORM_TITLE' => 'Nou Arxiu XML SEPE',
    'LBL_STATUS' => 'Estat',
    'LBL_TYPE' => "Tipus d'arxiu",
    'LBL_REPORTED_MONTH' => 'Mes/any reportat',
    'LBL_LOG' => "Registre d'errors",
    'LBL_AGREEMENT' => 'Conveni',
    'LBL_GENERATE_XML_FILE' => 'Genera arxiu XML',
    'LBL_SEPE_LOG_TITLE' => "Aquest arxiu ha estat generat l'última vegada per: ",
    'LBL_SEPE_GENERATED_WITHOUT_ERRORS' => 'Arxiu XML generat sense errors.',
    'LBL_SEPE_XML_HAS_ERRORS' => "L'arxiu XML no s'ha generat perquè hi ha errors que cal corregir.",
    'LBL_ERROR_DATE_FUTURE' => "La data del camp 'Mes reportat' de l'arxiu XML ha de ser passada o igual a la data d'avui.",
    'LBL_ERROR_SEPE_CODIGO_AGENCIA' => 'El valor de la constant SEPE_CODIGO_AGENCIA no és correcte. Hauria de ser un valor numèric de 10 dígits.',
    'LBL_ERROR_SEPE_AGREEMENT' => 'Als arxius de tipus ACCD o ACCI és necessari indicar-hi un codi de conveni.',
    'LBL_ERROR_PATTERN_SEPE_AGREEMENT' => 'El Codi de Conveni no és correcte. Ha de ser una cadena de 10 caràcters format per números i lletres',
    'LBL_SEPE_ERRORS_TITLE' => "L'arxiu no s'ha generat a causa dels següents errors:",
    'LBL_ERROR_SEPE_REQUIRED' => 'El següent camp (del mòdul) és requerit: ',
    'LBL_ERROR_SEPE_PATTERN' => 'El següent camp (del mòdul) no té el format correcte: ',
    'LBL_ERROR_SEPE_NOT_IN_LIST' => 'El valor del següent camp (del mòdul) no pertany a les llistes SEPE: ',
    'LBL_ERROR_SEPE_LENGTH_EXCEEDED' => 'El valor del següent camp (del mòdul) és massa llarg: ',
    'LBL_ERRORS_SEPE_CHECK' => 'Revisar',
    'LBL_SEPE_WARNINGS_TITLE' => "Avisos (registres que podrien afegir-se a l'arxiu però que necessitarien modificacions prèvies)",
    'LBL_WARNING_JOB_OFFER_NOT_SEPE_ACTIVATED' => "Una persona donada d'alta al SEPE està vinculada a una oferta que no té data d'activació SEPE (o la data d'activació de l'oferta és posterior a la data d'alta de la persona): ",
    'LBL_WARNING_JOB_OFFER_COVERED_NOT_ACTIVATED' => "Una oferta amb data d'oferta coberta SEPE no té data d'activació SEPE o la data d'activació és posterior: ",
    'LBL_WARNING_CONTACT_NOT_SEPE_ACTIVATED' => "Una persona vinculada a una oferta SEPE no està donada d'alta amb l'acció d'Alta SEPE (o la data d'alta és posterior a dates de la candidatura): ",
    'LBL_WARNING_CONTACT_AND_JOB_OFFER_NOT_SEPE_ACTIVATED' => "Una candidatura té almenys una data anterior a la data d'alta SEPE de la persona o a la data d'activació de l'oferta: ",
    'LBL_WARNING_ACCD_ACTION_SEPE_NOT_ACTIVATED' => "Una persona té accions SEPE però no està donada d'alta amb l'acció d'Alta SEPE (o la data d'alta és posterior a dates de les accions): ",
    'LBL_WARNING_ACCI_ACTION_SEPE_NOT_ACTIVATED' => "Una persona té incidències SEPE però no està donada d'alta amb l'acció d'Alta SEPE (o la data d'alta és posterior a dates de les incidències): ",
    'LBL_DEFAULT_PANEL' => 'Dades generals',
    'LBL_PANEL_RECORD_DETAILS' => 'Detalls del registre',
    'LBL_REPORTED_MONTH_HELP' => "Escolliu qualsevol dia del mes o de l'any pel qual necessiteu generar l'arxiu. Per exemple, si voleu generar l'arxiu del mes de setembre, podeu seleccionar qualsevol dia de l'1 al 30. Si voleu generar l'arxiu de 2019, podeu seleccionar qualsevol dia des de l'1 de gener fins al 31 de desembre de 2019.",
    'LBL_AGREEMENT_HELP' => "El camp Codi de conveni s'activará, i és obligatori, pels arxius ACCD/ACCI. Es poden editar i afegir nous convenis amb un usuari d'administrador des de l'Editor de llistes desplegables, editant la llista 'stic_sepe_agreement_list'.",
    'LBL_AGREEMENT_EMPTY_ERROR' => "Si el camp Tipus conté un valor d'Agencia de Col·locació colaboradora, el camp Conveni és obligatori.",
    'LBL_AGREEMENT_ERROR' => "Si el camp Tipus no conté un valor d'Agencia de Col·locació colaboradora, el camp Conveni ha d'estar buit.",
);
