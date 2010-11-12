<?php
	require_once("global.php");
	require_once("modules/security_mod.php");
	require_once("modules/combat_mod.php");

	SecurityMod::login();

	if ($_SESSION["account"]->getLevel() != "Admin") {
		echo("Insufficient security level");
	}

	// calculate permissions
	if (isset($_REQUEST['BANNED'])) {
		$permissions = Permissions::BANNED;
	} elseif (isset($_REQUEST['VIEW_ONLY'])) {
		$permissions = Permissions::VIEW_ONLY;
	} else {
		$permissions = 0;
		foreach (Permissions::$view_perms as $key => $perm) {
			if (!isset($_REQUEST[$key])) {
				$permissions += eval("return Permissions::{$key};");
			}
		}
		foreach (Permissions::$modify_perms as $key => $perm) {
			if (!isset($_REQUEST[$key])) {
				$permissions += eval("return Permissions::{$key};");
			}
		}
	}

	// update permissions
	AccountMod::updatePermissions(v($_REQUEST, "name"), $permissions);

	// update level
	AccountMod::updateLevel(v($_REQUEST, "name"), v($_REQUEST, "level"));

	header("Location: accounts.php");

?>
