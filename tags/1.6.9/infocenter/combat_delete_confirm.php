<?php
	require_once("global.php");
	require_once("modules/security_mod.php");
	require_once("modules/combat_mod.php");
	require_once("modules/level_mod.php");

	SecurityMod::login();

	if (!SettingsMod::ENABLE_COMBAT_SHARE)
		SecurityMod::logout();
	
	$level = $_SESSION["account"]->getLevel();
	if ($level != 'Admin')
		SecurityMod::logout();

	$cmbt = CombatMod::getCombat(v($_REQUEST, "id"));

	CombatMod::deleteCombat($cmbt);

	header('location: combats.php?universe=' . $cmbt->getUniverse());
?>
