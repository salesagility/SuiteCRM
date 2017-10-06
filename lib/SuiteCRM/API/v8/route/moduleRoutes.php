<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2017 SalesAgility Ltd.
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

$app->group('/v8/modules', function () use ($app) {
    $app->get('', 'ModuleController:getModules');
    $app->get('meta/menu/modules', 'ModuleController:getModulesMenuModules');
    $app->get('meta/menu/filters', 'ModuleController:getModulesMenuFilters');
    $app->get('meta/viewed', 'ModuleController:getRecordsViewed');
    $app->get('meta/favorites', 'ModuleController:getFavorites');

    $app->group('/{module}', function () use ($app) {

        $app->get('', 'ModuleController:getModuleRecords');
        $app->post('', 'ModuleController:createModuleRecord');

        $app->get('meta/language', 'ModuleController:getLanguageDefinition');
        $app->get('meta/fields', 'ModuleController:getModuleFields');
        $app->get('meta/links', 'ModuleController:getModuleLinks');
        $app->get('meta/menu', 'ModuleController:getModuleMenu');
        $app->get('meta/viewed', 'ModuleController:getModuleRecordsViewed');
        $app->get('meta/favorites', 'ModuleController:getModuleFavorites');
        $app->get('meta/view/{view}', 'ModuleController:getModuleLayout');

        $relationship = '/{id}/relationships/{link}/{related_id}';
        $app->get($relationship,'ModuleController:getRelationship');
        $app->post($relationship,'ModuleController:createRelationship');
        $app->patch($relationship,'ModuleController:updateRelationship');
        $app->delete($relationship,'ModuleController:deleteRelationship');

        $app->get('/{id}/relationships/{link}','ModuleController:getModuleRelationships');
        $app->delete('/{id}/relationships/{link}','ModuleController:deleteRelationships');

        $id = '/{id}';
        $app->get($id, 'ModuleController:getModuleRecord');
        $app->patch($id, 'ModuleController:updateModuleRecord');
        $app->delete($id, 'ModuleController:deleteModuleRecord');

    });
});
