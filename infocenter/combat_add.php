<?php
	require("modules/security_mod.php");
	require("modules/combat_mod.php");
	$acc = SecurityMod::checkLogin();
	if (is_null($acc)) {
		echo("Invalid credentials");
		exit;
	}

	if (!SettingsMod::ENABLE_COMBAT_SHARE) {
		echo("Feature disabled");
		exit;
	}
	
	if (!SecurityMod::checkPermission("combat-share")) {
		echo("Insufficient permissions");
		exit;
	}
	
	$res =
		CombatMod::addCombat(
			new Combat(
				null,
				v($_REQUEST, "pid"),
				$acc->getUniverse(),
				v($_REQUEST, "type"),
				v($_REQUEST, "when"),
				v($_REQUEST, "sector"),
				v($_REQUEST, "coords"),
				v($_REQUEST, "attacker"),
				v($_REQUEST, "defender"),
				v($_REQUEST, "outcome"),
				v($_REQUEST, "additional"),
				v($_REQUEST, "data")
			)
		);
	if ($res)
		echo("Ok");
	else
		echo("Internal error");
?>