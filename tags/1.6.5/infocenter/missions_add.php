<?php
	require_once("global.php");
	require_once("modules/security_mod.php");
	require_once("modules/mission_mod.php");

	$acc = SecurityMod::checkLogin();
	if (is_null($acc)) {
		echo("Invalid credentials");
		exit;
	}
	
	if (!SettingsMod::ENABLE_MISSION_SHARE) {
		echo("Feature disabled");
		exit;
	}
	
	$permissions = $acc->getPermissions();
	if (!$permissions->has(Permissions::ADD_MISSIONS)) {
		echo("Insufficient permissions");
		exit;
	}
	
	$res = MissionMod::addMissions($acc->getUniverse(), stripslashes($_REQUEST["missions"]));
	if ($res)
		echo("Ok");
	else
		echo("Internal error");
?>
