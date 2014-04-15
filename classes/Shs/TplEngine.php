<?php
/*
 * Filename		TplEngine.php
 * Author		Steffen Haase
 * Date			15.01.2010
 * License		GPL v3
 */

/**
 * Kompakte Template-Engine
 * 
 * Dient dem Ersetzen von Template-Variablen durch die entsprechende Werte.<br>
 * Auf diese Weise ist eine strikte Trennung von HTML- und PHP-Code möglich.
 *
 * @package Shs
 * @author Steffen Haase 
 * @version 2.0
 */
class TplEngine
{
	private $_sign_left		= '{';
	private $_sign_right	= '}';
	private $_template_dir	= 'templates/';
	private $_style_dir		= 'style/';
	private $_js_dir		= 'lib/';
	private $_tpl			= '';
	private $_tpl_tmp		= '';
	private $_install_dir	= '';
	private $_errors;
	
	private static $_instance;
	
	/**
	 * Gibt eine Instanz der Template-Klasse wieder.
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
	 * Erzeugt ein Objekt der Klasse.
	 * 
	 * @author Steffen Haase 
	 * @access private
	 */
	private function __construct() {
		$this->_install_dir	= SHS_COMPLETE_URL;
		$this->_style_dir 	= SHS_COMPLETE_URL.$this->_style_dir;
		$this->_js_dir 		= SHS_COMPLETE_URL.$this->_js_dir;
	}
	
	/**
	 * Liefert ein Verzeichnis zurück.
	 * 
	 * @author Steffen Haase 
	 * @access public
	 * @param String $var Mögliche Werte: style, js
	 * @return String URL zum jeweiligen Verzeichnis
	 */
	public function getPath($var) {
		switch (strtolower(trim($var))) {
			case 'style':
				return $this->_style_dir;
			case 'js':
				return $this->_js_dir;
			default:
				return $this->_install_dir;
		}
	}
	
	/**
	 * Liest ein Template über die Funktion "getTemplate($tpl)" ein 
	 * und speichert es in der Klassen-Variable "$_tpl" ab. Der Name des zu 
	 * öffnenden Templates muss ohne den zusatz ".tpl" angegeben werden!
	 * 
	 * @author Steffen Haase 
	 * @access public
	 * @uses getTemplate()
	 * @param String $tpl Dateiname des Templates
	 */
	public function openTemplate($tpl) {
		$this->_tpl = '';
		$this->_tpl = $this->getTemplate($tpl);
	}
	
	/**
	 * Liest ein Template aus dem Dateisystem ein und gibt den Inhalt des Templates zurück.<br><br>
	 *  
	 * Falls das Template nicht gefunden wurde erhält man eine Fehlermeldung.
	 * 
	 * @author Steffen Haase 
	 * @access private
	 * @param String $tpl Dateiame des Templates
	 * @return String Inhalt des Templates
	 */
	private function getTemplate($tpl) {
		$file = SHS_PATH_SERVER.$this->_template_dir.$tpl.'.tpl';
		if (is_file($file)) {
			$template = file_get_contents($file);
			return $template;
		} else {
			return '<br><br><h2>FATAL ERROR!!</h2><b>Could not find the template "'.$tpl.'.tpl"!</b><br><br>';
		}
	}
	
	/**
	 * Liest ein weiteres Template aus dem Dateisystem ein und ersetzt in dem Template, 
	 * welches in der Klassen-Variable "$_tpl" gespeichert ist, die Template-Variable
	 * "{SITECONTENT}". Der Dateiname des einzulesenden Templates muss ohne den Zusatz ".tpl" 
	 * angegeben werden!<br><br>
	 * 
	 * Im Debug-Modus wird im Fehlerfall eine Exception geworfen!
	 * 
	 * @author Steffen Haase 
	 * @access public
	 * @uses getTemplate()
	 * @param String $tpl Dateiname des Templates (ohne .tpl)
	 */
	public function setSubTPL($tpl) {
		$file = SHS_PATH_SERVER.$this->_template_dir.$tpl.'.tpl';
		try {
			if (is_file($file)) {
				$this->assignVar('SITECONTENT', $this->getTemplate($tpl));
			} else {
				throw new Exception('<font color="#FF0000"><b>Could not find the template "'.$tpl.'.tpl"!</b></font><br>');
			}
		} catch (Exception $e) {
			$this->addError($e->getMessage().'<b>Stack trace:</b><br>'.$e->getTraceAsString());
		}
	}

