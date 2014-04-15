<?php
/*
 * Project		PictureUpload
 * Filename		upload.php
 * Author		Steffen Haase
 * Date			13.01.2012
 * License		GPL v3
 */

require_once 'classes/Shs/TplEngine.php';
require_once 'classes/Shs/Request.php';
require_once 'classes/Shs/File.php';
require_once 'classes/Shs/DbConnect.php';
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
		$save = $shs_Config['pictures']['path']['server']['up'].$shs_GetPost->getInt('userID').'.jpg';
	}
	if ($flag === true) {
		$info = getimagesize($_FILES["picture"]["tmp_name"]);
		$imgwidth = $info[0];
		$imgheight = $info[1];
		$imgtype = $info[2];
		if ($info[2] != 2) {
			$flag = false;
			$error .= $shs_language['error']['wrongtype'];
		}
		if (
			$info[0] > $shs_Config['pictures']['maxwidth'] || 
			$info[1] > $shs_Config['pictures']['maxheight']
		) {
			$flag = false;
			$tmp = str_replace(
				'{WIDTH}',
				$shs_Config['pictures']['maxwidth'],
				$shs_language['error']['wrongdimensions']
			);
			$error .= str_replace(
				'{HEIGHT}',
				$shs_Config['pictures']['maxheight'],
				$tmp
			);
		}
		if (
			(filesize($_FILES['picture']['tmp_name'])) > 
			($shs_Config['pictures']['maxsize']*1024)
		) {
			$flag = false;
			$error .= str_replace(
				'{SIZE}',
				$shs_Config['pictures']['maxsize'],
				$shs_language['error']['wrongfilesize']
			);			
		}
	}
	if ($flag === true) {
			$file = new File();
			$file->deleteFile($save);
		if (!move_uploaded_file($_FILES["picture"]["tmp_name"], $save)) {
			$flag = false;
			$error = $shs_Language['error']['notsaved'];
		}
	}
	if ($flag === true) {
		$dummy = $shs_DB->executeQuery(
			"UPDATE ".TABLE_JF_REGISTRY." ".
			"SET bildlocked='1' ".
			"WHERE id='".$shs_DB->escapeString($shs_GetPost->getInt('userID'))."'"
		, 'upload.php');
		if (!$dummy) {
			$flag = false;
			$file = new File();
			$file->deleteFile($save);
			$error = $shs_Language['error']['notsaved'];
		}
	}
	if ($flag === true) {
		$shs_Template->assignVars(array(
			'type' => $shs_Language['msgtype']['system'],
			'message' => $shs_Language['system']['saved']
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