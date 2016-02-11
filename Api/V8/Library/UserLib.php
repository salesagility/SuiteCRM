<?php
namespace SuiteCRM\Api\V8\Library;


class UserLib{

    function getUpcomingActivities($user)
    {
        global $beanList;
        $maxCount = 10;

        $activityModules = array('Meetings' => array('date_field' => 'date_start','status' => 'Planned','status_field' => 'status', 'status_opp' => '='),
            'Calls' => array('date_field' => 'date_start','status' => 'Planned','status_field' => 'status', 'status_opp' => '='),
            'Tasks' => array('date_field' =>'date_due','status' => 'Not Started','status_field' => 'status','status_opp' => '='),
            'Opportunities' => array('date_field' => 'date_closed','status' => array('Closed Won','Closed Lost'), 'status_field' => 'sales_stage', 'status_opp' => '!=') );
        $results = array();
        foreach ($activityModules as $module => $meta)
        {
            if(!self::check_modules_access($user, $module, 'read'))
            {
                continue;
            }

            $class_name = $beanList[$module];
            $seed = new $class_name();
            $query = $this->generateUpcomingActivitiesWhereClause($seed, $meta,$user);

            $response = $seed->get_list(/* Order by date field */"{$meta['date_field']} ASC",  /*Where clause */$query, /* No Offset */ 0,
                /* No limit */-1, /* Max 10 items */10, /*No Deleted */ 0 );

            $result = array();

            if( isset($response['list']) )
                $result = $this->format_upcoming_activities_entries($response['list'],$meta['date_field']);

            $results = array_merge($results,$result);
        }

        //Sort the result list by the date due flag in ascending order
        usort( $results, array( $this , "cmp_datedue" ) ) ;

        //Only return a subset of the results.
        $results = array_slice($results, 0, $maxCount);

        return $results;
    }

    function generateUpcomingActivitiesWhereClause($seed,$meta,$user)
    {
        $query = array();
        $query_date = \TimeDate::getInstance()->nowDb();
        $query[] = " {$seed->table_name}.{$meta['date_field']} > '$query_date'"; //Add date filter
        $query[] = "{$seed->table_name}.assigned_user_id = '{$user->id}' "; //Add assigned user filter
        if(is_array($meta['status_field']))
        {
            foreach ($meta['status'] as $field)
                $query[] = "{$seed->table_name}.{$meta['status_field']} {$meta['status_opp']} '".$GLOBALS['db']->quote($field)."' ";
        }
        else
            $query[] = "{$seed->table_name}.{$meta['status_field']} {$meta['status_opp']} '".$GLOBALS['db']->quote($meta['status'])."' ";

        return implode(" AND ",$query);
    }

    function check_modules_access($user, $module_name, $action='write'){
        if(!isset($_SESSION['avail_modules'])){
            $_SESSION['avail_modules'] = $this->get_user_module_list($user);
        }
        if(isset($_SESSION['avail_modules'][$module_name])){
            if($action == 'write' && $_SESSION['avail_modules'][$module_name] == 'read_only'){
                if(is_admin($user)) {
                    return true;
                } // if
                return false;
            }elseif($action == 'write' && strcmp(strtolower($module_name), 'users') == 0 && !$user->isAdminForModule($module_name)){
                //rrs bug: 46000 - If the client is trying to write to the Users module and is not an admin then we need to stop them
                return false;
            }
            return true;
        }
        return false;
    }

    function get_user_module_list($user){
        global $app_list_strings, $current_language;
        $app_list_strings = return_app_list_strings_language($current_language);
        $modules = query_module_access_list($user);
        \ACLController :: filterModuleList($modules, false);
        global $modInvisList;

        foreach($modInvisList as $invis){
            $modules[$invis] = 'read_only';
        }

        $actions = \ACLAction::getUserActions($user->id,true);
        foreach($actions as $key=>$value){
            if(isset($value['module']) && $value['module']['access']['aclaccess'] < ACL_ALLOW_ENABLED){
                if ($value['module']['access']['aclaccess'] == ACL_ALLOW_DISABLED) {
                    unset($modules[$key]);
                } else {
                    $modules[$key] = 'read_only';
                } // else
            } else {
                $modules[$key] = '';
            } // else
        } // foreach
        return $modules;
    }

    function format_upcoming_activities_entries($list,$date_field)
    {
        $results = array();
        foreach ($list as $bean)
        {
            $results[] = array('id' => $bean->id, 'module' => $bean->module_dir,'date_due' => $bean->$date_field,
                'summary' => $bean->get_summary_text() );
        }

        return $results;
    }



}