	/**
	 * Liest ein weiteres Template aus dem Dateisystem ein und speichert den Inhalt
	 * des Templates in der Klassen-Variable "$_tpl_tmp". Der Dateiname des zu ladenden
	 * Templates muss ohne den Zusatz ".tpl" angegeben werden!<br><br>
	 * 
	 * Im Debug-Modus wird im Fehlerfall eine Exception geworfen!
	 * 
	 * @author Steffen Haase 
	 * @access public
	 * @uses getTemplate()
	 * @param String $tpl Dateiname des Templates
	 */
	public function loadTPL($tpl) {
		$file = SHS_PATH_SERVER.$this->_template_dir.$tpl.'.tpl';
		try {
			if (is_file($file)) {
				$this->_tpl_tmp .= $this->getTemplate($tpl);
			} else {
				throw new Exception('<font color="#FF0000"><b>Could not find the template "'.$tpl.'.tpl"!</b></font><br>');
			}
		} catch (Exception $e) {
			$this->addError($e->getMessage().'<b>Stack trace:</b><br>'.$e->getTraceAsString());
		}
	}

	/**
	 * Gibt den Inhalt der Klassen-Variable "$_tpl_tmp" zurück und löscht den Inhalt 
	 * der Klassen-Variable "$_tpl_tmp".<br><br>
	 * 
	 * Im Debug-Modus wird im Fehlerfall eine Exception geworfen!
	 * 
	 * @author Steffen Haase 
	 * @access public
	 * @uses clearTPL()
	 * @return String Inhalt der Klassen-Variable "$tpl_tmp"
	 */
	public function getTPL() {
		try {
			if (!empty($this->_tpl_tmp)) {
				$out = $this->_tpl_tmp;
				$this->clearTPL();
				return $out;
			} else {
				throw new Exception('<font color="#FF0000"><b>There is no template loaded!</b></font><br>');
			}
		} catch (Exception $e) {
			$this->addError($e->getMessage().'<b>Stack trace:</b><br>'.$e->getTraceAsString());
		}
	}
	
	/**
	 * Leert die Klassen-Variable "$tpl_tmp"
	 */
	public function clearTPL() {
		$this->_tpl_tmp = '';
	}
	
	/**
	 * Ersetzt innerhalb der Klassen-Variable "$_tpl" eine Template-Variable.
	 * Der Name der Template-Variable die ersetzt werden soll muss ohne die 
	 * geschweiften Klammern angegeben werden!<br><br>
	 * <b>Diese Funktion ist veraltet! Bitte nutzt stattdessen die Funktion: assignVar($var, $val)</b>
	 * 
	 * @author Steffen Haase 
	 * @deprecated
	 */
	public function replaceVar($var1, $var2){
		try {
			throw new Exception(
				'<font color="#FF0000"><b>Deprecated function: replaceVar($var1, $$var2)</b>'.
				'</font><br>Please use: <b>assignVar($var, $val)</b><br>'
			);
		} catch (Exception $e) {
			$this->addError($e->getMessage().'<b>Stack trace:</b><br>'.$e->getTraceAsString());
		}
	}

	/**
	 * Ersetzt innerhalb der Klassen-Variable "$_tpl_tmp" eine Template-Variable.
	 * Der Name der Template-Variable die ersetzt werden soll muss ohne die 
	 * geschweiften Klammern angegeben werden!
	 * 
	 * @author Steffen Haase 
	 * @deprecated
	 */
	public function replaceVarTPL($var1, $var2){
		try {
			throw new Exception(
				'<font color="#FF0000"><b>Deprecated function: replaceVarTPL($var1, $$var2)</b>'.
				'</font><br>Please use: <b>assignVarTPL($var, $val)</b><br>'
			);
		} catch (Exception $e) {
			$this->addError($e->getMessage().'<b>Stack trace:</b><br>'.$e->getTraceAsString());
		}
			}
	
