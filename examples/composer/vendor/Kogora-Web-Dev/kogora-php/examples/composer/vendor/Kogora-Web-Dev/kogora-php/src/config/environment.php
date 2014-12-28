<? namespace K\Config;
/**
	 * URL: http://www.yiiframework.com/wiki/73/use-different-environments-development-production-etc-in-your-app-with-easy-environment-class/
	 * This class helps you to config your Yii application
	 * environment.
	 * Any comments please post a message in the forum
	 * Enjoy it!
	 *
	 * @name Environment
	 * @author Fernando Torres | Marciano Studio
	 * @version 1.0
	 */
 
	class Environment {
 
		const DEVELOPMENT = 100;
		const TEST        = 200;
		const STAGE       = 300;
		const PRODUCTION  = 400;
 
		private $_mode = 0;
		private $_debug;
		private $_trace_level;
		private $_config;
 
 
		/**
		 * Returns the debug mode
		 * @return Bool
		 */
		public function getDebug() {
			return $this->_debug;
		}
 
		/**
		 * Returns the trace level for YII_TRACE_LEVEL
		 * @return int
		 */
		public function getTraceLevel() {
			return $this->_trace_level;
		}
 
		/**
		 * Returns the configuration array depending on the mode
		 * you choose
		 * @return array
		 */
		public function getConfig() {
			return $this->_config;
		}
		/**
		 * Pretty print the config
		 * @ array
		 */
		public function printConfig() {
			pprint($this->_config);
		}
 
 
		/**
		 * Initilizes the Environment class with the given mode
		 * @param constant $mode
		 */
		function __construct($mode) {
			$this->_mode = $mode;
			$this->setConfig();
		}
 
		/**
		 * Sets the configuration for the choosen environment
		 * @param constant $mode
		 */
		private function setConfig() {
			switch($this->_mode) {
				case self::DEVELOPMENT:
					$this->_config      = array_merge_recursive ($this->_main(), $this->_development());
					$this->_debug       = TRUE;
					$this->_trace_level = 3;
					break;
				case self::TEST:
					$this->_config      = array_merge_recursive ($this->_main(), $this->_test());
					$this->_debug       = FALSE;
					$this->_trace_level = 0;
					break;
				case self::STAGE:
					$this->_config      = array_merge_recursive ($this->_main(), $this->_stage());
					$this->_debug       = TRUE;
					$this->_trace_level = 0;
					break;
				case self::PRODUCTION:
					$this->_config      = array_merge_recursive ($this->_main(), $this->_production());
					$this->_debug       = FALSE;
					$this->_trace_level = 0;
					break;
				default:
					$this->_config      = $this->_main();
					$this->_debug       = TRUE;
					$this->_trace_level = 0;
					break;
			}
		}
 
 
		/**
		 * Main configuration
		 * This is the general configuration that uses all environments
		 */
		private function _main() {
			return array(
 
					// Base Path
					'basePath' => dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
 
					// Project Name
					'name' => 'Project name',
 
					// Preloading 'log' component
					'preload'=>array('log'),
 
					// autoloading model and component classes
					'import' => array(
							'application.models.*',
							'application.components.*',
					),
 
					// Application components
					'components' => array(
							'user' => array(
							// enable cookie-based authentication
									'allowAutoLogin'=>true
							),
 
							// Error Handler
							'errorHandler'=>array(
										'errorAction'=>'site/error',
							 ),
 
							// URLs in path-format
							'urlManager'=>array(
									'urlFormat'=>'path',
									'rules'=>array(
											'<controller:\w+>/<id:\d+>'=>'<controller>/view',
											'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
											'<controller:\w+>/<action:\w+>'=>'<controller>/<action>'
									),
							),
					),
 
					// Application-level parameters
					'params'=>array(
							'adminEmail'=>'admin@example.com',
							'environment'=> $this->_mode
					)
			);
		}
 
 
		/**
		 * Development configuration
		 * Usage:
		 * - Local website
		 * - Local DB
		 * - Show all details on each error.
		 * - Gii module enabled
		 */
		private function _development () {
 
			return array(
 
					// Modules
					'modules'=>array(
							'gii'=>array(
									'class'=>'system.gii.GiiModule',
									'password'=>'your password',
									'ipFilters'=>array(),
									'newFileMode'=>0666,
									'newDirMode'=>0777,
							),
					),
 
					// Application components
					'components' => array(
 
							// Database
							'db'=>array(
									'connectionString' => 'Your connection string to your local development server',
									'emulatePrepare' => false,
									'username' => 'admin',
									'password' => 'password',
									'charset' => 'utf8',
							),
 
							// Application Log
							'log'=>array(
									'class'=>'CLogRouter',
									'routes'=>array(
									// Save log messages on file
											array(
													'class'=>'CFileLogRoute',
													'levels'=>'error, warning,trace, info',
											),
											// Show log messages on web pages
											array(
													'class'=>'CWebLogRoute',
													'levels'=>'error, warning, trace, info',
											),
 
									),
							),
					),
			);
		}
 
 
		/**
		 * Test configuration
		 * Usage:
		 * - Local website
		 * - Local DB
		 * - Standard production error pages (404,500, etc.)
		 * @var array
		 */
		private function _test() {
			return array(
 
					// Application components
					'components' => array(
 
							// Database
							'db'=>array(
									'connectionString' => 'Your connection string to your local testing server',
									'emulatePrepare' => false,
									'username' => 'admin',
									'password' => 'password',
									'charset' => 'utf8',
							),
 
 
							// Fixture Manager for testing
							'fixture'=>array(
									'class'=>'system.test.CDbFixtureManager',
							),
 
							// Application Log
							'log'=>array(
									'class'=>'CLogRouter',
									'routes'=>array(
											array(
													'class'=>'CFileLogRoute',
													'levels'=>'error, warning,trace, info',
											),
 
											// Show log messages on web pages
											array(
													'class'=>'CWebLogRoute',
													'levels'=>'error, warning',
											),
									),
							),
					),
			);
		}
 
		/**
		 * Stage configuration
		 * Usage:
		 * - Online website
		 * - Production DB
		 * - All details on error
		 */
		private function _stage() {
			return array(
 
					// Application components
					'components' => array(
					// Database
							'db'=>array(
									'connectionString' => 'Your connection string to your production server',
									'emulatePrepare' => false,
									'username' => 'admin',
									'password' => 'password',
									'charset' => 'utf8',
							),
 
							// Application Log
							'log'=>array(
									'class'=>'CLogRouter',
									'routes'=>array(
											array(
													'class'=>'CFileLogRoute',
													'levels'=>'error, warning, trace, info',
											),
 
									),
							),
					),
			);
		}
 
		/**
		 * Production configuration
		 * Usage:
		 * - online website
		 * - Production DB
		 * - Standard production error pages (404,500, etc.)
		 */
		private function _production() {
			return array(
 
					// Application components
					'components' => array(
 
							// Database
							'db'=>array(
									'connectionString' => 'Your connection string to your production server',
									'emulatePrepare' => false,
									'username' => 'admin',
									'password' => 'password',
									'charset' => 'utf8',
							),
 
 
							// Application Log
							'log'=>array(
									'class'=>'CLogRouter',
									'routes'=>array(
											array(
													'class'=>'CFileLogRoute',
													'levels'=>'error, warning',
											),
 
											// Send errors via email to the system admin
											array(
													'class'=>'CEmailLogRoute',
													'levels'=>'error, warning',
													'emails'=>'admin@example.com',
											),
									),
							),
					),
			);
		}
	}// END Environment Class
?>