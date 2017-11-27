<?php

/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
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
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
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
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 ********************************************************************************/
class Surveys extends Basic
{

    var $new_schema = true;
    var $module_dir = 'Surveys';
    var $object_name = 'Surveys';
    var $table_name = 'surveys';
    var $importable = false;
    var $disable_row_level_security = true; // to ensure that modules created and deployed under CE will continue to function under team security if the instance is upgraded to PRO

    var $id;
    var $name;
    var $date_entered;
    var $date_modified;
    var $modified_user_id;
    var $modified_by_name;
    var $created_by;
    var $created_by_name;
    var $description;
    var $deleted;
    var $created_by_link;
    var $modified_user_link;
    var $assigned_user_id;
    var $assigned_user_name;
    var $assigned_user_link;
    var $SecurityGroups;
    var $status;

    function __construct()
    {
        parent::__construct();
    }

    function bean_implements($interface)
    {
        switch ($interface) {
            case 'ACL':
                return true;
        }

        return false;
    }

    public function save($check_notify = false)
    {
        $res = parent::save($check_notify);
        if (empty($_REQUEST['survey_questions_supplied'])) {
            return $res;
        }

        foreach ($_REQUEST['survey_questions_names'] as $key => $val) {
            if (!empty($_REQUEST['survey_questions_ids'][$key])) {
                $question = BeanFactory::getBean('SurveyQuestions', $_REQUEST['survey_questions_ids'][$key]);
            } else {
                $question = BeanFactory::newBean('SurveyQuestions');
            }
            $question->name = $val;
            $question->type = $_REQUEST['survey_questions_types'][$key];
            $question->sort_order = $_REQUEST['survey_questions_sortorder'][$key];
            $question->survey_id = $this->id;
            $question->deleted = $_REQUEST['survey_questions_deleted'][$key];
            $question->save();
            if (!empty($_REQUEST['survey_questions_options'][$key])) {
                $this->saveOptions(
                    $_REQUEST['survey_questions_options'][$key],
                    $_REQUEST['survey_questions_options_id'][$key],
                    $_REQUEST['survey_questions_options_deleted'][$key],
                    $question->id
                );
            }
        }

        return $res;
    }

    private function saveOptions($options, $ids, $deleted, $questionId)
    {
        foreach ($options as $key => $option) {
            if (!empty($ids[$key])) {
                $optionBean = BeanFactory::getBean('SurveyQuestionOptions', $ids[$key]);
            } else {
                $optionBean = BeanFactory::newBean('SurveyQuestionOptions');
            }
            if ($deleted[$key]) {
                $optionBean->deleted = 1;
            }
            $optionBean->name = $option;
            $optionBean->survey_question_id = $questionId;
            $optionBean->sort_order = $key;
            $optionBean->save();
        }
    }

    public function getCampaignSurveyLink(Contact $contact, $targetTracker = false)
    {
        global $sugar_config;
        $url = $sugar_config['site_url'] . '/index.php?entryPoint=survey&id=' . $this->id . '&contact=' . $contact->id;
        if (!empty($targetTracker)) {
            $url .= '&tracker=' . $targetTracker;
        }

        return $url;
    }

    public function getMatrixOptions()
    {
        return array(
            0 => !empty($this->satisfied_text) ? $this->satisfied_text : 'Satisfied',
            1 => !empty($this->neither_text) ? $this->neither_text : 'Neither Satisfied nor Dissatisfied',
            2 => !empty($this->dissatisfied_text) ? $this->dissatisfied_text : 'Dissatisfied',
        );
    }

    public function getSubmitText()
    {
        if (!empty($this->submit_text)) {
            return $this->submit_text;
        }

        return "Submit";
    }

}