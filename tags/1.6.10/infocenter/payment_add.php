<?php
	require_once("global.php");
	require_once("modules/security_mod.php");
	require_once("modules/payment_mod.php");
	$acc = SecurityMod::checkLoginFromScript();
	if (is_null($acc)) {
		echo("Invalid credentials");
		exit;
	}

	if (!SettingsMod::ENABLE_PAYMENT_SHARE) {
		echo("Feature disabled");
		exit;
	}
	
	$permissions = $acc->getPermissions();
	if (!$permissions->has(Permissions::ADD_PAYMENTS)) {
		echo("Insufficient permissions");
		exit;
	}

	$payer = ($_REQUEST["receiver"] == 1 ? v($_REQUEST, "pilot"): $acc->getName());
	$receiver = ($_REQUEST["receiver"] == 1 ? $acc->getName(): v($_REQUEST, "pilot"));

	if(v($_REQUEST, "type") == "Alliance Tax")
		$receiver = 'Alliance';

	if(v($_REQUEST, "type") == "Alliance Fund") {
		if ($_REQUEST["receiver"] == 1) {
			$payer = 'Alliance';
		} else {
			$receiver = 'Alliance';
		}
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

	// insert payment
	$res =
		PaymentMod::addPayment(
			new Payment(
				null,
				$acc->getUniverse(),
				v($_REQUEST, "when"),
				v($_REQUEST, "type"),
				v($_REQUEST, "location"),
				$payer,
				$receiver,
				intval($_REQUEST["credits"]),
				$level
			)
		);
	if ($res)
		echo("Ok");
	else
		echo("Internal error");
?>
