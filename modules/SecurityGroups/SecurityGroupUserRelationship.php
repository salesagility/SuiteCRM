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

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('data/SugarBean.php');

// Contact is used to store customer information.
class SecurityGroupUserRelationship extends SugarBean {
    // Stored fields
    public $id;
    public $securitygroup_id;
    public $securitygroup_noninheritable;
    public $user_id;
    public $noninheritable;
    public $primary_group;

    // Related fields
    public $securitygroup_name;
    public $user_name;

    public $table_name = "securitygroups_users";
    public $object_name = "SecurityGroupUserRelationship";
    public $column_fields = Array("id"
        ,"securitygroup_id"
        ,"user_id"
        ,"noninheritable"
        ,"primary_group"
        ,'date_modified'
        );

    public $new_schema = true;

    public $additional_column_fields = Array();
        public $field_defs = array (
       'id'=>array('name' =>'id', 'type' =>'char', 'len'=>'36', 'default'=>'')
      , 'securitygroup_id'=>array('name' =>'securitygroup_id', 'type' =>'char', 'len'=>'36', )
      , 'user_id'=>array('name' =>'user_id', 'type' =>'char', 'len'=>'36',)
      , 'noninheritable'=>array('name' =>'noninheritable', 'type' =>'bool', 'len'=>'1')
      , 'primary_group'=>array('name' =>'primary_group', 'type' =>'bool', 'len'=>'1')
      , 'date_modified'=>array ('name' => 'date_modified','type' => 'datetime')
      , 'deleted'=>array('name' =>'deleted', 'type' =>'bool', 'len'=>'1', 'default'=>'0', 'required'=>true)
      );
    function __construct() {
        $this->db = DBManagerFactory::getInstance();
        $this->dbManager = DBManagerFactory::getInstance();

        $this->disable_row_level_security =true;

        }

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    function SecurityGroupUserRelationship(){
        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code';
        if(isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        } else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct();
    }


    function fill_in_additional_detail_fields()
    {
        if(isset($this->securitygroup_id) && $this->securitygroup_id != "")
        {
            $query = "SELECT name from securitygroups where id='$this->securitygroup_id' AND deleted=0";
            $result =$this->db->query($query,true," Error filling in additional detail fields: ");
            // Get the id and the name.
            $row = $this->db->fetchByAssoc($result);

            if($row != null)
            {
                $this->securitygroup_name = $row['name'];
            }
        }

        if(isset($this->user_id) && $this->user_id != "")
        {
            $query = "SELECT user_name from users where id='$this->user_id' AND deleted=0";
            $result =$this->db->query($query,true," Error filling in additional detail fields: ");
            // Get the id and the name.
            $row = $this->db->fetchByAssoc($result);

            if($row != null)
            {
                $this->user_name = $row['user_name'];
            }
        }

    }

    function create_list_query(&$order_by, &$where)
    {
        $query = "SELECT id, first_name, last_name, user_name FROM users ";
        $where_auto = "deleted=0";

        if($where != "") {
                    $query .= "where $where AND ".$where_auto;
        } else {
                    $query .= "where ".$where_auto;
        }

        $query .= " ORDER BY last_name, first_name";

        return $query;
    }
}



?>
