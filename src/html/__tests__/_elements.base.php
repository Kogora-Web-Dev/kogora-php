<? namespace Kogora\HTML\Base;
/** 
 * Base classes for HTML elements.
 *
 * @name _elements.base.php
 * @author Eric Mugerwa
 * @version 1.0
 * @package Kogora
 * @link http://edu.kogora.com
 * @todo 
 * @uses Class bases for HTML element objects
 * @example Visitor::get_info
 *  
 * Void elements
 *     area, base, br, col, embed, hr, img, input, keygen, link, meta, param, source, track, wbr
 * Raw text elements
 *     script, style
 * escapable raw text elements
 *     textarea, title
 * Foreign elements
 *     Elements from the MathML namespace and the SVG namespace.
 * Normal elements
 *     All other allowed HTML elements are normal elements. 
*/

/** 
 * Element Base class
 * @todo 
 */
abstract class ElementBase
{
	/** 
	 * Vars
	 * @var string tag
	 * @var string attributes
	 * @var string cursor
	 * @var string parameter
	 */	
	public $tag = 'head';
	protected $csr = '';
	protected $_p = '';
	protected $is_open = true;

	/**
	 * Construct
	 * @todo 
	 */
	public function __construct(){
		$this->csr = '<'.$this->tag;
	}
	/**
	 * Return cursor
	 * @var bool end_tag: don't auto end some tags (with a large scope for children) such as: body, article
	 * @return string
	 */	
	public function __toString() {
		$end_tag = true;
		// don't autoend some tags - if no children, otherwise always autoend tag
		if($this->tag == 'body'){
			if($this->num_children() < 1){
				$end_tag = false;
			}
		}
		$this->close($end_tag);
		$ret = $this->csr;
		$this->csr = '';
		return $ret;
	}
	/**
	 * Destroy
	 */
	public function __destruct() {
	}
}

/** 
 * Normal Element class
 * @todo 
 */
abstract class NormalElement extends ElementBase
{
	/** 
	 * Vars
	 * @var bool is_open
	 */	
	protected $_t = '';
	private $_child = array(
		'div' => NULL,
		'p' => NULL,
		'a' => NULL,
		'br' => NULL,
		);
	private $_get_methods = NULL;
	protected $is_ended = false;

	/**
	 * Construct
	 * @todo 
	 */
	public function __construct($args = NULL){
		parent::__construct();
		$count = count($args);
		// get methods
		$this->_get_methods = array_keys($this->_child);
		// args
		if($args){
			if($count > 0){
				$this->_p .= ' id="'.$args[0].'"';
			}
			if($count > 1){
				$this->_p .= ' class="'.$args[1].'"';
			}
		}
	}
	/**
	 * Call (undefined)
	 * @var array illegal parents: throw exception if illegal parent element for tag 
	 * @todo 
	 */
	public function __call($method, $args) {
		// echo "unknown method " . $method;
		// var_dump($args);
		if(in_array($method, $this->_get_methods)){
			// echo 'constructing child tag'; 
			$illegal_parents = array(); // illegal parents
			switch($method) {
				case 'br':
					$this->close(false);
					$br = new \Kogora\HTML\Br(); 
					$this->csr .= $br->__toString(); 
					return false;
					break;
				case 'p':
					$illegal_parents = array('p'); 
					if(in_array($this->tag, $illegal_parents)){
						throw new \KogoraException('p cannot be a child of '.$this->tag);
						// trigger_kogora_error('p cannot be a child of p', E_USER_ERROR);
					}
					$this->_child['p'] = new \Kogora\HTML\P($args);
					return $this->_child['p'];
					break;
				case 'div':
					$illegal_parents = array('p'); 
					if(in_array($this->tag, $illegal_parents)){
						throw new \KogoraException('div cannot be a child of '.$this->tag);
					}
					$this->_child['p'] = new \Kogora\HTML\P($args);
					return $this->_child['p'];
					break;
				default:
					return NULL;
					break;
				} 
		}else{
			// echo "unknown method " . $method;
			throw new \KogoraException('unknown method: '. $method);
		}
		return false;
	}
	/**
	 * Get
	 * @todo 
	 * @param string
	 * @return object
	 */
	public function __get($field) {
		if(in_array($field, $this->_get_methods)){ 
			return $this->_child[$field];
		}else{
			// throw new KogoraException('__get', 'no data for requested field: '.$field);
		}
	}
	/**
	 * text
	 * @param string text
	 */
	public function text($text){
		$this->_t .= $text;
	}
	/**
	 * Return children count
	 * @return integer children count
	 */
	public function num_children(){
		$children = 0;
		foreach($this->_child as $key => $value){
			if($value){
				$children++;
			}
		}
		return $children;
	}
	/**
	 * Close
	 */
	public function close($end_tag = true) {
		// is open
		if($this->is_open){
			$this->csr .= $this->_p;
			$this->_p = '';
			$this->csr .= '>';
			$this->is_open = false;
		}
		// text
		if($this->_t){
			$this->csr .= $this->_t;
			$this->_t = '';
		}
		// children
		if($this->_child['p']){
			$this->csr .= $this->_child['p']->__toString();
			$this->_child['p'] = NULL;
		} 
		// end tag
		if($end_tag && !$this->is_ended){
			$this->csr .= '</'.$this->tag.'>';
			$this->is_ended = true;
		}
	}
}


/** 
 * Void Element class
 * @todo 
 */
abstract class VoidElement extends ElementBase
{
	/**
	 * Construct
	 * @todo 
	 */
	public function __construct(){
		parent::__construct();
	}
	/**
	 * Close
	 */
	public function close() {
		if($this->is_open){
			$this->csr .= $this->_p;
			$this->csr .= '>';
			$this->is_open = false;
		}
	}
}


    ?>