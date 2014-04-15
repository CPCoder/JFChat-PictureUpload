<?php
/*
 * Project		
 * Filename		deleteprofpic.php
 * Author		Steffen Haase
 * Date			14.01.2012
 * License		GPL v3
 */

require_once 'classes/Shs/TplEngine.php';
require_once 'classes/Shs/Request.php';
require_once 'classes/Shs/DbConnect.php';
require_once 'classes/Shs/File.php';
require_once 'lang/lang_'.SHS_LANG.'.php';

$shs_GetPost = Request::getInstance();
$shs_Template = TplEngine::getInstance();
$shs_DB = DBConnect::getInstance();
$shs_Template->openTemplate('messages');
$error = '';

if (
$shs_GetPost->_isSet('sessionID') &&
$shs_GetPost->_isSet('userID')
) {
	if (strpos($shs_GetPost->getString('sessionID'), 'jsessionid=') !== false) {
		$ex = explode('=', $shs_GetPost->getString('sessionID'));
		$sessionID = $ex[1];
	} else {
		$sessionID = $shs_GetPost->getString('sessionID');
	}
	$result = $shs_DB->queryObjectArray(
		"SELECT sid FROM ".TABLE_JF_REGISTRY." ".
		"WHERE id='".$shs_DB->escapeString($shs_GetPost->getInt('userID'))."'"
	, 'upload.php');
	if ($result === false) {
		$flag = false;
		$error = $shs_Language['error']['mysql'];
	} elseif ($result === null) {
		$flag = false;
		$error = $shs_Language['error']['unknownuserid'];
	} elseif ($result[0]->sid != $sessionID) {
		$flag = false;
		$error = $shs_Language['error']['unknownsessionid'];
	} else {
		$flag = true;
		$save = $shs_Config['pictures']['path']['server']['save'].$shs_GetPost->getInt('userID').'.jpg';
	}
	$file = new File();
	if (!$file->deleteFile($save)) {
		$flag = false;
		$error = $shs_Language['error']['notdeleted'];
	}
	if ($flag === true) {
		$image = $shs_Config['pictures']['db'].$shs_Config['pictures']['default'];
		$dummy = $shs_DB->executeQuery(
			"UPDATE ".TABLE_JF_REGISTRY." ".
			"SET bild='".$image."', bildlocked='0'".
			"WHERE id='".$shs_DB->escapeString($shs_GetPost->getInt('userID'))."'"
		, 'upload.php');
		if (!$dummy) {
			$flag = false;
			$error = $shs_Language['error']['mysql'];
		}
	}
	if ($flag === true) {
		$shs_Template->assignVars(array(
			'type' => $shs_Language['msgtype']['system'],
			'message' => $shs_Language['system']['deleted']
		));
	}
	if ($flag === false) {
		$error = str_replace(
			'{MESSAGE}',
		$error,
		$shs_Language['error']['wrapper']
		);
		$shs_Template->assignVars(array(
			'type' => $shs_Language['msgtype']['error'],
			'message' => $error
		));
	}
} else {
	$error = str_replace(
		'{MESSAGE}',
	$shs_Language['error']['missingparameters'],
	$shs_Language['error']['wrapper']
	);
	$shs_Template->assignVars(array(
		'type' => $shs_Language['msgtype']['error'],
		'message' => $error
	));
}

?>