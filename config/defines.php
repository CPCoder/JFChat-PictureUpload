<?php
/*
 * Project		PictureUpload
 * Filename		defines.php
 * Author		Steffen Haase
 * Date			13.01.2012
 * License		GPL v3
 */

/*
 * Hier wird die Datenbank Konfiguration als Konstanten definiert
 */
define('SHS_DB_HOST',				$shs_Config['db']['host']);
define('SHS_DB_USER',				$shs_Config['db']['user']);
define('SHS_DB_PASS',				$shs_Config['db']['pass']);
define('SHS_DB_NAME',				$shs_Config['db']['name']);
define('SHS_DB_PORT',				$shs_Config['db']['port']);
define('SHS_DB_PREF',				$shs_Config['db']['pref']);
define('SHS_DB_CHAR',				$shs_Config['db']['char']);

/*
 * Hier werden die Datenbank Tabellen als Konstanten definiert
 */
define('TABLE_JF_REGISTRY',			SHS_DB_PREF.'registry');

/*
 * Hier werden sonstige Konstanten definiert
 */
define('SHS_DEBUGMODE',				$shs_Config['debug']['active']);
define('SHS_DEBUG_QUERYS',			$shs_Config['debug']['querys']);
define('SHS_PATH_SERVER',			$shs_Config['install']['server']);
define('SHS_PATH_HTTP',				$shs_Config['install']['http']);
define('SHS_DOMAIN',				$shs_Config['install']['domain']);
define('SHS_LANG',					$shs_Config['language']);
define('SHS_CHARSET',				$shs_Config['charset']);
define('SHS_COMPLETE_URL', 			'http://'.SHS_DOMAIN.SHS_PATH_HTTP);


/*
 * JFChat-Konstanten
 * Diese Parameter bitte nicht ändern!
 */
define('JFCHAT_COMNAME',			$shs_Config['jfchat']['comname']);
define('JFCHAT_DOMAIN',				$shs_Config['jfchat']['domain']);
define('JFCHAT_PORT',				$shs_Config['jfchat']['port']);
define('JFCHAT_COMSTRING',			$shs_Config['jfchat']['comstring']);
define('JFCHAT_COMPLETEURL',		'http://'.JFCHAT_DOMAIN.':'.JFCHAT_PORT.JFCHAT_COMSTRING);

?>