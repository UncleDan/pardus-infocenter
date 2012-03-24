<?php
	require_once("global.php");
	require_once("modules/security_mod.php");
	require_once("modules/hack_mod.php");
	require_once("modules/level_mod.php");

	SecurityMod::login();

	if (!SettingsMod::ENABLE_HACK_SHARE)
		SecurityMod::logout();
	
	$level = $_SESSION["account"]->getLevel();
	if ($level != 'Admin')
		SecurityMod::logout();

	$hack = HackMod::getHack(v($_REQUEST, "id"));

	HackMod::deleteHack($hack);

	header('location: hacks.php?universe=' . $hack["universe"]);
?>
