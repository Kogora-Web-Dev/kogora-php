<? namespace Kogora\HTML;
include_once(KOGORA_DIR.'/_exceptions.php');
include_once(dirname(__File__).'/_elements.base.php');


/** 
 * Doc class
 * @todo 
 */
class Doc extends Base\VoidElement
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

/** 
 * P class
 * @todo 
 */
class P extends Base\NormalElement
{

	/** 
	 * Vars
	 * @var string tag
	 */	
	public $tag = 'p';

	/**
	 * Construct
	 * @todo 
	 */
	public function __construct($args){
		parent::__construct($args); 
	}
}

/** 
 * Br class
 * @todo 
 */
class Br extends Base\VoidElement
{

	/** 
	 * Vars
	 * @var string tag
	 */	
	public $tag = 'br';

	/**
	 * Construct
	 * @todo 
	 */
	public function __construct(){
		parent::__construct(); 
	}
}
/** 
 * Body class
 * @todo 
 */
class Body extends Base\NormalElement
{

	/** 
	 * Vars
	 * @var string tag
	 */	
	public $tag = 'body';

	/**
	 * Construct
	 * @todo 
	 */
	public function __construct($args){
		parent::__construct($args); 
	}
}
/** 
 * Div class
 * @todo 
 */
class Div extends Base\NormalElement
{

	/** 
	 * Vars
	 * @var string tag
	 */	
	public $tag = 'div';

	/**
	 * Construct
	 * @todo 
	 */
	public function __construct($args){
		parent::__construct($args); 
	}
}

?>