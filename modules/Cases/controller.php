<?php
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