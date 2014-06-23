<?php
/*********************************************************************************
 * This file is part of QuickCRM Mobile CE.
 * QuickCRM Mobile CE is a mobile client for SugarCRM
 * 
 * Author : NS-Team (http://www.quickcrm.fr/mobile)
 *
 * QuickCRM Mobile CE is licensed under GNU General Public License v3 (GPLv3) 
 * 
 * You can contact NS-Team at NS-Team - 55 Chemin de Mervilla - 31320 Auzeville - France
 * or via email at quickcrm@ns-team.fr
 * 
 ********************************************************************************/
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
 
class mobile_jsLanguage {
    
    /**
     * Creates javascript versions of language files
     */
    function mobile_jsLanguage() {
    }
    
    function getListOfLists($lst_mod) {
		global $beanFiles, $beanList;
		require_once('include/utils.php');

		$list = array();
		
		foreach($lst_mod as $key=>$moduleName){
			require_once($beanFiles[$beanList[$moduleName]]);
			$nodeModule = new $beanList[$moduleName];
			foreach($nodeModule->field_name_map as $field_name => $field_defs)
			{
				if(($field_defs['type'] == 'enum')||($field_defs['type'] == 'multienum')||($field_defs['type'] == 'dynamicenum')
					&& ($field_defs['source'] != 'non-db')
				)
				{
					if (!in_array ( $field_defs['options'] , $list )) $list[]= $field_defs['options'];
				}
			}
		}
		return $list;
	}
	
