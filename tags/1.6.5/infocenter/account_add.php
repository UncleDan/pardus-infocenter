<?php
	require_once("global.php");
	require_once("modules/security_mod.php");
	require_once("modules/level_mod.php");
	require_once("modules/settings_mod.php");
	require_once("modules/permissions.php");
	require_once("npc_images.php");
	SecurityMod::login();

	$level = $_SESSION["account"]->getLevel();
	if ($level != "Admin")
		SecurityMod::logout();

	// check if passwords match
	if (v($_REQUEST, "password") != v($_REQUEST, "password_confirm")) {
		header('location: accounts.php');
		exit;
	}

	// encrypt password if necessary
	if (SettingsMod::USE_ENCRYPTED_PASSWORDS) {
		$password = md5(v($_REQUEST, "password"));
	} else {
		$password = v($_REQUEST, "password");
	}

	AccountMod::addAccount(
		new Account(
			v($_REQUEST, "name"),
			$password,
			$_SESSION["account"]->getUniverse(),
			Permissions::DEFAULT_PERMISSIONS,
			v($_REQUEST, "level")
		)
	);

	header('location: accounts.php');
?>
