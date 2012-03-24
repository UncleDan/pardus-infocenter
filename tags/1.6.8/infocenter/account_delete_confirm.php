<?php
	require_once("global.php");
	require_once("modules/security_mod.php");
	require_once("modules/level_mod.php");

	SecurityMod::login();

	$level = $_SESSION["account"]->getLevel();
	if ($level != 'Admin')
		SecurityMod::logout();

	$acc = AccountMod::getAccount(v($_REQUEST, "name"));

	AccountMod::deleteAccount($acc);

	header('location: accounts.php');
?>
