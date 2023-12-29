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
    'LBL_NAME' => 'Nome de Tarefa',
    'LBL_EXECUTE_TIME' => 'Hora de Execución',
    'LBL_SCHEDULER_ID' => 'Planificador',
    'LBL_STATUS' => 'Estado de tarefa',
    'LBL_RESOLUTION' => 'Resolución',
    'LBL_MESSAGE' => 'Mensaxes',
    'LBL_DATA' => 'Data de tarefa',
    'LBL_REQUEUE' => 'Vuelver a intentar en caso de fallo',
    'LBL_RETRY_COUNT' => 'Intentos máximos',
    'LBL_FAIL_COUNT' => 'Fallos',
    'LBL_INTERVAL' => 'Intervalo mínimo entre intentos',
    'LBL_CLIENT' => 'Ser propietario de cliente',
    'LBL_PERCENT' => 'Porcentaxe completado',
// Errors
    'ERR_CALL' => "Non se pode chamar á función: %s",
    'ERR_CURL' => "Non CURL - non se pode executar traballos de URL",
    'ERR_FAILED' => "Erro inesperado, por favor, consulte os rexistros de PHP e suitecrm.log",
    'ERR_PHP' => "%s [%d]: %s en %s on line %d",
    'ERR_NOUSER' => "Non ID de usuario especificado para o traballo",
    'ERR_NOSUCHUSER' => "ID %s de usuario non encontrado",
    'ERR_JOBTYPE' => "Tipo de tarefa descoñecido: %s",
    'ERR_TIMEOUT' => "Fracaso forzoso por tempo de espera",
    'ERR_JOB_FAILED_VERBOSE' => 'Tarefa %1$s (%2$s) fallo na execución do CRON',
);
