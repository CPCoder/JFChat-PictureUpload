<?php
/*
 * Project		PictureUplaod
 * Filename		index.php
 * Author		Steffen Haase
 * Date			13.01.2012
 * License		GPL v3
 */

define('SHS_SCRIPT_STARTTIME', microtime(true));
define('SHS_VERSION', '0.2');

if (version_compare(PHP_VERSION, '5.3','<')) {
	echo '<br><br><center>'.
			'<h2>!! Fatal Error !!</h4>'.
			'Um das Addon "JFChat PictureUpload" einsetzen zu k&ouml;nnen muss mind. PHP 5.3 installiert sein!<br><br>'.
			'<u>Installierte PHP-Version:</u><br>'.PHP_VERSION.'<br><br>'.
			'<u>Ben&ouml;tigte Mindest-PHP-Version</u><br>5.3.0';
	exit;
}
require_once 'config/error_reporting.php';
require_once 'config/config.php';
require_once 'config/defines.php';
require_once 'classes/Shs/TplEngine.php';
require_once 'classes/Shs/Request.php';
require_once 'classes/Shs/ErrorHandler.php';
require_once 'classes/Shs/DebugManager.php';

if (SHS_DEBUGMODE === true) {
	$shs_Debugger = DebugManager::getInstance();
	$old_error_handler = set_error_handler(array("ErrorHandler", "handleErrors"));
}
$shs_GetPost = Request::getInstance();
$shs_Template = TplEngine::getInstance();

if (
	$shs_GetPost->_isSet('node') &&
	$shs_GetPost->getString('node') == 'upload'
) {
	include 'include/upload.php';
} elseif (
	$shs_GetPost->_isSet('node') &&
	$shs_GetPost->getString('node') == 'delete'
) {
	include 'include/delete.php';
} elseif (
	$shs_GetPost->_isSet('node') &&
	$shs_GetPost->getString('node') == 'deleteprofpic'
) {
	include 'include/deleteprofpic.php';
}

$shs_Template->assignVar('charset', SHS_CHARSET);
if ($shs_Template->existsVar('shs_version')) {
	$shs_Template->assignVar('shs_version', SHS_VERSION);
}
if ($shs_Template->existsVar('comurl')) {
	$comurl = 'http://'.$shs_Config['jfchat']['domain'].':'.$shs_Config['jfchat']['port'].
				$shs_Config['jfchat']['comstring'].$shs_GetPost->getString('sessionID').'?';
	$shs_Template->assignVar('comurl', $comurl);
}
$shs_Template->removeEmptyVars();
if(SHS_DEBUGMODE) {
	$shs_Debugger->addDebugBox();
}
$shs_Template->printTemplate();

?>