    function createAppStringsCache($lang = 'en_us') {
		global $sugar_config;
		$lst_mod=array('Accounts','Contacts','Opportunities','Leads','Calls','Meetings','Cases','Project','ProjectTask','Tasks','Notes');
		$required_list = $this->getListOfLists($lst_mod); // List of application list strings used in the application (enums)

        $app_strings = return_application_language($lang);
        $all_app_list_strings = return_app_list_strings_language($lang);
		$app_list_strings= array();

		foreach($lst_mod as $key=>$lst){
			$app_list_strings["moduleList"][$lst]= $all_app_list_strings["moduleList"][$lst];
			$app_list_strings["moduleListSingular"][$lst]= isset($all_app_list_strings["moduleListSingular"][$lst])?$all_app_list_strings["moduleListSingular"][$lst]:$all_app_list_strings["moduleList"][$lst];
		}
		$app_list_strings["parent_type_display"]=$all_app_list_strings["parent_type_display"];
		$app_list_strings["duration_intervals"]=$all_app_list_strings["duration_intervals"];
		$app_list_strings["moduleList"]["SavedSearches"]= $all_app_list_strings["moduleList"]["SavedSearch"];
		// date_range_search_dom in not defined until 6.2
		$app_list_strings["date_search"]= isset($all_app_list_strings["date_range_search_dom"])?$all_app_list_strings["date_range_search_dom"]:$all_app_list_strings["kbdocument_date_filter_options"];
		$app_list_strings["date_search"]['today']=$app_strings['LBL_TODAY'];
		foreach($required_list as $lst){
			$app_list_strings[$lst]= $all_app_list_strings[$lst];
		}
		
		$json = getJSONobj();
        $app_list_strings_encoded = str_replace('\\\\',"\/",preg_replace("/'/","&#039;",$json->encode($app_list_strings)));
        
		$SS_mod_strings = return_module_language($lang, "SavedSearch");
		$ADM_mod_strings = return_module_language($lang, "Administration");
        $str = <<<EOQ
var RES_CREATE='{$app_strings['LBL_CREATE_BUTTON_LABEL']}',RES_LIST='{$app_strings['LBL_LIST']}',RES_ADD_TO_HOME='{$app_strings['LBL_MARK_AS_FAVORITES']}',RES_REM_FROM_HOME='{$app_strings['LBL_REMOVE_FROM_FAVORITES']}',RES_RECORD_ERROR='{$app_strings['ERROR_NO_RECORD']}',RES_LAST_VIEWED='{$app_strings['LBL_LAST_VIEWED']}', RES_DELETE_CONFIRMATION='{$app_strings['NTC_DELETE_CONFIRMATION']}', RES_DEL_LABEL='{$app_strings['LBL_DELETE_BUTTON_LABEL']}', RES_NEXT_LABEL='{$app_strings['LNK_LIST_NEXT']}', RES_PREVIOUS_LABEL='{$app_strings['LNK_LIST_PREVIOUS']}';
var RES_ASC='{$SS_mod_strings["LBL_ASCENDING"]}',RES_DESC='{$SS_mod_strings["LBL_DESCENDING"]}',RES_HOME_LABEL='{$all_app_list_strings["moduleList"]["Home"]}',RES_SYNC='{$all_app_list_strings["moduleList"]["Sync"]}',RES_SAVEDSEARCH='{$all_app_list_strings["moduleList"]["SavedSearch"]}',RES_SAVESEARCH='{$SS_mod_strings["LBL_SAVE_SEARCH_AS"]}',RES_DISABLED='{$ADM_mod_strings["LBL_DISABLED"]}';
var sugar_app_list_strings = $app_list_strings_encoded;
EOQ;
		$SS_mod_strings = null;
		$ADM_mod_strings = null;
		$all_app_list_strings = null;
		$app_array=array('LBL_CREATE_BUTTON_LABEL',
			'LBL_EDIT_BUTTON',
			'LBL_LIST',
			'LBL_SEARCH_BUTTON_LABEL',
			'LBL_CURRENT_USER_FILTER',// => 'My Items:',
			'LBL_BACK',
			'LBL_SAVE_BUTTON_LABEL',
			'LBL_CANCEL_BUTTON_LABEL',
			'LBL_MARK_AS_FAVORITES',
			'LBL_REMOVE_FROM_FAVORITES',
			'NTC_DELETE_CONFIRMATION',
			'LBL_DELETE_BUTTON_LABEL',
			'ERROR_NO_RECORD',
			'LBL_LAST_VIEWED',
			'LNK_LIST_NEXT',
			'LNK_LIST_PREVIOUS',
			'LBL_LINK_SELECT',
			'LBL_LIST_USER_NAME',
			'NTC_LOGIN_MESSAGE', //'Please enter your user name and password.'
//			'LBL_LOGOUT',
			'ERR_INVALID_EMAIL_ADDRESS',
			'LBL_ASSIGNED_TO',
			'LBL_CLEAR_BUTTON_LABEL',
			'LBL_DURATION_DAYS',
			'LBL_CLOSE_AND_CREATE_BUTTON_TITLE', // TO REMOVE WHEN APPS ARE UPDATED
			'LBL_CLOSE_AND_CREATE_BUTTON_LABEL',
			'LBL_CLOSE_BUTTON_TITLE', // TO REMOVE WHEN APPS ARE UPDATED
			'LBL_CLOSE_BUTTON_LABEL',
			'LBL_LISTVIEW_ALL',
			'LBL_LISTVIEW_NONE',
			'LBL_SAVED',
			'LBL_PRIMARY_ADDRESS',
			'LBL_BILLING_ADDRESS',
			'LBL_ALT_ADDRESS',
			'LBL_SHIPPING_ADDRESS',
			'LBL_DUPLICATE_BUTTON',
			'MSG_SHOW_DUPLICATES',
		);
		$str_app_array=array();
		foreach($app_array as $key){
			$str_app_array[$key] = str_replace('"','\\"',isset($app_strings[$key])?$app_strings[$key]:$key);
		}
		$app_strings_encoded = $json->encode($str_app_array);
		$str .= "var sugar_app_strings = $app_strings_encoded;";
        
		require_once('modules/Administration/Administration.php');
		$administration = new Administration();
		$administration->saveSetting('QuickCRM', $lang, base64_encode($str));
		$in_file=(strlen ($str) > 49000?'1':'0');
		$administration->saveSetting('QuickCRM', $lang.'f', $in_file);
		
//		if ($sugar_config['sugar_version']<'6.3'){
			$saveDir = realpath(dirname(__FILE__).'/../../../mobile/fielddefs/');
			if($fh = @fopen($saveDir . '/' .$lang . '.js', "w")){
				fputs($fh, $str);
				fclose($fh);
			}
			else
			{
					// die();
			}
//		}
    }
    
