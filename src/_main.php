<?
/** 
 * Define Kogora directory constants
 */
define('KOGORA_DIR', dirname( __FILE__ ) . '/');
define('KOGORA_VENDOR_DIR', dirname(dirname(dirname(dirname(__File__)))));

/** 
 * Define Kogora configuration
 */
if ( is_readable( KOGORA_DIR . 'config.php' ) ) {
	require KOGORA_DIR . 'config.php';
}else{
	require KOGORA_DIR . 'config.default.php';
}


/** 
 * Require exceptions
 */
require KOGORA_DIR . '_exceptions.php';


/** 
 * Kogora config class
 * @todo 
 */
class KogoraConfig extends StdClass
{

	/**
	 * Construct
	 * @todo 
	 */
	public function __construct(){  
	}
	public function init(){
		// server
		$this->server = array(
			'remote_address' => $_SERVER['REMOTE_ADDR'],
			);
		if($this->server['remote_address']=='127.0.0.1' || $this->server['remote_address']=='::1'){ // ::1 for IPV6
			$this->server['environment'] = 'local';
		}else{
			// sandbox
			// production
			$this->server['environment'] = 'production';
		}
		$this->server['document_root'] = $_SERVER['DOCUMENT_ROOT'];
		$this->location = __DIR__;
		$this->project_root = dirname(dirname(KOGORA_VENDOR_DIR));
	}
	public function fetch(){ 
		$info = array();
		$info['loaded'] = $this->get_loaded();
		$info['server'] = $this->server;
		$info['location'] = $this->location;
		$info['project_root'] = $this->project_root;
		return $info;	
	}
	/**
	 * Return loaded classes and functions with human friendly keys
	 * @return array
	 */
	public function get_loaded(){
		$d = array();
		foreach($this->loaded as $key => $value){
			$d[$this->class[$key]] = $this->loaded[$key];
		}
		return $d;
	}
}

/** 
 * Kogora class
 * @todo 
 */
class Kogora
{
	/** 
	 * Constants
	 * @var const 
	 * @todo 
	 */
	const VERSION = '1.0.0';
	const DEBUGGER = 1;
	const ENVIRONMENT = 2;
	const HTML = 3;
	const VISITOR = 4;

	/** 
	 * Vars
	 * @var array
	 */
	protected $config = array(); 
	protected $_default_classes = array();
	protected $_default_files = array();

	/** 
	 * Objects
	 * @var obj 
	 */
	protected $_debugger = NULL;
	protected $_environment = NULL;
	protected $_html = NULl;

