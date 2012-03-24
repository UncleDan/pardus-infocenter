<?php
	require_once("global.php");
	require_once("modules/security_mod.php");
	require_once("modules/hack_mod.php");

	SecurityMod::login();

	if (!SettingsMod::ENABLE_HACK_SHARE)
		SecurityMod::logout();

	$level = $_SESSION["account"]->getLevel();
	if ($level != "Admin")
		SecurityMod::logout();

?>
<html>
<head>
<title><?php echo(SettingsMod::PAGE_TITLE." :: Hack Delete"); ?></title>
<link rel="stylesheet" href="main.css">
<script src="main.js" type="text/javascript"></script>
</head>
<body>
<center>
<form method="POST" action="hack_delete_confirm.php">
<input type="hidden" name="id" value="<?php echo(v($_REQUEST, "id")); ?>" />
Are you sure you wish to delete this hack?
<br /><br />
<input type="button" value="Cancel" onclick="history.go(-1);" />
<br /><br />
<input type="submit" value="Delete Hack" />
</form>
</center>
</body>
</html>
