<?php
/*
 * Filename		File.php
 * Author		Steffen Haase
 * Date			12.01.2012
 * Copyright	(c) 2010-2011 SHS (Steffen Haase Software)
 * Contact		info@sh-software.de
 */

/**
 * File
 * 
 * Diese Klasse beinhaltet Dateisystem-Methoden
 *  
 * @package Shs
 * @author Steffen Haase <info@sh-software.de>
 * @version 1.0
 * @copyright Copyright (c) 2009-2012 SHS (Steffen Haase Software)
 */
class File
{
	/**
	 * Konstruktor
	 * 
	 * @author Steffen Haase <info@sh-software.de>
	 */
	public function __construct() {}
	
	/**
	 * Mit dieser Methode kann eine Datei gelöscht werden.
	 * 
	 * Im Erfolgsfall gibt die Methode "true" zurück, im Fehlerfall "false".
	 * 
	 * @author Steffen Haase <info@sh-software.de>
	 * @see unlink()
	 * @param String $file Vollständiger Pfad zur Datei, incl. Dateiname
	 * @return Boolean true oder false
	 */
	public function deleteFile($file) {
		if (is_file($file)) {
			return unlink($file);
		}
		return false;
	}
	
	/**
	 * Mit dieser Methode kann eine Datei verschoben werden.
	 * 
	 * Im Erfolgsfall gibt die Methode "true", im Fehlerfall "false" zurück.
	 * 
	 * @author Steffen Haase <info@sh-software.de>
	 * @see rename()
	 * @param String $from Vollständiger Pfad zum aktuellen Speicherort der Datei, incl. Dateiname
	 * @param String $to Vollständiger Pfad zum neuen Speicherort der Datei, incl. Dateiname
	 * @return Boolean true oder false
	 */
	public function moveFile($from, $to) {
		if (@is_file($from)) {
			return @rename($from, $to);
		}
		return false;
	}
	
}

?>