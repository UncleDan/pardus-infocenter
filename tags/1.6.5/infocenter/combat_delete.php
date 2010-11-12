<?php
	require_once("global.php");
	require_once("modules/security_mod.php");
	require_once("modules/combat_mod.php");

	SecurityMod::login();

	if (!SettingsMod::ENABLE_COMBAT_SHARE)
		SecurityMod::logout();

	$level = $_SESSION["account"]->getLevel();
	if ($level != "Admin")
		SecurityMod::logout();

?>
<html>
<head>
<title><?php echo(SettingsMod::PAGE_TITLE." :: Combat Delete"); ?></title>
<link rel="stylesheet" href="main.css">
<script src="main.js" type="text/javascript"></script>
</head>
<body>
<center>
<form method="POST" action="combat_delete_confirm.php">
<input type="hidden" name="id" value="<?php echo(v($_REQUEST, "id")); ?>" />
Are you sure you wish to delete this combat?
<br /><br />
<input type="button" value="Cancel" onclick="history.go(-1);" />
<br /><br />
<input type="submit" value="Delete Combat" />
</form>
</center>
</body>
</html>
