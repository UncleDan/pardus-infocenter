<?php
	require_once("global.php");
	require_once("modules/security_mod.php");
	require_once("modules/mission_mod.php");
	require_once("modules/level_mod.php");

	SecurityMod::login();

	if (!SettingsMod::ENABLE_MISSION_SHARE)
		SecurityMod::logout();
	
	$level = $_SESSION["account"]->getLevel();
	if ($level != 'Admin')
		SecurityMod::logout();

	MissionMod::clearMissions($_SESSION["account"]->getUniverse(), v($_REQUEST, "days"));

	header('location: missions.php?universe=' . $_SESSION["account"]->getUniverse());
?>
