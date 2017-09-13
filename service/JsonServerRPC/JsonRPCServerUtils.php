<?php

class JsonRPCServerUtils
{
    /**
     * @param $query_obj
     * @param string $table
     * @param null $module
     * @return string
     */
    public function constructWhere(&$query_obj, $table = '', $module = null)
    {
        if (!empty($table)) {
            $table .= '.';
        }
        $cond_arr = array();

        if (!is_array($query_obj['conditions'])) {
            $query_obj['conditions'] = array();
        }

        foreach ($query_obj['conditions'] as $condition) {
            if ($condition['name'] === 'user_hash') {
                continue;
            }
            if ($condition['name'] === 'email1' || $condition['name'] === 'email2') {

                $email1_value = strtoupper($condition['value']);
                $email1_condition = " {$table}id in ( SELECT  er.bean_id AS id FROM email_addr_bean_rel er, " .
                    'email_addresses ea WHERE ea.id = er.email_address_id ' .
                    "AND ea.deleted = 0 AND er.deleted = 0 AND er.bean_module = '{$module}' AND email_address_caps LIKE '%{$email1_value}%' )";

                $cond_arr[] = $email1_condition;
            } else {
                if ($condition['op'] === 'contains') {
                    $cond_arr[] = $table . $GLOBALS['db']->getValidDBName($condition['name']) . " like '%" . $GLOBALS['db']->quote($condition['value']) . "%'";
                }
                if ($condition['op'] === 'like_custom') {
                    $like = '';
                    if (!empty($condition['begin'])) {
                        $like .= $GLOBALS['db']->quote($condition['begin']);
                    }
                    $like .= $GLOBALS['db']->quote($condition['value']);
                    if (!empty($condition['end'])) {
                        $like .= $GLOBALS['db']->quote($condition['end']);
                    }
                    $cond_arr[] = $table . $GLOBALS['db']->getValidDBName($condition['name']) . " like '$like'";
                } else { // starts_with
                    $cond_arr[] = $table . $GLOBALS['db']->getValidDBName($condition['name']) . " like '" . $GLOBALS['db']->quote($condition['value']) . "%'";
                }
            }
        }

        if ($table === 'users.') {
            $cond_arr[] = $table . "status='Active'";
        }
        $group = strtolower(trim($query_obj['group']));
        if ($group !== 'and' && $group !== 'or') {
            $group = 'and';
        }

        return implode(" $group ", $cond_arr);
    }

    /**
     * Authenticates User
     * @return null|User
     */
    public function authenticate()
    {
        global $sugar_config;
        global $log;

        $user_unique_key = isset($_SESSION['unique_key']) ? $_SESSION['unique_key'] : '';
        $server_unique_key = isset($sugar_config['unique_key']) ? $sugar_config['unique_key'] : '';

        if ($user_unique_key !== $server_unique_key) {
            $log->debug('JSON_SERVER: user_unique_key:' . $user_unique_key . '!=' . $server_unique_key);
            session_destroy();

            return null;
        }

        if (!isset($_SESSION['authenticated_user_id'])) {
            $log->debug('JSON_SERVER: authenticated_user_id NOT SET. DESTROY');
            session_destroy();

            return null;
        }

        /**
         * @var User $current_user;
         */
        $current_user = BeanFactory::newBean('Users');

        $result = $current_user->retrieve($_SESSION['authenticated_user_id']);
        $GLOBALS['log']->debug('JSON_SERVER: retrieved user from SESSION');


        if ($result === null) {
            $GLOBALS['log']->debug('JSON_SERVER: could get a user from SESSION. DESTROY');
            session_destroy();

            return null;
        }

        return $result;
    }
}
