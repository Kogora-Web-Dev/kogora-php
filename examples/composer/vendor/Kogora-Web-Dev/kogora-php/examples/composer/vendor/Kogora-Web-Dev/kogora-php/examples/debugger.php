<?
/** 
 * More examples than in documentation.
 */
define('KOGORA_DIR_SRC', dirname(dirname(__FILE__)).'/src');

$Kogora->composer_autoload();//composer autoload
// $Kogora->direct_load(KOGORA_DIR_SRC.'/debugger/debugger.php');


// Test debugger
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