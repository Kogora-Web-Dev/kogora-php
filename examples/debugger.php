<?
// phpinfo();
// PHP 5.6: http://php.net/manual/en/migration56.new-features.php
/*
# Variadic functions can now be implemented using the ... operator, instead of relying on func_get_args(). 
function params(...$params){
	var_dump($params);
	    // $params is an array containing the remaining arguments.
    printf('number of params: %d'."\n",
           count($params));
}
*/
/*
params('a', 'b', 3, 4);
die();
*/

// PHP Operator
// Add overloading for direct assignment.
/*
class Foo {
  public $val;

  public function __assign($val) {
    $this->val = $val;
  }
}

$f = new Foo;
$f = 123;
var_dump($f->val); // int(123)
die('end');
*/ 

// operator 0.4.1: Operator overloading for Objects: extension - http://pecl.php.net/package/operator/0.4.1/windows
/*
Requires PHP extension: extension=php_operator.dll
*/
/** 20131226
 * Direct load test
 */
define('KOGORA_DIR_SRC', dirname(dirname(__FILE__)).'/src'); 
$loader = require_once(KOGORA_DIR_SRC.'/_main.php');
// Debugger
$b = $K->Debugger;
// $K->autoload(); // debugger + environment
$h = $K->HTML(); 

$h->enable($h::FACEBOOK);

// var_dump($it);
print_r(current($it));
$n = $it->current();
print('n:'.$n);

$n = $it->next();
// $n = end($x);
print($n);
print('n:'.$n);


$p = $h->p();
$h->p = 'hi my name is';
$h->p = 'hi my name is';
// $p->{'this is so cool but'}();
print($p);
die('done');


$div = $h->div('new-div', 'cool shit');
$p = $div->p('extra p');
$p->text('yowser!');
$p->br(8);
$p->text('ok ok');
$p->br();
$p->b('this is some bold text');
$p->br();
$p->b('this just shows the skill of eric', 'my-b-id', 'my-b-class');
$p->br(); 
print($p);
/*
Body
*/
/*
$body = $h->body('myid', 'myclass');
// $body->close(true);
print($body);
*/

/*
Head
*/

// $body = $h->body('myid', 'myclass');
// $body->close(true);
// print($body);

/*
Head
*/

// $body = $h->body('myid', 'myclass');
// $body->close(true);
// $body = $h->br(1); 
// print($body);

/*
P
*/
/*
$div = $h->div('myid', 'myclass');
$p = $div->p('pid', 'pidclass');
$p->text('My name inside a div::p, pretty cool!');
$p->br();     
$p->br();     
$p->text('Some more text');    
$p->br();    
$p->br(); 
$p->text('good shit');
print($div);
*/
// var_dump($h->config());
// $h->enable('facebook');
/*
Doc Tag
*/
// $h->doc();
// $h->finish();
// $h->enable('facebook');
 

# Test: HTML
// $loader2  = $K->load($K::HTML);  
// $h = $K->HTML();
// $h2 = $K->HTML();


// PPrint
// $h->pprint(array('pretty html', '1234'));


// $doc = $h->doc();
// print($doc);


// $doc->enable('facebook');
// $doc_config = $head->config();

/*
$div = $h->div('myid', 'myclass');
$p = $div->p('pid', 'pidclass');
$p->text('My name inside a div::p, pretty cool!');
$p->br();     
$p->br();     
$p->text('Some more text');    
$p->br();    
$p->br(); 
$p->text('good shit');
*/
// $p2 = $p->p('good-id', 'good-class');
// $p2->text('coooool! dude');
// $div->br();
// print($div);
// print($div);
// print($div);
// $h['sss'] = 'Name';
// print($h);
// $h['sss'] = 'Name';
// $h->finish();
// $K->info();


// $visitor = $K->Visitor();
// var_dump($visitor->data);
// var_dump($visitor->ip);
// var_dump($visitor);
// print('Visitor IP: '.$visitor->ip);
// $b->debug($visitor, 'visitor');








die('<br>HTML test complete.');



/** 
 * Composer load test
 */
$loader = require_once(dirname(__FILE__).'/composer/vendor/autoload.php');// composer loader
hello(); 
Kogora::load(Kogora::HTML);
$h = Kogora\HTML\HTML();
$h->pprint(array('pretty html', '1234'));


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