<?php
	require_once("global.php");
	require_once("modules/security_mod.php");
	require_once("modules/level_mod.php");

	SecurityMod::login();

	$level = $_SESSION["account"]->getLevel();
	if ($level != 'Admin')
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

	$acc = AccountMod::getAccount(v($_REQUEST, "name"));

	AccountMod::updatePassword($acc->getName(), $password);

	header('location: accounts.php');
?>
