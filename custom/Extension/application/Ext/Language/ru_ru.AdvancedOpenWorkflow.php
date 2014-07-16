<?php
/**
 * Advanced OpenWorkflow, Automating SugarCRM.
 * @package Advanced OpenWorkflow for SugarCRM
 * @copyright SalesAgility Ltd http://www.salesagility.com
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU AFFERO GENERAL PUBLIC LICENSE
 * along with this program; if not, see http://www.gnu.org/licenses
 * or write to the Free Software Foundation,Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA 02110-1301  USA
 *
 * @author SalesAgility <info@salesagility.com>
 */


$app_list_strings['moduleList']['AOW_WorkFlow'] = 'Процессы';
$app_list_strings['moduleList']['AOW_Conditions'] = 'Условия';
$app_list_strings['moduleList']['AOW_Processed'] = 'Контроль процессов';
$app_list_strings['moduleList']['AOW_Actions'] = 'Действия';

$app_list_strings['aow_status_list']['Active'] = 'Активен';
$app_list_strings['aow_status_list']['Inactive'] = 'Не активен';

$app_list_strings['aow_operator_list']['Equal_To'] = '=';
$app_list_strings['aow_operator_list']['Not_Equal_To'] = '!=';
$app_list_strings['aow_operator_list']['Greater_Than'] = '>';
$app_list_strings['aow_operator_list']['Less_Than'] = '>';
$app_list_strings['aow_operator_list']['Greater_Than_or_Equal_To'] = '>=';
$app_list_strings['aow_operator_list']['Less_Than_or_Equal_To'] = '<=';

$app_list_strings['aow_sql_operator_list']['Equal_To'] = '=';
$app_list_strings['aow_sql_operator_list']['Not_Equal_To'] = '!=';
$app_list_strings['aow_sql_operator_list']['Greater_Than'] = '>';
$app_list_strings['aow_sql_operator_list']['Less_Than'] = '<';
$app_list_strings['aow_sql_operator_list']['Greater_Than_or_Equal_To'] = '>=';
$app_list_strings['aow_sql_operator_list']['Less_Than_or_Equal_To'] = '<=';

$app_list_strings['aow_process_status_list']['Complete'] = 'Завершён';
$app_list_strings['aow_process_status_list']['Running'] = 'Выполняется';
$app_list_strings['aow_process_status_list']['Pending'] = 'В ожидании';
$app_list_strings['aow_process_status_list']['Failed'] = 'Ошибка выполнения';

$app_list_strings['aow_condition_operator_list']['And'] = 'И';
$app_list_strings['aow_condition_operator_list']['OR'] = 'ИЛИ';
$app_list_strings['aow_condition_operator_list']['OR'] = 'ИЛИ';

$app_list_strings['aow_condition_type_list']['Value'] = 'Значение';
$app_list_strings['aow_condition_type_list']['Field'] = 'Поле';
$app_list_strings['aow_condition_type_list']['Any_Change'] = 'Изменение';
$app_list_strings['aow_condition_type_list']['SecurityGroup'] = 'Состоит в Группе пользователей';
$app_list_strings['aow_condition_type_list']['Date'] = 'Дата';
$app_list_strings['aow_condition_type_list']['Multi'] = 'Мультивыбор';

$app_list_strings['aow_action_type_list']['Value'] = 'Значение';
$app_list_strings['aow_action_type_list']['Field'] = 'Поле';
$app_list_strings['aow_action_type_list']['Date'] = 'Дата';
$app_list_strings['aow_action_type_list']['Round_Robin'] = 'Назначение в цикле';
$app_list_strings['aow_action_type_list']['Least_Busy'] = 'Назначение наименее занятого';
$app_list_strings['aow_action_type_list']['Random'] = 'Случайное назначение';

$app_list_strings['aow_rel_action_type_list']['Value'] = 'Значение';
$app_list_strings['aow_rel_action_type_list']['Field'] = 'Поле';

$app_list_strings['aow_date_type_list'][''] = '';
$app_list_strings['aow_date_type_list']['minute'] = 'минут';
$app_list_strings['aow_date_type_list']['hour'] = 'часов';
$app_list_strings['aow_date_type_list']['day'] = 'дней';
$app_list_strings['aow_date_type_list']['week'] = 'недель';
$app_list_strings['aow_date_type_list']['month'] = 'месяцев';
$app_list_strings['aow_date_type_list']['business_hours'] = 'рабочих часов';

$app_list_strings['aow_date_options']['now'] = 'Сейчас';
$app_list_strings['aow_date_options']['field'] = 'Это поле';

$app_list_strings['aow_date_operator']['now'] = '';
$app_list_strings['aow_date_operator']['plus'] = '+';
$app_list_strings['aow_date_operator']['minus'] = '-';

$app_list_strings['aow_assign_options']['all'] = 'ВСЕ пользователи';
$app_list_strings['aow_assign_options']['role'] = 'ВСЕ пользователи роли';
$app_list_strings['aow_assign_options']['security_group'] = 'ВСЕ пользователи из Группы';

$app_list_strings['aow_email_type_list']['Email Address'] = 'Вручную';
$app_list_strings['aow_email_type_list']['Record Email'] = 'Отобранной записи';
$app_list_strings['aow_email_type_list']['Related Field'] = 'Связанного модуля';
$app_list_strings['aow_email_type_list']['Specify User'] = 'Пользователя';
$app_list_strings['aow_email_type_list']['Users'] = 'Пользователей';
$app_list_strings['aow_email_to_list']['to'] = 'Кому';
$app_list_strings['aow_email_to_list']['cc'] = 'Копия';
$app_list_strings['aow_email_to_list']['bcc'] = 'Скрытая копия';

$app_list_strings['aow_run_on_list']['All_Records'] = 'Всех записей';
$app_list_strings['aow_run_on_list']['New_Records'] = 'Создаваемых записей';
$app_list_strings['aow_run_on_list']['Modified_Records'] = 'Изменяемых записей';

$app_list_strings['aow_run_on_list']['All_Records'] = 'Всех записей';
$app_list_strings['aow_run_on_list']['New_Records'] = 'Создаваемых записей';
$app_list_strings['aow_run_on_list']['Modified_Records'] = 'Изменяемых записей';


