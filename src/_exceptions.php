<?
/** 
 * Kogora exception: RuntimeException
 * @todo 
 */
class KogoraException extends Exception
{

	// Redefine the exception
	public function __construct($message, $code = 0, Exception $previous = null) {
		$g = $this->getTrace();
		$class = $g[1]['class'];
		$class_message = '<'.$class.'>';
		// var_dump($g);
		/*
		$caller = $g[1]['class'];
		$caller .= $g[1]['type'];
		$caller .= $g[1]['function'];
		$caller .= '(';
		$numargs = count($g[1]['args']);
		$i = 1;
		foreach($g[1]['args'] as $arg){
			$caller .= $arg;
			if($i < $numargs){
				$caller .= ', ';
			}
			$i ++;
		}
		$caller .= ')';
		*/

		// message
		// $message = "".$caller.": \"".$message."\"";//."<br> thrown in <b>".$g[0]['file'].' on line '.$g[0]['line'];
		$message = $class_message.' "'.$message.'"';
		// set exception
		$this->file = $g[0]['file'];
		$this->line = $g[0]['line']; 
		// send to parent
		parent::__construct($message, $code, $previous);
	}

	// custom string representation of object
	public function __toString() {
		// return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
		return __CLASS__ . ": {$this->message}\n";
	}

	public function customFunction() {
		echo "A custom function for this type of exception\n";
	}

}


/** 
 * Kogora error handler
 * @todo 
 */
function error_handler($level, $message, $file, $line, $context) {
	//Handle user errors, warnings, and notices ourself
	if($level === E_USER_ERROR || $level === E_USER_WARNING || $level === E_USER_NOTICE) {
		switch($level) {
			case E_USER_WARNING:
				$_level = 'Warning';
				break;
			case E_USER_NOTICE:
				$_level = 'Notice';
				break;
			default:
				$_level = 'Error';
				break;
			} 
		echo '<strong>Kogora '.$_level.':</strong> '.$message;
		return(true); //And prevent the PHP error handler from continuing
	}
	return(false); //Otherwise, use PHP's error handler
}

/** 
 * Kogora error function
 * @todo 
 */
function trigger_kogora_error($message, $level) {
	//Get the caller of the calling function and details about it
	$callee = next(debug_backtrace());
	//Trigger appropriate error
	trigger_error($message.' in <strong>'.$callee['file'].'</strong> on line <strong>'.$callee['line'].'</strong>', $level);
}

//Use our custom handler
set_error_handler('error_handler');
?>