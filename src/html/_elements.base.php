<? namespace Kogora\HTML\Base;
include_once(KOGORA_DIR.'/html/_config.php');

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
	protected $_depth = 0;
	protected $_config;

	/**
	 * Construct
	 * @param object config
	 * @param integer depth
	 * @todo 
	 */
	public function __construct($config, $depth = 0){ 
		// config
		$this->_config = $config;//->get_element_config($tag);
		// depth
		$this->_depth = $depth;
		// tab by depth
		for ($x = 0; $x <= $depth; $x++) {
			$this->csr = "\t";
		}
		$this->csr .= "\n".'<'.$this->tag;
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
?>