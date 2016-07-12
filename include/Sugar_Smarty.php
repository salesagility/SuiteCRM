<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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


require_once('include/Smarty/Smarty.class.php');

if(!defined('SUGAR_SMARTY_DIR'))
{
	define('SUGAR_SMARTY_DIR', sugar_cached('smarty/'));
}

/**
 * Smarty wrapper for Sugar
 * @api
 */
class Sugar_Smarty extends Smarty
{
	public function __construct()
	{
        parent::__construct();
		if(!file_exists(SUGAR_SMARTY_DIR))mkdir_recursive(SUGAR_SMARTY_DIR, true);
		if(!file_exists(SUGAR_SMARTY_DIR . 'templates_c'))mkdir_recursive(SUGAR_SMARTY_DIR . 'templates_c', true);
		if(!file_exists(SUGAR_SMARTY_DIR . 'configs'))mkdir_recursive(SUGAR_SMARTY_DIR . 'configs', true);
		if(!file_exists(SUGAR_SMARTY_DIR . 'cache'))mkdir_recursive(SUGAR_SMARTY_DIR . 'cache', true);

		$this->template_dir = '.';
		$this->compile_dir = SUGAR_SMARTY_DIR . 'templates_c';
		$this->config_dir = SUGAR_SMARTY_DIR . 'configs';
		$this->cache_dir = SUGAR_SMARTY_DIR . 'cache';
		$this->request_use_auto_globals = true; // to disable Smarty from using long arrays

		if(file_exists('custom/include/Smarty/plugins'))
        {
			$plugins_dir[] = 'custom/include/Smarty/plugins';
        }
		$plugins_dir[] = 'include/Smarty/plugins';
		$this->plugins_dir = $plugins_dir;

		$this->assign("VERSION_MARK", getVersionedPath(''));
	}

	/**
	 * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
	 */
	public function Sugar_Smarty(){
		$deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code';
		if(isset($GLOBALS['log'])) {
			$GLOBALS['log']->deprecated($deprecatedMessage);
		}
		else {
			trigger_error($deprecatedMessage, E_USER_DEPRECATED);
		}
		self::__construct();
	}

	/**
	 * Override default _unlink method call to fix Bug 53010
	 *
	 * @param string $resource
     * @param integer $exp_time
     */
    function _unlink($resource, $exp_time = null)
    {
        if(file_exists($resource)) {
            return parent::_unlink($resource, $exp_time);
        }

        // file wasn't found, so it must be gone.
        return true;
    }

