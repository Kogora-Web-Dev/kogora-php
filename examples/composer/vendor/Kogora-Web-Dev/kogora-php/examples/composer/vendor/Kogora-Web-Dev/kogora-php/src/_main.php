<?

/** 
 * Define Kogora directory constants.
 */
define('KOGORA_DIR', dirname( __FILE__ ) . '/');
define('KOGORA_DIR_COMPOSER', dirname(__FILE__).'/composer/vendor';

/** 
 * Define Kogora configuration.
 */
if ( is_readable( KOGORA_DIR . 'config.php' ) ) {
	require KOGORA_DIR . 'config.php';
}else{
	require KOGORA_DIR . 'config.default.php';
}

/** 
 * Kogora class.
 * @todo 
 */
class Kogora
{
	/** 
	 * Constants
	 * @todo 
	 */
	const VERSION = '1.0.0';

	/**
	 * Info about this package
	 */
	public function info(){
		echo 'Some kogora info';
	}
	/**
	 * Composer autoloader
	 */
	public static function composer_autoload(){
		$loader = require(KOGORA_DIR_COMPOSER.'/autoload.php');// composer loader
	}
	/**
	 * Require file directly from package
	 * @param string
	 */
	public static function direct_load($path){
		$loader = require($path);// direct loader
	}
}


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