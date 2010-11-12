<?php
	require_once("global.php");
	require_once("modules/security_mod.php");
	require_once("modules/account_mod.php");

	SecurityMod::login();

	$level = $_SESSION["account"]->getLevel();
	if ($level != 'Admin')
		SecurityMod::logout();

	$acc = AccountMod::getAccount(v($_REQUEST, "name"));

?>
<html>
<head>
<title><?php echo(SettingsMod::PAGE_TITLE." :: Account Delete"); ?></title>
<link rel="stylesheet" href="main.css">
<script src="main.js" type="text/javascript"></script>
</head>
<body>
<center>
<form method="POST" action="account_delete_confirm.php">
<input type="hidden" name="name" value="<?php echo($acc->getName()); ?>" />
Are you sure you wish to delete the account "<?php echo($acc->getName()); ?>"?
<br /><br />
<input type="button" value="Cancel" onclick="history.go(-1);" />
<br /><br />
<input type="submit" value="Delete Account" />
</form>
</center>
</body>
</html>