	/**
	 * Construct
	 * @todo load firebug extension
	 */
	public function __construct(){ 
		// config
		$this->config = new KogoraConfig();
		$this->config->loaded = array(
			SELF::DEBUGGER => false,
			SELF::ENVIRONMENT => false,
			SELF::HTML => false,
			SELF::VISITOR => false,
			);
		$this->config->class = array(
			SELF::DEBUGGER => 'Debugger',
			SELF::ENVIRONMENT => 'Environment',
			SELF::HTML => 'HTML',
			SELF::VISITOR => 'Visitor',
			);
		$this->config->init();
		// autoloaded default classes + files
		$this->_default_classes = array(
			SELF::DEBUGGER,
			SELF::ENVIRONMENT
			);
		$this->_default_files = array(
			);
	}
	/**
	 * Get
	 * @todo 
	 * @param string
	 * @return object
	 */
	public function __get($field) { 
		switch($field) {
			case 'Debugger':
				return $this->_load_class(self::DEBUGGER);
				break;
			case 'Environment':
				return $this->_load_class(self::ENVIRONMENT);
				break;
			case 'HTML':
				return $this->_load_class(self::HTML);
				break;
			case 'Visitor':
				return $this->_load_class(self::VISITOR);
				break;
			default:
				return NULL;
				break;
			} 
	}
	/**
	 * Info about this package
	 * @param mixed bool|array verbose
	 * @todo check for sandbox IP addresses listed in config.php
	 */
	public function info($verbose = true){
		// return
		$ret = array(
			'config' => true,
			'runtime object' => false,
			);
		if(is_array($verbose)){ 
			// set $ret array with verbose values 
			foreach($ret as $key => $value){
				if(array_key_exists($key, $verbose)){
					$ret[$key] = $verbose[$key];
				}
			}
			// set verbose to false
			$verbose = false;
		}
		// debugger
		if(!$this->_debugger){
			$this->Debugger();
		}
		// config
		$this->_debugger->info('config'); 
		$config = $this->config->fetch();
		!Kint::dump($config);
		// Kint::trace();
		// runtime object
		if($verbose == true || $ret['runtime object'] == true){
			$this->_debugger->info('runtime object'); 
			!Kint::dump($this);
		}
	}
	/**
	 * Return file path
	 * @return string path
	 */
	public function filepath($id){
		switch($id) {
			case self::DEBUGGER:
				return 'debugger/debugger.php';
				break;
			case self::ENVIRONMENT:
				return 'config/environment.php';
				break;
			case self::HTML:
				return 'html/html.php';
				break;
			case self::VISITOR:
				return 'user/visitor.php';
				break;
			default:
				return NULL;
				break;
			} 
	}
	/**
	 * Require file directly from package
	 * @param const
	 */
	public function load($id){ 
		if(!$id){
			throw new KogoraException('load', '$name parameter must be a const of Kogora not: '.$name.'.');
		}else{
			if(!$this->is_loaded($id)){
				$this->config->loaded[$id] = true;
				require KOGORA_DIR.self::filepath($id);
			} 
		}
	}
	/**
	 * Is class or function loaded
	 * @return bool
	 */
	public function is_loaded($id){ 
		return $this->config->loaded[$id];
	}
	/**
	 * Autoload classes and files without construction
	 * @param const
	 */
	public function autoload($classes = false, $files = false){ 
		if($classes == false && $this->_default_classes){
			foreach($this->_default_classes as $id){
				$this->load($id);
			}
		}
		if($files == false && $this->_default_files){
			foreach($this->_default_files as $id){
				$this->load($id);
			}
		}
	}
	/**
	 * HTML shortcut
	 * @todo parameters
	 * @return class HTML
	 */
	public function HTML(){
		$args = func_get_args();
		return $this->_load_class(self::HTML, $args);
	}
	/**
	 * Debugger shortcut
	 * @todo parameters
	 * @return class HTML
	 */
	public function Debugger(){
		return $this->_load_class(self::DEBUGGER);
	}
	/**
	 * Debugger shortcut
	 * @todo parameters
	 * @param bool verbose
	 * @return class HTML
	 */
	public function Visitor(){
		$args = func_get_args(); 
		return $this->_load_class(self::VISITOR, $args);
	}
	/**
	 * Load class
	 * @todo parameters
	 * @param const
	 * @return obj
	 */
	public function _load_class($id, $args = NULL){
		// new
		if(!$this->config->loaded[$id]){ // $this->html
			$this->config->loaded[$id] = true;
			require KOGORA_DIR.self::filepath($id);
			// args
			if($args){
				$numargs = count($args);
			}else{
				$numargs = 0;
			}
			// switch
			switch($id) {
				case self::DEBUGGER:
					$this->_debugger = new Kogora\DEBUGGER\DEBUGGER();
					return $this->_debugger;
					break;
				case self::ENVIRONMENT:
					$this->_environment = new Kogora\ENVIRONMENT\ENVIRONMENT();
					return $this->_environment;
					break;
				case self::HTML:
					$this->_html = new Kogora\HTML\HTML($args);
					return $this->_html;
				case self::VISITOR:
					switch($numargs) {
						case 1: // verbose
							$this->_visitor = new Kogora\USER\VISITOR($args[0]);
							break;
						default: // default
							$this->_visitor = new Kogora\USER\VISITOR();
							break;
					}
					return $this->_visitor;
					break;
				} 
		// already loaded
		}else{ 
			trigger_kogora_error($this->config->class[$id].' class already loaded, returned reference instead.', E_USER_WARNING);
			// throw new KogoraException('HTML', 'HTML class already loaded.');
			// ErrorException($errstr, 0, $errno, $errfile, $errline);
			switch($id) {
				case self::DEBUGGER:
					return $this->_debugger;
					break;
				case self::ENVIRONMENT:
					return $this->_environment;
					break;
				case self::HTML:
					return $this->_html;
					break;
				case self::VISITOR:
					return $this->_visitor;
					break;
				} 
		}
	}
}
/** 
 * Construct Kogora class
 * @todo 
 */
$K = new Kogora();


/** 
 * Class functions
 * @todo 
 */
if ( !function_exists( '_func_args_to_array' ) ) {
	/**
	 * Function args to array e.g: array('jQuery', 'foundation');
	 *
	 * @uses HTML::__construct()
	 * @return string
	 */
	function _func_args_to_array($args)
	{
		if($args){
			if(is_array($args[0])){
				$args = $args[0];
			}
		}
		return $args;
	}
}
?>