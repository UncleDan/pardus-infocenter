<?php
	require_once("global.php");
	require_once("modules/security_mod.php");
	require_once("modules/payment_mod.php");
	SecurityMod::login();

	if ($_SESSION["account"]->getLevel() != "Admin") {
		echo("Insufficient security level");
	}

	PaymentMod::updateLevel(v($_REQUEST, "id"), v($_REQUEST, "level"));

	header("Location: payments.php");

?>
