<? namespace Kogora\HTML;
include_once(KOGORA_DIR.'/_exceptions.php');
include_once(KOGORA_DIR.'/html/_elements.base.php');



// class Elements{

// 	private static $TextElement = array(
// 		'span',
// 		'b'
// 		);
// }
global $TextElement;
$TextElement = array(
		'span',
		'b'
		);

/** 
 * Normal Element class
 * @todo 
 */
class NormalElement extends Base\ElementBase
{
	/** 
	 * Vars
	 * @var bool is_open
	 */	
	protected $_t = '';
	private $_child = array();
	protected $is_ended = false;

	/**
	 * Construct
	 * @todo 
	 */
	public function __construct($tag, $config, $args = NULL, $depth = 0){
		// tag
		$this->tag = $tag;
		// construct
		parent::__construct($config, $depth);
		$count = count($args);
		// args
		if($args){
			$marker = array();
			global $TextElement;
			if(in_array($this->tag, $TextElement)){
				$this->_t .= $args[0];
				$marker['id'] = 1;
				$marker['class'] = 2;				
			}else{
				$marker['id'] = 0;
				$marker['class'] = 1;
			}
			foreach($marker as $key => $value){
				if(in_array($value, $args)){
					$this->_p .= ' '.$key.'="'.$args[$value].'"';
				}
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
		if($this->_config->is_method($method)){
			// echo 'constructing child tag'; 
			$illegal_parents = array(); // illegal parents
			$next_depth = $this->_depth + 1;
			if(!$this->_config->is_element_method($this->tag, $method)){
				throw new \KogoraException($method.' cannot be a child of '.$this->tag);
			}else{
				// br
				if($this->tag == 'br'){
					$this->close(false); 
					$s = LoopedVoidElement('br', $this->_config, $args, $next_depth);
					$this->csr .= $s;
					return $s;
				// normal
				}else{
					$this->_child[$method] = new NormalElement($method, $this->_config, $args, $next_depth);
					return $this->_child[$method];
				}
			}
		}else{
			// echo "unknown method " . $method;
			// $this->_t = $method;// add to text, assuming syntax: $p->{'example syntax for text in normal element shorthand'}
			throw new \KogoraException('unknown method p: '. $method);
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
		$data = NULL;
		if($this->_config->is_element_method($this->tag, $field)){ 
			if($this->child_exists($field)){
				return $this->_child[$field];
			}
		}
		// if not returned
		throw new \KogoraException('no data for requested field: '.$field);
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
			$this->csr .= '>'."\n";
			$this->is_open = false;
		}
		// text
		if($this->_t){
			$this->csr .= "\t".$this->_t;
			$this->_t = '';
		}
		// children
		$num_children = $this->num_children();
		if($num_children > 0){ 
			foreach($this->_child as $key => $value){
				if($value){
					$this->csr .= $this->_child[$key]->__toString();
					$this->_child[$key] = NULL;
				}
			}
		} 
		// end tag
		if($end_tag && !$this->is_ended){
			$this->csr .= "\n".'</'.$this->tag.'>';
			$this->is_ended = true;
		}
	}
}


/** 
 * Void Element class
 * @todo 
 */
class VoidElement extends Base\ElementBase
{
	/**
	 * Construct
	 * @todo 
	 */
	public function __construct($tag, $config, $args = NULL, $depth = 0){
		$this->tag = $tag;
		parent::__construct($config, $depth);
		$count = count($args);
		// args
		if($args){
			if($tag != 'br'){
				if($count > 0){
					$this->_p .= ' id="'.$args[0].'"';
				}
				if($count > 1){
					$this->_p .= ' class="'.$args[1].'"';
				}
			}
		}
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









/** 
 * Doc class
 * @todo 
 */
class Doc extends VoidElement
{

	/** 
	 * Vars
	 * @var string tag
	 */	
	public $tag = '!DOCTYPE html';
	protected $_enabled = array();
	protected $_config = array();
	protected $schema = array();

	/**
	 * Construct
	 * @todo 
	 */
	public function __construct($config = NULL){
		parent::__construct();
		$count = count($config);
		// schema
		$this->schema = array(
			'category'=>'Organization',
			);
		// config
		if($config){
			$this->_config = $config;
		}
		// $this->_config = array(
		// 	'facebook' => false;
		// 	); 
		foreach($this->_config as $key => $value){ 
			$this->enable($value);
		}
	}
	/**
	 * Enable 
	 * @param string
	 */
	public function enable($name){
		if(!array_key_exists($name, $this->_config)){
			if($name == 'facebook'){
				$this->_p .= " xmlns=\"http://www.w3.org/1999/xhtml\" xmlns:fb=\"http://www.facebook.com/2008/fbml\" xml:lang=\"en\" itemscope itemtype=\"http://schema.org/".$this->schema['category']."\"";
			}
			$this->_config[$name] = true;
		}
	}
	/**
	 * Configure head
	 * @todo facebook
	 */
	public function config($config){
		if(!$config){

		}else{
			return $this->config;
		}

	}
} 
?>