<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
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
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/

/**
 * Log management
 * @api
 */
class LoggerManager
{
	//this the the current log level
	private $_level = 'fatal';

	//this is a list of different loggers that have been loaded
	protected static $_loggers = array();

	//this is the instance of the LoggerManager
	private static $_instance = NULL;

	//these are the mappings for levels to different log types
	private static $_logMapping = array(
		'default' => 'SugarLogger',
	);

	//these are the log level mappings anything with a lower value than your current log level will be logged
	private static $_levelMapping = array(
		'debug'      => 100,
		'info'       => 70,
		'warn'       => 50,
		'deprecated' => 40,
		'error'      => 25,
		'fatal'      => 10,
		'security'   => 5,
		'off'        => 0,
	);

	//only let the getLogger instantiate this object
	private function __construct()
	{
		$level = SugarConfig::getInstance()->get('logger.level', $this->_level);
		if (!empty($level))
			$this->setLevel($level);

		if ( empty(self::$_loggers) )
		    $this->_findAvailableLoggers();
	}

	/**
	 * Overloaded method that handles the logging requests.
	 *
	 * @param string $method
	 * @param string $message - also handles array as parameter, though that is deprecated.
	 */
 	public function __call(
 	    $method,
 	    $message
 	    )
 	{
        if ( !isset(self::$_levelMapping[$method]) )
            $method = $this->_level;
 		//if the method is a direct match to our level let's let it through this allows for custom levels
 		if($method == $this->_level
                //otherwise if we have a level mapping for the method and that level is less than or equal to the current level let's let it log
                || (!empty(self::$_levelMapping[$method])
                    && self::$_levelMapping[$this->_level] >= self::$_levelMapping[$method]) ) {
 			//now we get the logger type this allows for having a file logger an email logger, a firebug logger or any other logger you wish you can set different levels to log differently
 			$logger = (!empty(self::$_logMapping[$method])) ?
 			    self::$_logMapping[$method] : self::$_logMapping['default'];
 			//if we haven't instantiated that logger let's instantiate
 			if (!isset(self::$_loggers[$logger])) {
 			    self::$_loggers[$logger] = new $logger();
 			}
 			//tell the logger to log the message
 			self::$_loggers[$logger]->log($method, $message);
 		}
 	}

 	/**
 	 * Check if this log level will be producing any logging
 	 * @param string $method
 	 * @return boolean
 	 */
 	public function wouldLog($method)
 	{
 	    if ( !isset(self::$_levelMapping[$method]) )
 	    	$method = $this->_level;
 	    if($method == $this->_level
 	    		//otherwise if we have a level mapping for the method and that level is less than or equal to the current level let's let it log
 	    		|| (!empty(self::$_levelMapping[$method])
 	    				&& self::$_levelMapping[$this->_level] >= self::$_levelMapping[$method]) ) {
 	        return true;
 	    }
 	    return false;
 	}

	/**
     * Used for doing design-by-contract assertions in the code; when the condition fails we'll write
     * the message to the debug log
     *
     * @param string  $message
     * @param boolean $condition
     */
    public function assert(
        $message,
        $condition
        )
    {
        if ( !$condition )
            $this->__call('debug', $message);
	}

	/**
	 * Sets the logger to the level indicated
	 *
	 * @param string $name name of logger level to set it to
	 */
 	public function setLevel(
 	    $name
 	    )
 	{
        if ( isset(self::$_levelMapping[$name]) )
            $this->_level = $name;
 	}

 	/**
 	 * Returns a logger instance
 	 */
 	public static function getLogger()
	{
		if(!LoggerManager::$_instance){
			LoggerManager::$_instance = new LoggerManager();
		}
		return LoggerManager::$_instance;
	}

	/**
	 * Sets the logger to use a particular backend logger for the given level. Set level to 'default'
	 * to make it the default logger for the application
	 *
	 * @param string $level name of logger level to set it to
	 * @param string $logger name of logger class to use
	 */
	public static function setLogger(
 	    $level,
 	    $logger
 	    )
 	{
 	    self::$_logMapping[$level] = $logger;
 	}

 	/**
 	 * Finds all the available loggers in the application
 	 */
 	protected function _findAvailableLoggers()
 	{
 	    $locations = array('include/SugarLogger','custom/include/SugarLogger');
 	    foreach ( $locations as $location ) {
            if (sugar_is_dir($location) && $dir = opendir($location)) {
                while (($file = readdir($dir)) !== false) {
                    if ($file == ".."
                            || $file == "."
                            || $file == "LoggerTemplate.php"
                            || $file == "LoggerManager.php"
                            || !is_file("$location/$file")
                            )
                        continue;
                    require_once("$location/$file");
                    $loggerClass = basename($file, ".php");
                    if ( class_exists($loggerClass) && class_implements($loggerClass,'LoggerTemplate') )
                        self::$_loggers[$loggerClass] = new $loggerClass();
                }
            }
        }
 	}

 	public static function getAvailableLoggers()
 	{
 	    return array_keys(self::$_loggers);
 	}

 	public static function getLoggerLevels()
 	{
 	    $loggerLevels = self::$_levelMapping;
 	    foreach ( $loggerLevels as $key => $value )
 	        $loggerLevels[$key] = ucfirst($key);

 	    return $loggerLevels;
 	}
}
