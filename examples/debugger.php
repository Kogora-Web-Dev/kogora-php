<?
/** 
 * More examples than in documentation.
 */
$loader = require(dirname(__FILE__).'/composer/vendor/autoload.php');

use Kogora\Debugger;
$b = new Debugger\Debugger();
// $fb->enable('firebug');
// $fb->stdout('sdsdsd'); 
$b->enable_output(false);
$b->server();

$b->pprint(array('d3d', 's44d'), 'Sample array');
// $b->enable_output(false);
$b->pprint(array('33d3d', 'dds44d'));


?>