	/**
	 * Ersetzt innerhalb der Klassen-Variable "$_tpl" eine Template-Variable.
	 * Der Name der Template-Variable die ersetzt werden soll muss ohne die 
	 * geschweiften Klammern angegeben werden!<br><br>
	 * 
	 * Im Debug-Modus wird im Fehlerfall eine Exception geworfen!
	 * 
	 * @author Steffen Haase 
	 * @access public
	 * @param String $var Name der Template-Variable (ohne {})
	 * @param String $val Wert der eingesetzt werden soll
	 */
	public function assignVar($var, $val) {
		$var = $this->_sign_left.strtoupper($var).$this->_sign_right;
		try {
			if (strpos($this->_tpl, $var) !== false) {
				$this->_tpl = str_replace($var, $val, $this->_tpl);
			} else {
				throw new Exception('<font color="#FF0000"><b>Template variable "'.$var.'" not found!</b></font><br>');
			}
		} catch (Exception $e) {
			$this->addError($e->getMessage().'<b>Stack trace:</b><br>'.$e->getTraceAsString());
		}
	}

	/**
	 * Ersetzt innerhalb der Klassen-Variable "$_tpl_tmp" eine Template-Variable.
	 * Der Name der Template-Variable die ersetzt werden soll muss ohne die 
	 * geschweiften Klammern angegeben werden!<br><br>
	 * 
	 * Im Debug-Modus wird im Fehlerfall eine Exception geworfen!
	 * 
	 * @author Steffen Haase 
	 * @access public
	 * @param String $var Name der Template-Variable (ohne {})
	 * @param String $val Wert der eingesetzt werden soll
	 */
	public function assignVarTPL($var, $val) {
		$var = $this->_sign_left.strtoupper($var).$this->_sign_right;
		try{
			if (strpos($this->_tpl_tmp, $var) !== false) {
				$this->_tpl_tmp = str_replace($var, $val, $this->_tpl_tmp);
			} else {
				throw new Exception('<font color="#FF0000"><b>Template variable "'.$var.'" not found!</b></font><br>');
			}
		} catch (Exception $e) {
			$this->addError($e->getMessage().'<b>Stack trace:</b><br>'.$e->getTraceAsString());
		}
	}
	
	/**
	 * Ersetzt innerhalb der Klassen-Variable "$_tpl" mehrere Template-Variablen.
	 * Es muss ein Array mit den zu ersetzenden Variablen und deren Inhalten
	 * übergeben werden.<br><br>
	 * 
	 * Im Debug-Modus wird im Fehlerfall eine Exception geworfen!
	 * 
	 * @author Steffen Haase 
	 * @access public
	 * @uses assignVar()
	 * @param Array Ein Array mit den Template-Variablen (ohne {}) und den zu setzenden Werten
	 */
	public function assignVars($vars) {
		try {
			if (is_array($vars)) {
				foreach ($vars as $key => $val) {
					$this->assignVar($key, $val);
				}
			} else {
				throw new Exception('<font color="#FF0000"><b>This method expects an array!</b></font><br>');
			}
		} catch (Exception $e) {
			$this->addError($e->getMessage().'<b>Stack trace:</b><br>'.$e->getTraceAsString());
		}
	}

	/**
	 * Ersetzt innerhalb der Klassen-Variable "$_tpl_tmp" mehrere Template-Variablen.
	 * Es muss ein Array mit den zu ersetzenden Variablen und deren Inhalten
	 * übergeben werden.
	 * 
	 * @author Steffen Haase 
	 * @access public
	 * @uses assignVarTPL()
	 * @param Array Ein Array mit den Template-Variablen (ohne {}) und den zu setzenden Werten
	 */
	public function assignVarsTPL($vars) {
		try {
			if (is_array($vars)) {
				foreach ($vars as $key => $val) {
					$this->assignVarTPL($key, $val);
				}
			} else {
				throw new Exception('<font color="#FF0000"><b>This method expects an array!</b></font><br>');
			}
		} catch (Exception $e) {
			$this->addError($e->getMessage().'<b>Stack trace:</b><br>'.$e->getTraceAsString());
		}
	}
	
