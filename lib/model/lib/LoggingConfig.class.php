<?php 
	/**
	* Description of LoggingConfig
	* Library Class to handle configurations for Logging
	*/
	class LoggingConfig
	{
		/**
		* @var Object
		*/
		private static $instance = null;

		/**
		*	@var array
		*	'module name' => its configs
		*/
		private $arrConfig = array(
			// 'logging' => 1, logging is on for this module
			LoggingEnums::JSADMIN => array(
				LoggingEnums::LOGGING => false,
				LoggingEnums::LEVEL => LoggingEnums::LOG_DEBUG,
				LoggingEnums::DIRECTORY => true,
				LoggingEnums::STACKTRACE => false
				),
			LoggingEnums::SEO => array(
				LoggingEnums::LOGGING => true,
				LoggingEnums::LEVEL => LoggingEnums::LOG_DEBUG,
				LoggingEnums::DIRECTORY => true,
				LoggingEnums::STACKTRACE => false
				),
			LoggingEnums::EX500OR404 => array(
				LoggingEnums::LOGGING => true,
				LoggingEnums::LEVEL => LoggingEnums::LOG_ERROR,
				LoggingEnums::DIRECTORY => true,
				LoggingEnums::STACKTRACE => false
				),
			LoggingEnums::MYJS => array(
				LoggingEnums::LOGGING => true,
				LoggingEnums::LEVEL => LoggingEnums::LOG_INFO,
				LoggingEnums::DIRECTORY => false,
				LoggingEnums::STACKTRACE => false
				),
			LoggingEnums::HOMEPAGE => array(
				LoggingEnums::LOGGING => false,
				LoggingEnums::LEVEL => LoggingEnums::LOG_INFO,
				LoggingEnums::DIRECTORY => false,
				LoggingEnums::STACKTRACE => false
				),

			);

		/**
     	* Constructor function
     	*/
		private function __construct() {}

		/**
		* __destruct
		*/
		private function __destruct() 
		{
			self::$instance = null;
		}

		/**
		* To Stop clone of this class object
		*/
		private function __clone() {}

		/**
		* To stop unserialize for this class object
		*/
		private function __wakeup() {}

		/**
		* Get Instance
		* @return Object of LoggingConfig
		*/
		public static function getInstance()
		{
		    if (null === self::$instance) {
		        $className =  __CLASS__;
		        self::$instance = new $className;
		    }
		    return self::$instance;
		}

		/**
		* @return log status of module
		*/
		public function logStatus($module)
		{
			if(!array_key_exists($module, $this->arrConfig)){
				// module not in config
				return true;
			}
			return $this->arrConfig[$module][LoggingEnums::LOGGING];
		}

		/**
		* @return directory status of module
		*/
		public function dirStatus($module)
		{
			if(!array_key_exists($module, $this->arrConfig)){
				return false;
			}
			return LoggingEnums::CONFIG_ON ? $this->arrConfig[$module][LoggingEnums::DIRECTORY] : false;
		}

		/**
		* @return stack trace status of module
		*/
		public function traceStatus($module)
		{
			if($this->debugStatus($module)){
				return true;
			}
			if(!array_key_exists($module, $this->arrConfig)){
				return LoggingEnums::LOG_TRACE;
			}
			return LoggingEnums::CONFIG_ON ? $this->arrConfig[$module][LoggingEnums::STACKTRACE] : LoggingEnums::LOG_TRACE;
		}

		/**
		* @return get log level defined for the module
		*/
		public function getLogLevel($module)
		{
			if(!array_key_exists($module, $this->arrConfig)){
				// 	By Default for Exception
				return LoggingEnums::LOG_ERROR;
			}
			return LoggingEnums::CONFIG_ON ? $this->arrConfig[$module][LoggingEnums::LEVEL] : LoggingEnums::LOG_ERROR;
		}

		/**
		 * Get if debug is on for the module or not
		 * @param String $module A module name
		 * @return bool
		 */
		public function debugStatus($module)
		{
			if(LoggingEnums::LOG_LEVEL == LoggingEnums::LOG_DEBUG){
				return true;
			}
			if(LoggingEnums::CONFIG_ON && $this->arrConfig[$module][LoggingEnums::LEVEL] == LoggingEnums::LOG_DEBUG)
			{
				return true;
			}
			return false;
		}
	}
?>