<?php
	require("modules/security_mod.php");
	require("modules/hack_mod.php");

	$acc = SecurityMod::checkLogin();
	if (is_null($acc)) {
		echo("Invalid credentials");
		exit;
	}
	
	if (!SettingsMod::ENABLE_HACK_SHARE) {
		echo("Feature disabled");
		exit;
	}
	
	if (!SecurityMod::checkPermission("hack-share")) {
		echo("Insufficient permissions");
		exit;
	}
	
	$res = HackMod::addHack($acc->getUniverse(), stripslashes($_REQUEST["data"]));
	if ($res)
		echo("Ok");
	else
		echo("Internal error");
?>