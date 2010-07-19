<?php
	require_once("global.php");
	require_once("modules/security_mod.php");
	require_once("modules/hack_mod.php");
	SecurityMod::login();

	if ($_SESSION["account"]->getLevel() != "Admin") {
		echo("Insufficient security level");
	}

	HackMod::updateLevel(v($_REQUEST, "id"), v($_REQUEST, "level"));

	header(sprintf(
		"Location: hack_details.php?id=%d",
		$_REQUEST["id"]
	));

?>
