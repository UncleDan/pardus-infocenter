<?php
	require_once("global.php");
	require_once("modules/security_mod.php");
	require_once("modules/account_mod.php");
	require_once("modules/level_mod.php");
	require_once("page_navigator.php");

	SecurityMod::login();

	$level = $_SESSION["account"]->getLevel();
	if ($level != "Admin")
		SecurityMod::logout();

	$acc = AccountMod::getAccount(v($_REQUEST, "name"));
?>
<html>
<head>
<title><?php echo(SettingsMod::PAGE_TITLE." :: Account Password"); ?></title>
<link rel="stylesheet" href="main.css">
</head>
<body>
<center>
<form method="post" action="account_password_confirm.php">
<input type="hidden" name="name" value="<?php echo($acc->getName()); ?>" />
<table background="<?php echo(SettingsMod::STATIC_IMAGES)?>/bgd.gif" class="messagestyle" align="center">
<tr>
	<th>Username:</th>
	<td style="text-align: center"><?php echo($acc->getName()); ?></td>
</tr>
<tr>
	<th>Password:</th>
	<td><input type="text" name="password" style="width: 100%" /></td>
</tr>
<tr>
	<th>Password Confirm:</th>
	<td><input type="text" name="password_confirm" style="width: 100%" /></td>
</tr>
</table>

<br /><br />
<input type="button" value="Cancel" onclick="history.go(-1);" />
<br /><br />
<input type="submit" value="Set Password" />

</form>
</center>
</body>
</html>
