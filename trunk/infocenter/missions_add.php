<?php
	require("modules/security_mod.php");
	require("modules/mission_mod.php");

	$acc = SecurityMod::checkLogin();
	if (is_null($acc)) {
		echo("Invalid credentials");
		exit;
	}
	
	if (!SettingsMod::ENABLE_MISSION_SHARE) {
		echo("Feature disabled");
		exit;
	}
	
	if (!SecurityMod::checkPermission("mission-share")) {
		echo("Insufficient permissions");
		exit;
	}
	
	$res = MissionMod::addMissions($acc->getUniverse(), stripslashes($_REQUEST["missions"]));
	if ($res)
		echo("Ok");
	else
		echo("Internal error");
?>