	/**
	 * Prüft ob die gegebene Variable im Template enthalten ist.
	 * 
	 * @author Steffen Haase 
	 * @access public
	 * @param String $var Name der Template-Variable (ohne {})
	 * @ignore
	 */
	public function existsVar($var) {
		$var = $this->_sign_left.strtoupper($var).$this->_sign_right;
		if (strpos($this->_tpl, $var) !== false) {
			return true;
		}
		return false;
	}

	/**
	 * Gibt den Inhalt der Klassen-Variable "$_tpl" per echo aus.
	 * durch die entsprechenden Werte ersetzt. Der Parameter der erwartet wird, wird
	 * für die Berechnung der Ausführungszeit des Scriptes benötigt.
	 * 
	 * @author Steffen Haase 
	 * @access public
	 */
	public function printTemplate() {
		$endtime = microtime(true);
		$runtime = round($endtime - SHS_SCRIPT_STARTTIME,3);
		$this->assignVar('RUNTIME',$runtime);
		header("Content-Type: text/html; charset=iso-8859-1");
		echo $this->_tpl;
	}
	
	/**
	 * @ignore
	 */
	private function setCopyright(){
		$tmp = $this->_tpl;
		$copyright = '<br><div style="text-align:center;">' .
				'JFChat PictureUpload '.SHS_VERSION.' &copy; 2012 by '.
				'<a href="http://www.sh-software.de" target="_blank">SHS</a>'.
				'</div>';
		$pos1 = strpos(strtolower($tmp), '</body>');
		if ($pos1 !== false) {
			$tmp1 = substr($tmp, 0, $pos1);
			$tmp2 = substr($tmp, $pos1);
			$tmp = $tmp1.$copyright.$tmp2;
		} else {
			$tmp .= $copyright;
		}
		$this->_tpl = $tmp;
	}
	
	/**
	 * Entfernen von nicht verwendeten (leeren) Template-Variablen. Hierbei werden 
	 * bis auf "{DEBUG_BOX}" alle nicht genutzten Template-Variablen gelöscht.
	 * 
	 * @author Steffen Haase <info@sh-software.de
	 * @access public
	 */
	public function removeEmptyVars() {
		$this->_tpl = str_replace('{DEBUG_BOX}', '[DEBUG_BOX]', $this->_tpl);
		$this->_tpl = preg_replace("#\{\S+\}#", '', $this->_tpl);
		$this->_tpl = str_replace('[DEBUG_BOX]', '{DEBUG_BOX}', $this->_tpl);
	}
	
	/**
	 * Fügt eine Errormeldung hinzu
	 * @param String $message
	 * @param Array $trace
	 */
	private function addError($message) {
		if (!isset($this->_errors)) {
			$this->_errors = $message;
		} else {
			$this->_errors .= '<br><br>'.$message;
		}
	}
	
	/**
	 * Prüft ob Fehlermeldungen innerhalb der Template-Engine vorliegen.
	 * 
	 * Diese Methode wird von der DebugManager-Klasse benütigt!
	 * 
	 * @author Steffen Haase 
	 * @access public
	 * @return Boolean true oder false
	 */
	public function hasErrors() {
		if (isset($this->_errors)) {
			return true;
		}
		return false;
	}
	
	/**
	 * Gibt die Fehlermeldungen der Template-Engine zurück.
	 * 
	 * Diese Methode wird von der DebugManager-Klasse benötigt!
	 * 
	 * @author Steffen Haase 
	 * @access public
	 * @return String Fehlermeldungen der Template-Engine
	 */
	public function getErrors() {
		return $this->_errors;
	}
}
 
?>