<?php
/*
 * Project		PictureUpload
 * Filename		lang_german.php
 * Author		Steffen Haase
 * Date			14.01.2012
 * License		GPL v3
 */

/*
 * Systemmeldungs-Typen
 */
$shs_Language['msgtype']['error']			= 'Fehler';
$shs_Language['msgtype']['system']			= 'Systemmeldung';

/*
 * Systemmeldungen
 */
$shs_Language['system']['saved']			= 'Das Bild wurde erfolgreich hochgeladen und muss jetzt noch durch einen '.
												'Administrator begutachtet werden. Diese Begutachtung erfolgt in der '.
												'Regel innerhalb von 48 Stunden.<br><br><a href="{COMURL}auth=1&amp;'.
												'profil=fu&amp;design=0">Zur&uuml;ck</a><br>';
$shs_Language['system']['deleted']			= 'Das Bild wurde gel&ouml;scht<br><br><a href="{COMURL}auth=1&amp;profil=fu&amp;'.
												'design=0">Zur&uuml;ck</a><br>';
/*
 * Fehlermeldungen
 */
$shs_Language['error']['wrapper']			= '<div id="errors">{MESSAGE}<br><a href="{COMURL}auth=1&amp;profil=fu&amp;'.
												'design=0">Zur&uuml;ck</a><br></div>';
$shs_Language['error']['unknownuserid']		= 'Unbekannte UserID!<br>';
$shs_Language['error']['unknownsessionid']	= 'Unbekannte SessionID!<br>';
$shs_language['error']['wrongtype']			= 'Es sind nur JPEG-Bilder (*.jpg, *.jpeg) zugelassen!<br>';
$shs_language['error']['wrongdimensions']	= 'Das Bild darf max. {WIDTH} Pixel Breit und {HEIGHT} Pixel Hoch sein!<br>';
$shs_language['error']['wrongfilesize']		= 'Das Bild darf max. {SIZE} Kilobyte gross sein !<br>';
$shs_Language['error']['missingparameters']	= 'UserID oder SessionID fehlt!<br>';
$shs_Language['error']['notsaved']			= 'Das Bild konnte leider nicht gespeichert werden!<br>Bitte versuche es '.
												'sp&auml;ter noch einmal. Sollte der Fehler dann immer noch bestehen, '.
												'so wende dich bitte an den Support.<br>';
$shs_Language['error']['notdeleted']		= 'Das Bild konnte leider nicht gel&ouml;scht werden!<br>Bitte versuche es '.
												'sp&auml;ter noch einmal. Sollte der Fehler dann immer noch bestehen, '.
												'so wende dich bitte an den Support.<br>';


?>