	/**
	 * executes & returns or displays the template results
	 *
	 * @param string $resource_name
	 * @param string $cache_id
	 * @param string $compile_id
	 * @param boolean $display
	 */
	function fetch($resource_name, $cache_id = null, $compile_id = null, $display = false)
	{
		global $current_user, $sugar_config;
		static $_cache_info = array();

		/// Try and fetch the tpl from the theme folder
		/// if the tpl exists in the theme folder then set the resource_name to the tpl in the theme folder.
		/// otherwise fall back to the default tpl
		$current_theme = SugarThemeRegistry::current();
		$theme_directory = $current_theme->dirName;
		if(strpos($resource_name, "themes".DIRECTORY_SEPARATOR.$theme_directory) === false) {
			$test_path = SUGAR_PATH.DIRECTORY_SEPARATOR."themes".DIRECTORY_SEPARATOR.$theme_directory.DIRECTORY_SEPARATOR.$resource_name;
			if(file_exists($test_path)) {
				$resource_name = "themes".DIRECTORY_SEPARATOR.$theme_directory.DIRECTORY_SEPARATOR.$resource_name;
			}
		}
		///

		$_smarty_old_error_level = $this->debugging ? error_reporting() : error_reporting(isset($this->error_reporting)
			? $this->error_reporting : error_reporting() & ~E_NOTICE);

		if (!$this->debugging && $this->debugging_ctrl == 'URL') {
			$_query_string = $this->request_use_auto_globals ? $_SERVER['QUERY_STRING'] : $GLOBALS['HTTP_SERVER_VARS']['QUERY_STRING'];
			if (@strstr($_query_string, $this->_smarty_debug_id)) {
				if (@strstr($_query_string, $this->_smarty_debug_id . '=on')) {
					// enable debugging for this browser session
					@setcookie('SMARTY_DEBUG', true);
					$this->debugging = true;
				} elseif (@strstr($_query_string, $this->_smarty_debug_id . '=off')) {
					// disable debugging for this browser session
					@setcookie('SMARTY_DEBUG', false);
					$this->debugging = false;
				} else {
					// enable debugging for this page
					$this->debugging = true;
				}
			} else {
				$this->debugging = (bool)($this->request_use_auto_globals ? @$_COOKIE['SMARTY_DEBUG'] : @$GLOBALS['HTTP_COOKIE_VARS']['SMARTY_DEBUG']);
			}
		}

		if ($this->debugging) {
			// capture time for debugging info
			$_params = array();
			require_once(SMARTY_CORE_DIR . 'core.get_microtime.php');
			$_debug_start_time = smarty_core_get_microtime($_params, $this);
			$this->_smarty_debug_info[] = array('type'      => 'template',
												'filename'  => $resource_name,
												'depth'     => 0);
			$_included_tpls_idx = count($this->_smarty_debug_info) - 1;
		}

		if (!isset($compile_id)) {
			$compile_id = $this->compile_id;
		}

		$this->_compile_id = $compile_id;
		$this->_inclusion_depth = 0;

		if ($this->caching) {
			// save old cache_info, initialize cache_info
			array_push($_cache_info, $this->_cache_info);
			$this->_cache_info = array();
			$_params = array(
				'tpl_file' => $resource_name,
				'cache_id' => $cache_id,
				'compile_id' => $compile_id,
				'results' => null
			);
			require_once(SMARTY_CORE_DIR . 'core.read_cache_file.php');
			if (smarty_core_read_cache_file($_params, $this)) {
				$_smarty_results = $_params['results'];
				if (!empty($this->_cache_info['insert_tags'])) {
					$_params = array('plugins' => $this->_cache_info['insert_tags']);
					require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
					smarty_core_load_plugins($_params, $this);
					$_params = array('results' => $_smarty_results);
					require_once(SMARTY_CORE_DIR . 'core.process_cached_inserts.php');
					$_smarty_results = smarty_core_process_cached_inserts($_params, $this);
				}
				if (!empty($this->_cache_info['cache_serials'])) {
					$_params = array('results' => $_smarty_results);
					require_once(SMARTY_CORE_DIR . 'core.process_compiled_include.php');
					$_smarty_results = smarty_core_process_compiled_include($_params, $this);
				}


				if ($display) {
					if ($this->debugging)
					{
						// capture time for debugging info
						$_params = array();
						require_once(SMARTY_CORE_DIR . 'core.get_microtime.php');
						$this->_smarty_debug_info[$_included_tpls_idx]['exec_time'] = smarty_core_get_microtime($_params, $this) - $_debug_start_time;
						require_once(SMARTY_CORE_DIR . 'core.display_debug_console.php');
						$_smarty_results .= smarty_core_display_debug_console($_params, $this);
					}
					if ($this->cache_modified_check) {
						$_server_vars = ($this->request_use_auto_globals) ? $_SERVER : $GLOBALS['HTTP_SERVER_VARS'];
						$_last_modified_date = @substr($_server_vars['HTTP_IF_MODIFIED_SINCE'], 0, strpos($_server_vars['HTTP_IF_MODIFIED_SINCE'], 'GMT') + 3);
						$_gmt_mtime = gmdate('D, d M Y H:i:s', $this->_cache_info['timestamp']).' GMT';
						if (@count($this->_cache_info['insert_tags']) == 0
							&& !$this->_cache_serials
							&& $_gmt_mtime == $_last_modified_date) {
							if (php_sapi_name()=='cgi')
								header('Status: 304 Not Modified');
							else
								header('HTTP/1.1 304 Not Modified');

						} else {
							header('Last-Modified: '.$_gmt_mtime);
							echo $_smarty_results;
						}
					} else {
						echo $_smarty_results;
					}
					error_reporting($_smarty_old_error_level);
					// restore initial cache_info
					$this->_cache_info = array_pop($_cache_info);
					return true;
				} else {
					error_reporting($_smarty_old_error_level);
					// restore initial cache_info
					$this->_cache_info = array_pop($_cache_info);
					return $_smarty_results;
				}
			} else {
				$this->_cache_info['template'][$resource_name] = true;
				if ($this->cache_modified_check && $display) {
					header('Last-Modified: '.gmdate('D, d M Y H:i:s', time()).' GMT');
				}
			}
		}

		// load filters that are marked as autoload
		if (count($this->autoload_filters)) {
			foreach ($this->autoload_filters as $_filter_type => $_filters) {
				foreach ($_filters as $_filter) {
					$this->load_filter($_filter_type, $_filter);
				}
			}
		}

		$_smarty_compile_path = $this->_get_compile_path($resource_name);

		// if we just need to display the results, don't perform output
		// buffering - for speed
		$_cache_including = $this->_cache_including;
		$this->_cache_including = false;
		if ($display && !$this->caching && count($this->_plugins['outputfilter']) == 0) {
			if ($this->_is_compiled($resource_name, $_smarty_compile_path)
				|| $this->_compile_resource($resource_name, $_smarty_compile_path))
			{
				include($_smarty_compile_path);
			}
		} else {
			ob_start();
			if ($this->_is_compiled($resource_name, $_smarty_compile_path)
				|| $this->_compile_resource($resource_name, $_smarty_compile_path))
			{
				include($_smarty_compile_path);
			}
			$_smarty_results = ob_get_contents();
			ob_end_clean();

			foreach ((array)$this->_plugins['outputfilter'] as $_output_filter) {
				$_smarty_results = call_user_func_array($_output_filter[0], array($_smarty_results, &$this));
			}
		}

		if ($this->caching) {
			$_params = array('tpl_file' => $resource_name,
							 'cache_id' => $cache_id,
							 'compile_id' => $compile_id,
							 'results' => $_smarty_results);
			require_once(SMARTY_CORE_DIR . 'core.write_cache_file.php');
			smarty_core_write_cache_file($_params, $this);
			require_once(SMARTY_CORE_DIR . 'core.process_cached_inserts.php');
			$_smarty_results = smarty_core_process_cached_inserts($_params, $this);

			if ($this->_cache_serials) {
				// strip nocache-tags from output
				$_smarty_results = preg_replace('!(\{/?nocache\:[0-9a-f]{32}#\d+\})!s'
					,''
					,$_smarty_results);
			}
			// restore initial cache_info
			$this->_cache_info = array_pop($_cache_info);
		}
		$this->_cache_including = $_cache_including;

		if ($display) {
			if (isset($_smarty_results)) { echo $_smarty_results; }
			if ($this->debugging) {
				// capture time for debugging info
				$_params = array();
				require_once(SMARTY_CORE_DIR . 'core.get_microtime.php');
				$this->_smarty_debug_info[$_included_tpls_idx]['exec_time'] = (smarty_core_get_microtime($_params, $this) - $_debug_start_time);
				require_once(SMARTY_CORE_DIR . 'core.display_debug_console.php');
				echo smarty_core_display_debug_console($_params, $this);
			}
			error_reporting($_smarty_old_error_level);
			return;
		} else {
			error_reporting($_smarty_old_error_level);
			if (isset($_smarty_results)) { return $_smarty_results; }
		}
	}


}
