<? namespace Kogora\HTML;
require(dirname(__File__).'/_options.php');
require(dirname(__File__).'/_config.php');
require(dirname(__File__).'/_elements.php');
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
* HTML
* @name html.php
* @uses Writing html
*/

class HTML extends Options{
	/** 
	 * Constants
	 * @var const 
	 * @todo 
	 */
	const DOCTYPE = 'HTML5';

	/** 
	 * Vars
	 * @var array
	 */
	protected $csr = '';
	protected $_config = NULL;

	/**
	 * Construct
	 * @todo 
	 * @param mixed config jQuery, facebook,
	 */
	public function __construct(){ 
		$args = _func_args_to_array(func_get_args());
		// config: load get_methods
		$this->_config = new Config($args);
	}
	/**
	 * Get
	 * @todo 
	 * @param string
	 * @return object
	 */
	public function __get($field) {
		return $this->_get_method($field, array());
	}
	/**
	 * Set
	 * @todo 
	 * @param string
	 * @return object
	 */
	public function __set($field, $value) {
		print('setting:'.$field.'-'.$value);
		if($field == 'name') {
			// $this->username = $value;
		}
	}
	/**
	 * Return cursor
	 * @return string
	 */	
	public function __toString() {
		$s = $this->csr;
		return $s;
	}
	/**
	 * Config
	 * @return array
	 */
	public function config(){
		return $this->_config->data();
	}
	/**
	 * Enable 
	 * @param const option
	 */
	public function enable($option){
		if($this->_config->enable($option)){
			print('enabled option in html class: '.$option);
			var_dump($this->config());
		}
	}
	/**
	 * Pretty print array
	 * @todo 
	 * @param array
	 */
	public static function pprint($arr){
		echo '<pre>';
			print_r($arr);
		echo '</pre>';
	}
	/**
	 * cursor
	 * @todo 
	 */
	public static function cursor(){
		return $this->csr;
	}
	/**
	 * finish
	 * @todo 
	 */
	public function finish(){
		print($this->csr);
		$this->csr = '';
	}
	/**
	 * Header information
	 * @todo 
	 * @param bool revalidate
	 */
	public static function headers($revalidate = false){
		if($revalidate){
			header("Last-Modified: " . gmdate("D, j M Y H:i:s") . " GMT");
			header("Expires: " . gmdate("D, j M Y H:i:s", time()) . " GMT");
			header("Cache-Control: no-store, no-cache, must-revalidate"); 
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");  
		}
	}
	/**
	 * doc
	 * @todo 
	 * @param bool revalidate
	 */
	public function doc(){
		$args = func_get_args();
		// if($this->_config['facebook']){ 
		// 	array_push( array &$array ,$args);
		// }
		// array_push($args, array_keys($this->_config));
		// var_dump($args);
		// if(!$args){
			// $args = array_keys($this->_config);
		// }
		$args = array_merge($args, array_keys($this->_config));
		// var_dump($args);
		$doc = new Doc($args);
		return $doc;
	}
	/**
	 * Get shortcut method
	 * @param string method: div/p/br
	 * @param mixed args: id, class, etc.
	 * @todo 
	 */
	public function _get_method($method, $args) {
		$obj = NULL;  
		// normal elements
		if($this->_config->is_method($method, 'normal')){
			$obj = new NormalElement($method, $this->_config, $args);
		// void elements
		}elseif($this->_config->is_method($method, 'void')){
			// if br
			if($method == 'br'){
				$s = LoopedVoidElement('br', $this->config, $args);
				$this->csr .= $s;
			// default
			}else{		
				$obj = new VoidElement($method, $this->_config); 
				$s .= $obj->__toString();
				$this->csr .= $s;
			}
			return $s;
		}
		if($obj){
			return $obj;
		}else{
			throw new \KogoraException('unknown method: '. $method);
			return false;
		}
	}
	/**
	 * Call (undefined): element shortcuts
	 * @param mixed args: id, class, etc.
	 * @todo 
	 */
	public function __call($method, $args) {
		return $this->_get_method($method, $args);
	}
}


/**
 * @name Looped Void Element
 * @desc Return multiple void elements
 * @param string tag
 * @param mixed args 
 * @return string
 */
function LoopedVoidElement($tag, $config, $args = NULL, $depth){
	if($args){
		$n = $args[0];
	}else{
		$n = 1;
	}
	$s = '';
	for ($x = 1; $x <= $n; $x++) {
		$obj = new VoidElement($tag, $config, $args, $depth); 
		$s .= $obj->__toString();
		$s .= '';
	}
	return $s;
}
?>