    function createDefaultLocalization() {
		global $sugar_config,$moduleList;
		global $current_language;
		
		$json = getJSONobj();

		require_once('modules/Administration/Administration.php');
		$administration = new Administration();
		$administration->retrieveSettings();
		
        $str = '<?php $default_language = "'.$sugar_config['default_language'].'";';
        $str .= '$time = "'.time().'";';
        $str .= ' ?>';
        
//		if ($sugar_config['sugar_version']<'6.3'){
			$saveDir = realpath(dirname(__FILE__).'/../../../mobile/fielddefs/');
			if($fh = fopen($saveDir .'/' . 'localization.php', "w")){
				fputs($fh, $str);
				fclose($fh);
			}
			else
			{
				$mod_strings = return_module_language($current_language, "Administration");
				echo $mod_strings['LBL_ERR_DIR_MSG'].$saveDir;
			}
//		}
		
		$str = "var mobile_edition = 'CE',Q_API='2.3', app_support=true, module_access={}, sugar_mod_fields={};";
        $str .= 'var js_plugins=[],html_plugins=[];';
        $str .= 'var sugar_version = "'.$sugar_config['sugar_version'].'";';
        $str .= 'var sugar_name = "'.$administration->settings['system_name'].'";';
        $str .= 'var default_language = "'.$sugar_config['default_language'].'";';
		$lst_lang=get_languages();
        $str .= 'var sugar_languages = '.$json->encode($lst_lang).';';
        $str .= 'var default_currency_name = "'.$sugar_config['default_currency_name'].'";';
        $str .= 'var default_currency_symbol = "'.$sugar_config['default_currency_symbol'].'";';
        $str .= 'var default_date_format = "'.$sugar_config['default_date_format'].'";';
        $str .= 'var db_type = "'.$sugar_config['dbconfig']['db_type'].'",';
		
		if (in_array ('jjwg_Maps',$moduleList)){
			$str .= ' jjwg_installed = true,';
			if (isset($administration->settings['jjwg_map_default_unit_type'])){
				$jjwg_def_unit=$administration->settings['jjwg_map_default_unit_type'];
			}
			else {
				$jjwg_def_unit='miles';
			}
			$str .= 'jjwg_def_unit="'.$jjwg_def_unit.'",';
			if (isset($administration->settings['jjwg_valid_geocode_modules'])){
				$jjwg_modules=$administration->settings['jjwg_valid_geocode_modules'];
			}
			else {
				$jjwg_modules='';
			}
			$str .= 'jjwg_modules="'.$jjwg_modules.'",';
			if (isset($administration->settings['map_default_center_latitude'])){
				$jjwg_c_lat=$administration->settings['map_default_center_latitude'];
				$jjwg_c_lng=$administration->settings['map_default_center_longitude'];
			}
			else {
				$jjwg_c_lat=39.5;
				$jjwg_c_lng=-99.5;
			}
			$str .= 'jjwg_c_lat='.$jjwg_c_lat.',' . 'jjwg_c_lng='.$jjwg_c_lng.',';
			
		}
		else {
			$str .= ' jjwg_installed = false,jjwg_def_unit="",';
		}
		$str .= ' securitysuite = '.(in_array ('SecurityGroups',$moduleList)?'true':'false').',';
        $str .= ' offline_max_days = 0;';
        $str .= 'var quickcrm_upd_time = "'.time().'";';
		$str .= "var CustomHTML=".(file_exists("custom/QuickCRM/home.html")?"true":"false").";";
		$str .= "var CustomJS=".(file_exists("custom/QuickCRM/custom.js")?"true":"false").";";


		$administration->saveSetting('QuickCRM', 'sugar_config', base64_encode($str));
		
			$saveDir = realpath(dirname(__FILE__).'/../../../mobile/');
        
			if($fh = @fopen($saveDir . '/config.js', "w")){
				fputs($fh, $str);
				fclose($fh);
			}
    }
    
	function createAllFiles(){
		$this->createDefaultLocalization();
		$lst_lang=get_languages();
		foreach($lst_lang as $language => $language_name){
			$this->createAppStringsCache($language);
		}
	}
}

function createMobileFiles(){
		function CheckAccess(){
			global $sugar_config;

			if (is_windows()){
				return true;
			}
			else {
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $sugar_config['site_url']."/custom/QuickCRM/rest.php");
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_NOBODY, true); 
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1");
				$res=curl_exec($ch);
				$err=curl_errno($ch);
				if (!$err) {
					$info = curl_getinfo($ch);
					$info = $info['http_code'];
					$err=($info=='403' || $info=='500');
				}

				curl_close($ch); 
				return (!$err);
			}
		}
		
	$mobile = new mobile_jsLanguage();
	$mobile->createAllFiles();
	return (CheckAccess());
}
