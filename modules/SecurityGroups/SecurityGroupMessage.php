<?PHP
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class SecurityGroupMessage extends Basic {
	var $new_schema = true;
	var $module_dir = 'SecurityGroups';
	var $object_name = 'SecurityGroupMessage';
	var $table_name = 'securitygroups_message';
	var $importable = false;

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


	var $additional_column_fields = Array();
	var $field_defs = array (
       'id'=>array('name' =>'id', 'type' =>'char', 'len'=>'36', 'default'=>'')
      , 'name'=>array('name' =>'name', 'type' =>'varchar', 'len'=>'255', )
      , 'date_entered'=>array ('name' => 'date_entered','type' => 'datetime')
      , 'date_modified'=>array ('name' => 'date_modified','type' => 'datetime')
      , 'modified_user_id'=>array('name' =>'modified_user_id', 'type' =>'char', 'len'=>'36',)
      , 'created_by'=>array('name' =>'created_by', 'type' =>'char', 'len'=>'36',)
      , 'description'=>array('name' =>'description', 'type' =>'text', 'len'=>'',)
      , 'deleted'=>array('name' =>'deleted', 'type' =>'bool', 'len'=>'1', 'default'=>'0', 'required'=>true)
      , 'securitygroup_id'=>array('name' =>'securitygroup_id', 'type' =>'char', 'len'=>'36',)
    );


	function __construct(){
		parent::__construct();
	}

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    function SecurityGroupMessage(){
        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code';
        if(isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        }
        else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct();
    }



	function get_list_view_data(){
		$data = parent::get_list_view_data();
		$delete = '';

		$group_owner = false;
		$securitygroup_name = "";
		if(empty($data['SECURITYGROUP_ID'])) {
			$securitygroup_name = "All";
		} else {
			require_once('modules/SecurityGroups/SecurityGroup.php');
			$securitygroup = new SecurityGroup();
			$securitygroup->retrieve($data['SECURITYGROUP_ID']);
			$securitygroup_name = $securitygroup->name;

			if($securitygroup->assigned_user_id == $GLOBALS['current_user']->id) {
				$group_owner = true;
			}
		}

		if(is_admin($GLOBALS['current_user']) || $data['CREATED_BY'] == $GLOBALS['current_user']->id || $group_owner) {
			$delete = SugarThemeRegistry::current()->getImage( 'delete_inline', 'width="12" height="12" border="0" align="absmiddle" style="vertical-align: bottom;" onclick=\'Message.deleteMessage("'. $data['ID'] . '", "{this.id}")\'',null,null,'.gif','');
		}

		$username = "";
		if(empty($data['CREATED_BY'])) {
			$username = "Unknown";
		} else {
			require_once('modules/Users/User.php');
			$user = new User();
			$user->retrieve($data['CREATED_BY']);
			$username = $user->user_name;
		}

		$data['NAME'] = $data['DESCRIPTION'];
		$data['NAME'] =  '<div class="list view" style="padding:5px;border:none;">' . html_entity_decode($data['NAME']);
        $data['NAME'] .= '<div class="byLineBox" style="padding-top: 2px"><span class="byLineLeft">'.$username.' ['.$securitygroup_name.']';
		$data['NAME'] .= '&nbsp;</span><span style="cursor: pointer;" class="byLineRight"> '.  $this->getTimeLapse($data['DATE_ENTERED']) . ' &nbsp;' .$delete. '</span></div>';
		return  $data ;
	}


	static function saveMessage($text, $securitygroup_id) {
		//if no security group id then must be admin. Otherwise, make sure the user is a member of the group
		global $current_user;
		if(empty($securitygroup_id) && !is_admin($current_user)) {
			return;
		} else if(empty($securitygroup_id)) {
			$securitygroup_id = null; //6.4.0
		}
		$message = new SecurityGroupMessage();
		if(empty($text)) return; // || !$feed->ACLAccess('save', true) )return;

		$text = strip_tags($text);
		$message->name = '';
		$message->description = $text;
		$message->securitygroup_id = $securitygroup_id;
		$message->save();
	}

	function getTimeLapse($startDate)
	{
		$startDate = $GLOBALS['timedate']->to_db($startDate);
		$start = array();
   		preg_match('/(\d+)\-(\d+)\-(\d+) (\d+)\:(\d+)\:(\d+)/', $startDate, $start);
		$end = gmdate('Y-m-d H:i:s');
    	$start_time = gmmktime($start[4],$start[5], $start[6], $start[2], $start[3], $start[1] );
		$seconds = time()- $start_time;
		$minutes =   $seconds/60;
		$seconds = $seconds % 60;
		$hours = floor( $minutes / 60);
		$minutes = $minutes % 60;
		$days = floor( $hours / 24);
		$hours = $hours % 24;
		$weeks = floor( $days / 7);
		$days = $days % 7;
		$result = '';
		if($weeks == 1){
			$result = translate('LBL_TIME_LAST_WEEK','SugarFeed').' ';
			return $result;
		}else if($weeks > 1){
			$result .= $weeks . ' '.translate('LBL_TIME_WEEKS','SugarFeed').' ';
			if($days > 0) {
                $result .= $days . ' '.translate('LBL_TIME_DAYS','SugarFeed').' ';
            }
		}else{
			if($days == 1){
				$result = translate('LBL_TIME_YESTERDAY','SugarFeed').' ';
				return $result;
			}else if($days > 1){
				$result .= $days . ' '. translate('LBL_TIME_DAYS','SugarFeed').' ';
			}else{
				if($hours == 1) {
                    $result .= $hours . ' '.translate('LBL_TIME_HOUR','SugarFeed').' ';
                } else {
                    $result .= $hours . ' '.translate('LBL_TIME_HOURS','SugarFeed').' ';
                }
				if($hours < 6){
					if($minutes == 1) {
                        $result .= $minutes . ' ' . translate('LBL_TIME_MINUTE','SugarFeed'). ' ';
                    } else {
                        $result .= $minutes . ' ' . translate('LBL_TIME_MINUTES','SugarFeed'). ' ';
                    }
				}
				if($hours == 0 && $minutes == 0) {
                    if($seconds == 1 ) {
                        $result = $seconds . ' ' . translate('LBL_TIME_SECOND','SugarFeed');
                    } else {
                        $result = $seconds . ' ' . translate('LBL_TIME_SECONDS','SugarFeed');
                    }
                }
			}
		}
		return $result . ' ' . translate('LBL_TIME_AGO','SugarFeed');



    }

	function bean_implements($interface){
		switch($interface){
			case 'ACL':return false;
		}
		return false;
	}

}
?>