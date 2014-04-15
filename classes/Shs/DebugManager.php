<?php
/*
 * Filename		DebugManager.php
 * Author		Steffen Haase
 * Date			12.11.2011
 * License		GPL v3
 */

require_once 'classes/Shs/DbConnect.php';
require_once 'classes/Shs/DbConnect.php';
require_once 'classes/Shs/Request.php';
require_once 'classes/Shs/TplEngine.php';

/**
 * Diese Klasse dient dem lesbaren/formatierten Aufbereiten von 
 * Informationen, welche dann in der sog. "Debug-Box" am unteren 
 * Ende der Applikation angezeigt werden.
 * 
 * Diese Klasse wird nur dann ausgeführt, wenn der Debugmodus der 
 * Anwendung aktiviert ist!
 *   
 * @package Shs
 * @author Steffen Haase 
 * @version 1.0
 * @ignore
 */
class DebugManager
{
	private $_DebugBox;
	private $_PhpErrors	= '';
	private static $_instance;

	/**
	 * Erzeugt eine Instanz dieser Klasse
	 *
	 * @author Steffen Haase 
	 * @access public
	 * @return Object Instanz dieser Klasse
	 */
	public static function getInstance() {
		if (!isset(self::$_instance)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	/**
	 * Konstruktor
	 *
	 * @author Steffen Haase 
	 * @access private
	 */
	private function __construct() { 
		$this->createDebugBox();
	}
	
	/**
	 * Erstellt das Grundgerüst der Debug-Box
	 * 
	 * @author Steffen Haase 
	 * @access private
	 */
	private function createDebugBox() {
		$this->_DebugBox = '<br><br><div id="info_debug_box">'.
			'<center><h2>DEBUG-MODE</h2></center>{DEBUG_INFORMATIONS}'.
			'<br><strong>Script-Runtime: </strong>{RUNTIME} seconds</div>';
	}
	
	/**
	 * Befüllt die Debug-Box mit den notwendigen Daten und fügt sie im 
	 * Template an entsprechender Stelle ein.
	 *
	 * @author Steffen Haase 
	 * @access public
	 */
	public function addDebugBox() {
		$debuginfos = $this->getRequestData();
		$debuginfos .= $this->getFileData();
		$debuginfos .= $this->getMySqlMessages();
		$debuginfos .= $this->getTemplateErrors();
		$debuginfos .= $this->getPhpErrors();
		$debugbox = str_replace('{DEBUG_INFORMATIONS}', $debuginfos, $this->_DebugBox);
		$template = TplEngine::getInstance();
		$template->assignVar('debug_box', $debugbox);
	}
	
	/**
	 * Gibt die PHP Fehler formatiert zurück
	 *
	 * @author Steffen Haase 
	 * @access private
	 * @return String 
	 */
	private function getPhpErrors() {
		$errors = '';
		if ($this->_PhpErrors != '') {
			$errors = '<br><b><u>PHP error reporting:</u></b><br>'.
			             '<pre style="white-space:pre-line;">'.
			             $this->_PhpErrors.'</pre>';
		}
		return $errors;
	}
	
	/**
	 * Prüft ob Fehler in der Template-Engine vorhanden sind und 
	 * gibt diese formatiert zurück.
	 * 
	 * @author Steffen Haase 
	 * @access private
	 * @return String
	 */
	private function getTemplateErrors() {
		$errors = '';
		$template = TplEngine::getInstance();
		if ($template->hasErrors()) {
			$errors = '<b><u>Template engine errors:</u></b><br>'.
			             '<pre style="white-space:pre-line;">'.
			             $template->getErrors().'</pre><br>';
		}
		return $errors;
	}
	
	/**
	 * Fügt einen PHP Fehler zu einer internen Klassen-Variable hinzu.
	 * 
	 * Diese Methode wird vom ErrorHandler genutzt!
	 * 
	 * @author Steffen Haase 
	 * @access public
	 * @param String $error
	 */
	public function addPHPErrror($error) {
		if (!isset($this->_PhpErrors)) {
			$this->_PhpErrors = $error;
		} else {
			$this->_PhpErrors .= $error;
		}
	}
	
	/**
	 * Prüft ob Statusmeldungen in der Datenbank-Klasse vorhanden sind 
	 * und gibt diese formatiert zurück.
	 * 
	 * @author Steffen Haase 
	 * @access private
	 * @return String
	 */
	private function getMySqlMessages() {
		$db = DBConnect::getInstance();
		if ($db->hasDebugMessages()) {
			$data = print_r($db->getDebugMessages(), true);
			$data = '<b><u>MySQL statements information:</u></b><br>' .
					'<pre style="white-space:pre-line;">'.$data.'</pre><br>';
			return $data;
		}
		return '';
	}
	
	/**
	 * Prüft ob die globale Variable $_FILES Daten enthält und gibt dieses 
	 * Array formiert zurück.
	 * 
	 * @author Steffen Haase 
	 * @access private
	 * @return String
	 */
	private function getFileData() {
		if (!empty($_FILES)) {
			$data = print_r($_FILES, true);
			$data = '<b><u>Upload file data:</u></b>' .
					'<pre>'.$data.'</pre><br>';
			return $data;
		}
		return '';
	}
	
	/**
	 * Gibt vorhandene Request-Schlüssel und -Werte formatiert zurück.
	 * 
	 * @author Steffen Haase 
	 * @access private
	 * @return String
	 */
	private function getRequestData() {
		$data = '';
		$getpost = Request::getInstance();
		if ($getpost->hasRequests()) {
			$data = print_r($getpost->getAllRequests(), true);
			$data = '<b><u>Submitted request parameters:</u></b>' .
					'<pre>'.$data.'</pre><br>';
		}
		return $data;
	}
	
	/**
	 * Gibt die Schlüssel und Werte aus dem $_SESSION Array formatiert zurück.
	 * 
	 * @author Steffen Haase 
	 * @access private
	 * @return String
	 */
	private function getSessionData() {
		$data = print_r($_SESSION, true);
		$data = '<b><u>Session data:</u></b>' .
				'<pre>'.$data.'</pre><br>';
		return $data;
	}

}

?>