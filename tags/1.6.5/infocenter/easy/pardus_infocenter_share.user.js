<?php

function reject(){
	header('WWW-Authenticate: Basic realm="My Realm"');
	header('HTTP/1.0 401 Unauthorized');
	echo 'Text to send if user hits Cancel button';
	exit;
}

if (!isset($_SERVER['PHP_AUTH_USER'])) {
	reject();

} else {
	// check password
	@include_once("../modules/account.php");
	include_once("../modules/security_mod.php");
	include_once("../modules/settings_mod.php");
	session_name(SettingsMod::SESSION_NAME);
	session_start();
	$_REQUEST['acc'] = $_SERVER['PHP_AUTH_USER'];
	$_REQUEST['pwd'] = $_SERVER['PHP_AUTH_PW'];
	$acc = SecurityMod::checkLogin();
	if (is_null($acc))
		reject();

	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

	header("Content-Description: File Transfer");

	$contents = file_get_contents("pardus_infocenter_share.data.js");
	$contents = str_replace(
		"<INFOCENTER_NAME>", SettingsMod::EASY_NAME, $contents
	);
	$contents = str_replace(
		"<INFOCENTER_URL>", SettingsMod::EASY_URL, $contents
	);
	$contents = str_replace(
		"<UNIVERSE>", strtolower($acc->getUniverse()), $contents
	);
	$contents = str_replace("<USERNAME>", $_SERVER['PHP_AUTH_USER'], $contents);
	$contents = str_replace("<PASSWORD>", $_SERVER['PHP_AUTH_PW'], $contents);
	echo $contents;
}

?>
