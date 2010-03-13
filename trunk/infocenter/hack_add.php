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
	
	$permissions = $acc->getPermissions();
	if ( !($permissions==2 || $permissions==3 || $permissions==7 || $permissions==9) ) {
		echo("Insufficient permissions");
		exit;
	}
	
	$res = HackMod::addHack($acc->getUniverse(), stripslashes($_REQUEST["data"]));
	if ($res)
		echo("Ok");
	else
		echo("Internal error");
?>