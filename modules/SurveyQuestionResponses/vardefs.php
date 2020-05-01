<?php
/**
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
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
$dictionary['SurveyQuestionResponses'] = [
    'table' => 'surveyquestionresponses',
    'audited' => true,
    'inline_edit' => true,
    'duplicate_merge' => true,
    'fields' => [
        'answer' => [
            'name' => 'answer',
            'vname' => 'LBL_ANSWER',
            'type' => 'text',
        ],
        'answer_bool' => [
            'name' => 'answer_bool',
            'vname' => 'LBL_ANSWER',
            'type' => 'bool',
        ],
        'answer_datetime' => [
            'name' => 'answer_datetime',
            'vname' => 'LBL_ANSWER',
            'type' => 'datetime',
        ],
        'surveyquestionoptions_surveyquestionresponses' => [
            'name' => 'surveyquestionoptions_surveyquestionresponses',
            'type' => 'link',
            'relationship' => 'surveyquestionoptions_surveyquestionresponses',
            'source' => 'non-db',
            'module' => 'SurveyQuestionOptions',
            'bean_name' => 'SurveyQuestionOptions',
            'vname' => 'LBL_SURVEYQUESTIONOPTIONS_SURVEYQUESTIONRESPONSES_FROM_SURVEYQUESTIONOPTIONS_TITLE',
        ],
        'surveyquestion' => [
            'name' => 'surveyquestion',
            'type' => 'link',
            'relationship' => 'surveyquestions_surveyquestionresponses',
            'source' => 'non-db',
            'module' => 'SurveyQuestions',
            'bean_name' => 'SurveyQuestions',
            'vname' => 'LBL_SURVEYQUESTIONS_SURVEYQUESTIONRESPONSES_FROM_SURVEYQUESTIONS_TITLE',
            'id_name' => 'surveyquestion_id',
            'link_type' => 'one',
            'side' => 'left',
        ],
        'surveyquestion_name' => [
            'name' => 'surveyquestion_name',
            'type' => 'relate',
            'source' => 'non-db',
            'vname' => 'LBL_SURVEYQUESTIONS_SURVEYQUESTIONRESPONSES_FROM_SURVEYQUESTIONS_TITLE',
            'save' => true,
            'id_name' => 'surveyquestion_id',
            'link' => 'surveyquestion',
            'table' => 'surveyquestions',
            'module' => 'SurveyQuestions',
            'rname' => 'name',
        ],
        'surveyquestion_id' => [
            'name' => 'surveyquestion_id',
            'type' => 'id',
            'reportable' => false,
            'vname' => 'LBL_SURVEYQUESTIONS_SURVEYQUESTIONRESPONSES_FROM_SURVEYQUESTIONRESPONSES_TITLE',
        ],
        'surveyresponse' => [
            'name' => 'surveyresponse',
            'type' => 'link',
            'relationship' => 'surveyresponses_surveyquestionresponses',
            'source' => 'non-db',
            'module' => 'SurveyResponses',
            'bean_name' => 'SurveyResponses',
            'vname' => 'LBL_SURVEYRESPONSES_SURVEYQUESTIONRESPONSES_FROM_SURVEYRESPONSES_TITLE',
            'id_name' => 'surveyresponse_id',
            'link_type' => 'one',
            'side' => 'left',
        ],
        'surveyresponse_name' => [
            'name' => 'surveyresponse_name',
            'type' => 'relate',
            'source' => 'non-db',
            'vname' => 'LBL_SURVEYRESPONSES_SURVEYQUESTIONRESPONSES_FROM_SURVEYRESPONSES_TITLE',
            'save' => true,
            'id_name' => 'surveyresponse_id',
            'link' => 'survey_response',
            'table' => 'surveyresponses',
            'module' => 'SurveyResponses',
            'rname' => 'name',
        ],
        'surveyresponse_id' => [
            'name' => 'surveyresponse_id',
            'type' => 'id',
            'reportable' => false,
            'vname' => 'LBL_SURVEYRESPONSES_SURVEYQUESTIONRESPONSES_FROM_SURVEYQUESTIONRESPONSES_TITLE',
        ],
    ],
    'relationships' => [],
    'optimistic_locking' => true,
    'unified_search' => true,
];
if (!class_exists('VardefManager')) {
    require_once 'include/SugarObjects/VardefManager.php';
}
VardefManager::createVardef(
    'SurveyQuestionResponses',
    'SurveyQuestionResponses',
    ['basic', 'assignable', 'security_groups']
);
