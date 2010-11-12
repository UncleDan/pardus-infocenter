<?php
	require_once("global.php");
	require_once("modules/security_mod.php");
	require_once("modules/combat_mod.php");
	require_once("modules/level_mod.php");
	$acc = SecurityMod::checkLogin();
	if (is_null($acc)) {
		echo("Invalid credentials");
		exit;
	}

	if (!SettingsMod::ENABLE_COMBAT_SHARE) {
		echo("Feature disabled");
		exit;
	}
	
	$permissions = $acc->getPermissions();
	if (!$permissions->has(Permissions::ADD_COMBATS)) {
		echo("Insufficient permissions");
		exit;
	}

	// handle level input, or lack thereof
	if (isset($_REQUEST["level"])) {
		$user_level = v($_REQUEST, "level");
		$levels = LevelMod::getLevels($acc);
		$found = false;
		foreach($levels as $level) {
			if($level->getName() == $user_level) {
				$found = true;
				break;
			}
		}
		if (!$found) {
			$level = "Confidential";
		} else {
			$level = $user_level;
		}
	} else {
		$level = "Confidential";
	}

	// insert combat
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
				$level,
				v($_REQUEST, "data")
			)
		);
	if ($res)
		echo("Ok");
	else
		echo("Internal error");
?>
