<?php
/*
 * Project		JFchat PictureUpload
 * Filename		error_reporting.php
 * Author		Steffen Haase
 * Date			13.01.2012
 * License		GPL v3
 */

/*
 * Durch das einstellen des nachfolgenden Parameters
 * schaltet ihr das Error-Reporting des PHP-Interpreters ein,
 * bzw. wieder aus.
 *  
 * Eingeschaltet:
 * ini_set('display_errors', 1);
 * 
 * Ausgeschaltet:
 * ini_set('display_erros', 0);
 */
 
ini_set('display_errors',1);

/*
 * Mit der nachfolgende Zeile kann die Ausgabe des PHP Error-Reportings eingestellt werden.
 * 
 * Anzeigen von Fehlermeldungen wie gewohnt am Anfang der Seite:
 * error_reporting(E_ALL);
 * 
 * Anzeigen von Fehlermeldungen im Debug-Bereich des Addons:
 * error_reporting(0);
 */

error_reporting(E_ALL);

?>