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

	protected $enabled = true;
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
			$this->enabled = false;
			// \Kint::enabled(false);
		}
		// vendor dir
		// $vendor_dir = dirname(dirname(dirname(dirname(dirname(__File__)))));
		// require kint
		require_once(KOGORA_VENDOR_DIR.'/raveren/kint/Kint.class.php');

	}
	/**
	 * Enable debugging output
	 * @param bool
	 */
	public function enable_output($enable){
		$this->enabled = $enable;
		// \Kint::enabled($enable);
	}
	/**
	 * Print server information
	 */
	public function server(){
		if($this->enabled){
			\Kint::dump($_SERVER);
			/*
			\Kint::dump( $_SERVER );
			// or, even easier, use a shorthand:
			\d( $_SERVER );
			// or, to seize execution after dumping use dd();
			\dd( $_SERVER ); // same as d( $_SERVER ); die;
			*/
		}
	}
	public static function enable($name = NULL){
		echo 'enabled firebug';
	}
	public static function stdout($str = NULL){
		echo 'output sent to stdout';
	}
	/**
	 * Dump pretty print array
	 * @param array
	 * @return bool
	 */
	public function debug(&$var, $name = NULL){
		if($this->enabled){
			// alert
			if($name){
				self::info($name);
			}
			// kint dump
			\Kint::dump($var);
			return true;
			/*
			echo '<pre>';
				print_r($arr);
			echo '</pre>';
			*/
		}
	}
	/**
	 * Info Alert
	 * @param string type e.g: info/alert
	 * @param string text
	 * @return bool
	 */
	public function info($text = ''){
		$this->_alert('info', $text);
	}
	/**
	 * Alert
	 * @param string type e.g: info/alert
	 * @param string text
	 * @return bool
	 */
	public function _alert($type, $text = ''){
		$class = ' debugger-'.$type;
		echo '<span class="debugger-alert'.$class.'">'.$text.'</span>';//'.$type.': 
	}
	/**
	 * Append scripts and styles on __destruct
	 * @source icons: https://www.iconfinder.com/icons/127891/alert_attention_bubble_chat_comment_comments_error_exclamation_message_talk_warning_icon#size=24
	 * @link base64 converter http://www.base64-image.de/
	 */
	public function __destruct() {
		if($this->enabled){
			// echo '<script>alert(\'boo\')</script>';
			echo '<style type="text/css">
			.debugger-alert{
				clear: both; 
				display: block; 
				min-height: 16px;
				overflow: hidden;
				padding: 7px 7px 3px 35px; 
				margin: 5px 0; 
				font: bold 12px "Courier New", Courier, monospace; 
				color: #FFF; 
				background-color: #279C17; 
				background-position: 5px 5px;
				background-repeat: no-repeat;
				border-radius: 3px
				}
			.debugger-info{
				border: 1px solid #3724AD;
				border-color: #3724AD;
				background-color: #6253C2;
				background-image: url(\'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABx0RVh0U29mdHdhcmUAQWRvYmUgRmlyZXdvcmtzIENTNui8sowAAAGISURBVDiNjZM/SxxRFMXP7piVBGXHQrAUwSYIfgALCQhphCCCWE4hCBLSBKsUNloJIaBfIEVilJVsZbMo/kMQEQY1ga10sTDIFruwwqz63s9ixzBrZp0cuMW799xz73uPI0BPwgPyRGEt9u4+H9aa+NGDC/jEwVquNgrUzkuEHPepgAtUYptDVPxTdkfHMUFAyHWjAvGTIzBBwHq2h+KX5ceUDygtyZM0qARc5vKqV691vbXzmBqU5AnYTpp+/vU7q20drGU6KX1bi5a29VzjbaXK/rsJVlOv2B+bpHxw+A+nrdXKwdUf7Y1NqKOvT29PjpQdeB1PbDX918Iil7mfSbejSeCudsN97QaA6u9iYjNAWtLfZ62Xy9ocHtHZ3Lyc9kzSx0jSjgDPhmrWGApDb1jRC36kXnI0NYMJ6o1aTACeAFlrfWsbqeMPH8l1dePPfqJ2UcJa2yp8QClAxhhX0oXjONni5yWlMxn1v5+WJBlj4lavSup1HKfyf2ZqRqyZnrdzA7F2fgDTdNacij4HhQAAAABJRU5ErkJggg==\');
				}
			</style>';
		}
	}
}

?>