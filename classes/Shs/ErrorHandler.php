<?php
/*
 * Filename		ErrorHandler.php
 * Author		Steffen Haase
 * Date			12.11.2011
 * License		GPL v3
 */

require_once 'classes/Shs/DebugManager.php';

/**
 * Diese Klasse ersetzt den Standard Error-Handler von PHP
 * 
 * @package Shs
 * @author Steffen Haase 
 * @version 1.0
 * @ignore
 */
class ErrorHandler
{
	
	public function __construct() { }
	
	public function handleErrors($errno, $errmsg, $filename, $linenum) {
		$error_types = array(
			E_ERROR              => 'Error',
			E_WARNING            => 'Warning',
			E_PARSE              => 'Parsing Error',
			E_NOTICE             => 'Notice',
			E_CORE_ERROR         => 'Core Error',
			E_CORE_WARNING       => 'Core Warning',
			E_COMPILE_ERROR      => 'Compile Error',
			E_COMPILE_WARNING    => 'Compile Warning',
			E_USER_ERROR         => 'User Error',
			E_USER_WARNING       => 'User Warning',
			E_USER_NOTICE        => 'User Notice',
			E_STRICT             => 'Runtime Notice',
			E_RECOVERABLE_ERROR  => 'Catchable Fatal Error',
			E_DEPRECATED		 => 'Deprecated (Since PHP 5.3.0)'
		);
		$error = "<b>Error-Nr.:</b>\t" . $errno . "<br>";
		$error .= "<b>Error-Type:</b>\t" . $error_types[$errno] . "<br>";
		$error .= "<b>Error-Message:</b>\t" . $errmsg . "<br>";
		$error .= "<b>Script-File:</b>\t" . $filename . "<br>";
		$error .= "<b>Line-Number:</b>\t" . $linenum . "<br>";
		$error .= "<br>";
		$debugger = DebugManager::getInstance();
		$debugger->addPHPErrror($error);
		return true;
	}
}

?>