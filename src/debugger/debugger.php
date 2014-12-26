<? namespace Kogora\Debugger;
/** 
 * PRS4: http://www.php-fig.org/psr/psr-4/
 * Data functions such as pretty print array.
 *
 * @name data.inc
 * @author Eric Mugerwa
 * @version 1.0
 * @package Kogora
 * @link http://edu.kogora.com
 * @todo 
 * @uses pprint: pretty print array
 * @example data.inc.php
 */


/**
* Pretty print
* <code>
* <?php
* $a = array('1'=>'Hello', '2'=>'PHP', '3'=>'World');
* pprint($a);
* ?>
* </code>
* @name pprint
* @param array $arr
* @uses pretty print array
*/

class Debugger{


	protected static $_firstRun = true;

	/**
	 * Construct
	 * @todo load firebug extension
	 * @param bool
	 * @param array
	 */
	public function __construct($enabled = true, $options = NULL){
		if(!$enabled){
			// to disable all output
			\Kint::enabled(false);
		}
		// vendor dir
		$vendor_dir = dirname(dirname(dirname(dirname(dirname(__File__)))));
		// require kint
		require_once($vendor_dir.'/raveren/kint/Kint.class.php');

	}
	/**
	 * Enable debugging output
	 * @param bool
	 */
	public function enable_output($enable){
		\Kint::enabled($enable);
	}
	/**
	 * Print server information
	 */
	public function server(){
		\Kint::dump($_SERVER);
		/*
		\Kint::dump( $_SERVER );
		// or, even easier, use a shorthand:
		\d( $_SERVER );
		// or, to seize execution after dumping use dd();
		\dd( $_SERVER ); // same as d( $_SERVER ); die;
		*/
	}
	public static function enable($name = NULL){
		echo 'enabled firebug';
	}
	public static function stdout($str = NULL){
		echo 'output sent to stdout';
	}
	/**
	 * Pretty print array
	 * @param array
	 * @return bool
	 */
	public static function pprint($arr, $name = NULL){
		if($name){
			echo '<span class=debugger-title>'.$name.':</span>';
		}
		\Kint::dump($arr);
		return true;
		/*
		echo '<pre>';
			print_r($arr);
		echo '</pre>';
		*/
	}
	/**
	 * Append scripts and styles on __destruct
	 */
	public function __destruct() {
		print "Destroying Debugger\n";
		// echo '<script>alert(\'boo\')</script>';
		echo '<style>.debugger-title{clear: both; display: block; padding: 3px 5px; margin: 5px 0; font: bold 11px Arial; color: #FFF; background: #279C17; border-radius: 3px}</style>';
	}
}

?>