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

/**
 * controller.php
 * @author SalesAgility (Andrew Mclaughlan) <support@salesagility.com>
 * Date: 06/03/15
 * Comments
 */
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class CasesController extends SugarController {

   public function action_get_kb_articles(){
        global $mod_strings;
        global $app_list_strings;
        $search = $_POST['search'];
        $status_list = $app_list_strings['aok_status_list'];

        $query = "SELECT id, name, description, status, sum(relevance)
                  FROM (
                        SELECT id, name, description, status, 10 AS relevance
                        FROM aok_knowledgebase
                        WHERE name = '".$search."'
                        AND deleted = '0'
                        UNION SELECT id, name, description, status, 5 AS relevance
                        FROM aok_knowledgebase
                        WHERE name LIKE '%".$search."%'
                        AND deleted = '0'
                        UNION SELECT id, name, description, status, 2 AS relevance
                        FROM aok_knowledgebase
                        WHERE description LIKE '%".$search."%'
                        AND deleted = '0'
                        )results
                    GROUP BY id
                    ORDER BY sum( relevance ) DESC
        ";

        $offset = 0;
        $limit = 30;

        $result = $GLOBALS['db']->limitQuery($query, $offset, $limit);
        if($result->num_rows != 0){
            echo '<table>';
            echo '<tr><th>'.$mod_strings['LBL_SUGGESTION_BOX_REL'].'</th><th>'.$mod_strings['LBL_SUGGESTION_BOX_TITLE'].'</th><th>'.$mod_strings['LBL_SUGGESTION_BOX_STATUS'].'</th></tr>';
            $count =1;
            while($row = $GLOBALS['db']->fetchByAssoc($result) )
            {
                echo '<tr class="kb_article" data-id="'.$row['id'].'">';
                echo '<td> &nbsp;'.$count.'</td>';
                echo '<td>'.$row['name'].'</td>';
                echo '<td>'.$status_list = $app_list_strings['aok_status_list'][$row['status']].'</td>';
                echo '</tr>';
                $count++;
            }
            echo '</table>';
        }
        else {
            echo $mod_strings['LBL_NO_SUGGESTIONS'];
        }
        die();
    }
    public function action_get_kb_article(){
        global $mod_strings;

        $article_id = $_POST['article'];
        $article = new AOK_KnowledgeBase();
        $article->retrieve($article_id);

        echo '<span class="tool-tip-title"><strong>'.$mod_strings['LBL_TOOL_TIP_TITLE'].'</strong>'.$article->name.'</span><br />';
        echo '<span class="tool-tip-title"><strong>'.$mod_strings['LBL_TOOL_TIP_BODY'].'</strong></span>'.html_entity_decode($article->description);

        if(!$this->IsNullOrEmptyString($article->additional_info)){
            echo '<hr id="tool-tip-separator">';
            echo '<span class="tool-tip-title"><strong>'.$mod_strings['LBL_TOOL_TIP_INFO'].'</strong></span><p id="additional_info_p">'.$article->additional_info.'</p>';
            echo '<span class="tool-tip-title"><strong>'.$mod_strings['LBL_TOOL_TIP_USE'].'</strong></span><br />';
            echo '<input id="use_resolution" name="use_resolution" class="button" type="button" value="'.$mod_strings['LBL_RESOLUTION_BUTTON'].'" />';
        }

       die();
    }

    // Function for basic field validation (present and neither empty nor only white space
   private function IsNullOrEmptyString($question){
        return (!isset($question) || trim($question)==='');
    }



}