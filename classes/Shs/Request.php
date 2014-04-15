<?php
/*
* Filename		Request.php
* Author		Steffen Haase
* Date			11.10.2011
* Copyright	(c) 2010-2011 SHS (Steffen Haase Software)
* Contact		info@sh-software.de
*/

/**
* Klasse für das Behandeln von Requests
*
* Diese Klasse enthält Methoden für das Behandeln von Request-Parametern, 
* die per "GET" oder "POST" übermittelt wurden. 
*
* @package Shs
* @author Steffen Haase <info@sh-software.de>
* @version 1.0
* @copyright Copyright (c) 2009-2011 SHS (Steffen Haase Software)
*/
class Request
{
	private $_GetPost;
	private static $_instance;
	
	/**
	 * Erzeugt eine Instanz dieser Klasse
	 * 
	 * @author Steffen Haase <info@sh-software.de>
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
	 * Der Konstruktor liest alle GET- und POST-Parameter aus und speichert sie in einem 
	 * Multiarray innerhalb dieser Klasse.
	 * 
	 * @author Steffen Haase <info@sh-software.de>
	 * @access private
	 */
	private function __construct() {
		$this->_GetPost = array();
		foreach ($_GET as $key => $val) {
			$this->_GetPost[$key] = trim($val);
		}
		foreach ($_POST as $key => $val) {
			$this->_GetPost[$key] = trim($val);
		}
		if (!isset($this->_GetPost['site'])) {
			$this->_GetPost['site'] = 'login';
		}
	}
	
	/**
	 * Diese Methode prüft ob ein Parameter gesetzt wurde und auch einen Wert hat.
	 *  
	 * @author Steffen Haase <info@sh-software.de>
	 * @access public
	 * @param String $key Name des Parameters der geprüft werden soll
	 * @return Boolean true oder false
	 */
	public function _isSet($key) {
		if (isset($this->_GetPost[$key]) && $this->_GetPost[$key] != '') {
			return true;
		}
		return false;
	}
	
	/**
	 * Diese Methode gibt den Wert eines Parameters als Integer zurück.
	 * 
	 * Wurde der Parameter nicht gefunden oder enthält keinen Wert, so
	 * liefert diese Methode <b>null</b> zurück.
	 *  
	 * @author Steffen Haase <info@sh-software.de>
	 * @access public
	 * @param String $key Name des Parameters dessen Wert man haben möchte
	 * @return Integer Den Wert des Parameters als Integer
	 */
	public function getInt($key) {
		if ($this->_isSet($key)) {
			return (int)$this->_GetPost[$key];
		}
		return null;
	}
	
	/**
	 * Diese Methode gibt den Wert eines Parameters als String zurück.
	 * 
	 * Wurde der Parameter nicht gefunden oder enthält keinen Wert, so
	 * liefert diese Methode <b>null</b> zurück.
	 * 
	 * @author Steffen Haase <info@sh-software.de>
	 * @access public
	 * @param String $key Name des Parameters dessen Wert man haben möchte
	 * @return Den Wert des Parameters als String, oder null
	 */
	public function getString($key) {
		if ($this->_isSet($key)) {
			return (string)$this->_GetPost[$key];
		}
		return null;
	}
	
	/**
	 * Prüft ob der Wert eines Parameters numerisch ist.
	 * 
	 * @author Steffen Haase <info@sh-software.de>
	 * @access public
	 * @param String $key Name des Parameters dessen Wert geprüft werden soll
	 * @return Boolean true oder false
	 */
	public function isNumeric($key) {
		if (is_numeric($key)) {
			return true;
		}
		return false;
	}
	
	/**
	 * Gibt alle Request-Parameter und die zugehörigen Werte als Array zurück.
	 * 
	 * @author Steffen Haase <info@sh-software.de>
	 * @access public
	 * @return Array Array mit allen Request-Parameter und -Werten
	 */
	public function getAllRequests() {
		return $this->_GetPost;
	}
	
	/**
	 * Prüft ob Request-Parameter übermittelt wurden.
	 * 
	 * @author Steffen Haase <info@sh-software.de>
	 * @access public
	 * @return Boolean true oder false
	 */
	public function hasRequests() {
		if (isset($this->_GetPost)) {
			return true;
		}
		return false;
	}
	
	/**
	 * Über diese Methode kann man den Wert des Parameters $key ändern.
	 * 
	 * Bsp.<br>
	 * <code>
	 * setValue('param', 'NeuerWert');
	 * </code>
	 * 
	 * @author Steffen Haase <info@sh-software.de>
	 * @access public
	 * @param String $key Der Name des Request-Schlüssels
	 * @param unknown_type $value Der neue Wert der gesetzt werden soll 
	 */
	public function setValue($key, $value) {
		$this->_GetPost[$key] = $value;
	}
	
	/**
	 * Diese Methode parst den Wert des Parameters $key durch die Funktion 
	 * htmlspecialchars($val, ENT_QUOTES) und gibt das Resultat zurück.
	 * 
	 * @author Steffen Haase <info@sh-software.de>
	 * @param $key Name des Parameters
	 * @return String
	 */
	public function convertString($key) {
		return htmlspecialchars($this->getString($key));
	}
}

?>
