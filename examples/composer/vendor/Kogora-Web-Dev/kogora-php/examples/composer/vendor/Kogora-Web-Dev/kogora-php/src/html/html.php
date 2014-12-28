<? namespace Kogora\HTML;
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

class HTML{

	public static function pprint($arr){
		echo '<pre>';
			print_r($arr);
		echo '</pre>';
	}
}

?>