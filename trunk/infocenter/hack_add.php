<?php
	require_once("global.php");
	require_once("modules/security_mod.php");
	require_once("modules/hack_mod.php");

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
	if (!$permissions->has(Permissions::ADD_HACKS)) {
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

	$res = HackMod::addHack($acc->getUniverse(), stripslashes($_REQUEST["data"]), $level);
	if ($res)
		echo("Ok");
	else
		echo("Internal error");
?>
