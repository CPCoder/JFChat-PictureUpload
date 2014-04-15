<?php
/*
 * Project		PictureUpload
 * Filename		index.php
 * Author		Steffen Haase
 * Date			13.01.2012
 * License		GPL v3
 */

/*
 * MySQL-Zugangsdaten
 */
$shs_Config['db']['host']							= 'localhost';
$shs_Config['db']['user']							= '';
$shs_Config['db']['pass']							= '';
$shs_Config['db']['name']							= '';
$shs_Config['db']['port']							= 3306;
$shs_Config['db']['pref']							= 'jf_';
$shs_Config['db']['char']							= 'UTF-8';

/*
 * Über den nachfolgenden Parameter kannst du den Zeichensatz festlegen.
 * Dieser Zeichensatz wird für die Ausgabe an den Webbrowser, als auch für
 * das Versenden von eMail genutzt.
 */
$shs_Config['charset']								= 'UTF-8';

// Domain unter dem das Addon läuft
// Bsp.: domain.tld, oder www.domain.tld
$shs_Config['install']['domain']					= 'example.org';
// Server-Pfad zur Addon-Installation
$shs_Config['install']['server']					= '/var/www/picupload/';
// HTTP-Pfad zur Addon-Installation
$shs_Config['install']['http']						= '/picupload/';

/*
 * JFChat-Community
 * Hier stellst du die Parameter (Domain, Port usw.) für deine JFChat-Community ein
 */
// JFChat-Domain
// Bsp.: domain.tld, oder www.domain.tld
$shs_Config['jfchat']['domain']						= 'example.org';
// JFChat-Port
$shs_Config['jfchat']['port']						= 9090;
//JFChat-Comstring
$shs_Config['jfchat']['comstring']					= '/servlet/jfchat';
// Name der Community
$shs_Config['jfchat']['comname']					= 'SHS-Community';

/*
 * Debug Modus
 * Nachfolgend kann der Debug-Modus aktiviert oder deaktiviert werden.
 * 
 * Desweiteren kann über den zweiten Parameter die Anzeige der MySQL-Querys 
 * an- und abgeschaltet werden. Diesen Parameter sollte man eigentlich nur dann 
 * aktivieren, wenn man seine MySQL-Querys überprüfen will, da die Debugausgabe 
 * sonst sehr lang werden kann! MySQL-Fehlermeldungen werden auch bei deaktiviertem
 * Parameter angezeigt!
 */
// Aktiviert den DEBUG-MODE
$shs_Config['debug']['active']						= true;
$shs_Config['debug']['querys']						= false;

// Sprache
$shs_Config['language']								= 'german';

// Max. Breite eines Bildes in Pixel
$shs_Config['pictures']['maxwidth']					= 800;
// Max. H�he eines Bildes in Pixel
$shs_Config['pictures']['maxheight']				= 600;
// Max. Dateigr�sse eines Bildes in Kilobyte
$shs_Config['pictures']['maxsize']					= 500;
// Wenn Bilder im regulären JFChat Bilder-Verzeichnis gespeichert werden sollen, dann
// bitte die Variable "$pictures['db']" so setzen:
// $shs_Config['pictures']['db'] = '../bilder/';
$shs_Config['pictures']['db']						= '';
// Defaultbild wenn kein Profilfoto vorhanden
// Dieses Bild muss im Verzeichnis liegen, in dem auch die Freigeschalteten Bilder liegen!
$shs_Config['pictures']['default']					= 'nopicture.gif';
// Verzeichnis wo hochgeladene Bilder nach der Freischaltung gespeichert werden
$shs_Config['pictures']['path']['server']['save']	= '/var/www/picupload/pictures/';
// Verzeichnis wo hochgeladene Bilder vor der Freischaltung gespeichert werden
$shs_Config['pictures']['path']['server']['up']		= '/var/www/picupload/picturesupload/';
// HTTP-Pfad f�r neue Profil-Bilder
$shs_Config['pictures']['path']['http']['up']		= '/picupload/picturesupload/';

?>
