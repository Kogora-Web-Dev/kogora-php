<? namespace Kogora\User;
/** 
 * @name visitor.php
 * @author Eric Mugerwa
 * @version 1.0
 * @package Kogora
 * @link http://edu.kogora.com
 * @todo 
 * @uses return visitor information
 * @example Visitor::get_info
 */


class Visitor{

	/**
	 * Construct
	 * @param bool verbose
	 * @var array data
	 * @return array
	 */	
	public function __construct($verbose = true){
		$data = array();
		$data['ip'] = self::_ip(); // remote_addr
		if($verbose){
			$data['http_referer'] = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : NULL;
			$data['http_user_agent'] = $_SERVER['HTTP_USER_AGENT'];
			$data['host_name'] = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		}
		$this->data = $data;		
	}
	/**
	 * Get
	 * @todo 
	 * @param string
	 * @return object
	 */
	public function __get($field) {
		$keys = array_keys($this->data);
		if(in_array($field, $keys)){
			return $this->data[$field];
		}else{
			throw new KogoraException('__get', 'no data for requested field: '.$field);
		}
	}
	/**
	 * Return visitor information
	 * @return string
	 */	
	public function __toString() {
		$line = 'Visitor: '.$this->data['ip'];
		return $line;
	}
	/**
	 * Return visitor IP address
	 * @return array
	 */	
	private static function _ip(){
		$client  = @$_SERVER['HTTP_CLIENT_IP'];
		$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
		$remote  = $_SERVER['REMOTE_ADDR'];

		if(filter_var($client, FILTER_VALIDATE_IP))
		{
			$ip = $client;
		}
		elseif(filter_var($forward, FILTER_VALIDATE_IP))
		{
			$ip = $forward;
		}
		else
		{
			$ip = $remote;
		}
		return $ip;
	}
}
?>