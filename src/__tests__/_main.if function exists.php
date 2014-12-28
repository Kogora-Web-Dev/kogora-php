<?
/** 
 * Define Kogora directory constants
 */
define('KOGORA_DIR', dirname( __FILE__ ) . '/');

/** 
 * Define Kogora configuration
 */
if ( is_readable( KOGORA_DIR . 'config.php' ) ) {
	require KOGORA_DIR . 'config.php';
}else{
	require KOGORA_DIR . 'config.default.php';
}

/** 
 * Kogora exception
 * @todo 
 */
class KogoraException extends Exception
{

	// Redefine the exception
	public function __construct($caller, $message, $code = 0, Exception $previous = null) {

		// message
		$message = 'Kogora->'.$caller.'(): '.$message; 
		// send to parent
		parent::__construct($message, $code, $previous);
	}

	// custom string representation of object
	public function __toString() {
		return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	}

	public function customFunction() {
		echo "A custom function for this type of exception\n";
	}

}


/** 
 * Kogora error handler
 * @todo 
 */
function error_handler($level, $message, $file, $line, $context) {
	//Handle user errors, warnings, and notices ourself
	if($level === E_USER_ERROR || $level === E_USER_WARNING || $level === E_USER_NOTICE) {
		switch($level) {
			case E_USER_WARNING:
				$_level = 'Warning';
				break;
			case E_USER_NOTICE:
				$_level = 'Notice';
				break;
			default:
				$_level = 'Error';
				break;
			} 
		echo '<strong>Kogora '.$_level.':</strong> '.$message;
		return(true); //And prevent the PHP error handler from continuing
	}
	return(false); //Otherwise, use PHP's error handler
}

/** 
 * Kogora error function
 * @todo 
 */
function trigger_kogora_error($message, $level) {
	//Get the caller of the calling function and details about it
	$callee = next(debug_backtrace());
	//Trigger appropriate error
	trigger_error($message.' in <strong>'.$callee['file'].'</strong> on line <strong>'.$callee['line'].'</strong>', $level);
}

//Use our custom handler
set_error_handler('error_handler');



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

	/** 
	 * Vars
	 * @var array
	 */
	protected $_loaded = array();
	protected $_class = array();
	protected $_default_classes = array();
	protected $_default_files = array();

	/** 
	 * Objects
	 * @var obj 
	 */
	protected $debugger = NULL;
	protected $environment = NULL;
	protected $html = NULL;

	/**
	 * Construct
	 * @todo load firebug extension
	 * @param bool
	 * @param array
	 */
	public function __construct(){ 
		$this->_loaded = array(
			SELF::DEBUGGER => false,
			SELF::ENVIRONMENT => false,
			SELF::HTML => false,
			);
		$this->_class = array(
			SELF::DEBUGGER => 'Debugger',
			SELF::ENVIRONMENT => 'Environment',
			SELF::HTML => 'HTML',
			);
		// autoloaded default classes + files
		$this->_default_classes = array(
			SELF::DEBUGGER,
			SELF::ENVIRONMENT
			);
		$this->_default_files = array(
			);
	}
	/**
	 * Info about this package
	 */
	public function info(){
		echo '<br>';
		echo 'Some kogora info:';
		echo 'Loaded classes:<br>';
		$loaded = array(
			'Debugger' => $this->_loaded[SELF::DEBUGGER],
			'Environment' => $this->_loaded[SELF::ENVIRONMENT],
			'HTML' => $this->_loaded[SELF::HTML],
			);
		print_r($loaded);
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
			if(!$this->_loaded[$id]){
				$this->_loaded[$id] = true;
				require KOGORA_DIR.self::filepath($id);// direct loader
			}
		}
	}
	/**
	 * Autoload classes and files without construction
	 * @param const
	 */
	public function autoload($classes = false, $files = false){ 
		if($classes == false && self::$_default_classes){
			foreach(self::$_default_classes as $id){
				$this->load($id);
			}
		}
		if($files == false && self::$_default_files){
			foreach(self::$_default_files as $id){
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
		return $this->_load_class(self::HTML);
	}
	/**
	 * Load class
	 * @todo parameters
	 * @param const
	 * @return obj
	 */
	public function _load_class($id){
		// new
		if(!$this->_loaded[$id]){ // $this->html
			$this->_loaded[$id] = true;
			require KOGORA_DIR.self::filepath($id);
			switch($id) {
				case self::DEBUGGER:
					$this->debugger = new Kogora\DEBUGGER\DEBUGGER();
					return $this->debugger;
					break;
				case self::ENVIRONMENT:
					$this->environment = new Kogora\ENVIRONMENT\ENVIRONMENT();
					return $this->environment;
					break;
				case self::HTML:
					$this->html = new Kogora\HTML\HTML();
					return $this->html;
					break;
				} 
		// already loaded
		}else{ 
			trigger_kogora_error($this->_class[$id].' class already loaded.', E_USER_WARNING);
			// throw new KogoraException('HTML', 'HTML class already loaded.');
			// ErrorException($errstr, 0, $errno, $errfile, $errline);
			switch($id) {
				case self::DEBUGGER:
					return $this->debugger;
					break;
				case self::ENVIRONMENT:
					return $this->environment;
					break;
				case self::HTML:
					return $this->html;
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
 * Class shortcuts
 * @todo 
 */
if ( !function_exists( 'kdiv' ) ) {
	/**
	 * Alias of HTML::div()
	 *
	 * @return string
	 */
	function kdiv()
	{
		echo 'cool';
	}
}
?>