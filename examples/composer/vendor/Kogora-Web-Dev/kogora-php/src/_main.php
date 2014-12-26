<?
define( 'KOGORA_DIR', dirname( __FILE__ ) . '/' );

if ( is_readable( KOGORA_DIR . 'config.php' ) ) {
	require KOGORA_DIR . 'config.php';
}else{
	require KOGORA_DIR . 'config.default.php';
}

class Kogora
{

	const VERSION = '1.0.0';

	public function info(){
		echo 'Some kogora info';
	}

}

if ( !function_exists( 'kdiv' ) ) {
	/**
	 * Alias of HTML::div()
	 *
	 * @return string
	 */
	function kdiv()
	{
		echo 'cool';
	}
}
?>