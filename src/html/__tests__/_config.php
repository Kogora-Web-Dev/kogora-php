<? namespace Kogora\HTML;
/** 
 * @name _config.php
 * @author Eric Mugerwa
 * @version 1.0
 * @package Kogora
 * @link http://edu.kogora.com
 */

function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
}

class ElementConfig{

	/** 
	 * Vars
	 * @var array
	 */
	protected $_tag;
	protected $_ini;



	/**
	 * Construct
	 * @param array
	 * @param string ini: illegal methods
	 */
	public function __construct($tag, $ini){ 
		$this->_tag = $tag;
		$this->_ini = $ini; // e.g: div = div,p,b
	}

	/**
	 * Is method
	 * @param array
	 */
	public function is_method($method){ 
		$methods = $this->_ini;
		if (strpos($methods, ','.$method.',') !== false) { 
			return true;
		}else{
			return false;
		}
	}
}

class Config{

	/** 
	 * Vars
	 * @var array
	 */
	protected $_options;
	protected $_ini;


	/**
	 * Construct
	 * @todo 
	 * @param array
	 */
	public function __construct($args = NULL){ 
		// read default config
		$this->_options = array(
			Options::FACEBOOK => false,
			Options::SCHEMA => NULL,
			); 
		// Parse ini file
		$ini = parse_ini_file('config.ini', true);// process sections
		// var_dump($ini);
		// loop through settings
		$all_values = '';
		foreach($ini as $setting_name => $setting){
			if($setting_name == 'normal' || $setting_name == 'void'){ 
				$values = '';
				foreach($setting as $value){
					$values .= ','.$value; // add preceding comma
				}
				$values .= $value.','; // add trailing comma
				$ini[$setting_name]['all'] = $values;
				$all_values .= $values;
			}
		}
		$ini['all_methods'] = $all_values; 
		$this->_ini = $ini;
		// var_dump($this->_ini);

		// enable args
		$this->enable($args);
	}
	/**
	 * Is it a normal method
	 * @notes strpos is the fastest way to search a text needle
	 * @return array 
	 */
	public function is_method($method, $key){ 
		if($key == 'normal' || $key == 'void'){ 
			$methods = $this->_ini[$key]['all'];
		}
		if (strpos($methods, ','.$method.',') !== false) { 
			return true;
		}else{
			return false;
		}
	}

	/**
	 * Set config
	 * @return array 
	 */
	public function get_element_config($tag){ 
		$config = array(
			'all_methods'=>$this->_ini['all_methods'],
			'illegal_methods'=>$this->_ini['illegal_methods'][$tag]
			);
		return new ElementConfig($tag, $config);
	}

	/**
	 * Return data
	 * @return array 
	 */
	public function data(){
		return $this->_options;
	}
	/**
	 * Enable / disable in config
	 * @param bool enable
	 * @param array 
	 */
	public function enable($args = NULL, $enable = true){
		// configure from args
		if($args){
			// array
			if(is_array($args)){
				foreach($args as $arg){
					$this->_enable_option($arg, $enable);
				}
			// string
			}else{
				$this->_enable_option($args, $enable);
			}
		}
		return true;
	}	
	/**
	 * Enable option
	 * @param const option
	 * @param bool enable
	 */
	private function _enable_option($option, $enable){
		if(array_key_exists($option, $this->_options)){
			$this->_options[$option] = $enable;
		}else{
			throw new KogoraException('unknown option: '.$option);
		}
	}
}
?>