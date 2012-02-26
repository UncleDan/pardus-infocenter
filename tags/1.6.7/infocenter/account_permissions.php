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
	$permissions = $acc->getPermissions();

	$levels = LevelMod::getLevels();
?>
<html>
<head>
<title><?php echo(SettingsMod::PAGE_TITLE." :: Account Password"); ?></title>
<link rel="stylesheet" href="main.css">
</head>
<body>
<center>
<form method="post" action="account_permissions_confirm.php">
<input type="hidden" name="name" value="<?php echo($acc->getName()); ?>" />
<table background="<?php echo(SettingsMod::STATIC_IMAGES)?>/bgd.gif" class="messagestyle" align="center">
<tr>
	<th>Username:</th>
	<td style="text-align: center"><?php echo($acc->getName()); ?></td>
</tr>
<tr>
	<th>View&nbsp;Permissions:</th>
	<td>
		<?php foreach(Permissions::$view_perms as $key => $perm): ?>
		<input type="checkbox" name="<?php echo($key); ?>" value="<?php echo($key); ?>"<?php if ($permissions->has(eval("return Permissions::{$key};"))) echo ' checked="checked"'; ?> />&nbsp;<?php echo($perm); ?>
		<br />
		<?php endforeach; ?>
	</td>
</tr>
<tr>
	<th>Modify&nbsp;Permissions:</th>
	<td>
		<?php foreach(Permissions::$modify_perms as $key => $perm): ?>
		<input type="checkbox" name="<?php echo($key); ?>" value="<?php echo($key); ?>"<?php if ($permissions->has(eval("return Permissions::{$key};"))) echo ' checked="checked"'; ?> />&nbsp;<?php echo($perm); ?>
		<br />
		<?php endforeach; ?>
	</td>
</tr>
<tr>
	<th>
		View&nbsp;Only
		<br />
		(overrides&nbsp;above&nbsp;permissions)
	</th>
	<td>
		<input type="checkbox" name="VIEW_ONLY"<?php if ($permissions->get() == Permissions::VIEW_ONLY) echo ' checked="checked"'; ?> />
	</td>
</tr>
<tr>
	<th>
		Ban&nbsp;User
		<br />
		(overrides&nbsp;above&nbsp;permissions)
	</th>
	<td>
		<input type="checkbox" name="BANNED"<?php if ($permissions->get() == Permissions::BANNED) echo ' checked="checked"'; ?> />
	</td>
</tr>
<tr>
	<th>Security&nbsp;Level</th>
	<td>
		<select name="level" style="width: 100%">
		<?php foreach($levels as $level): ?>
			<option<?php if ($level->getName() == $acc->getLevel()) echo ' selected="selected"'; ?>><?php echo($level->getName()); ?></option>
		<?php endforeach; ?>
		</select>
	</td>
</tr>
</table>

<br /><br />
<input type="button" value="Cancel" onclick="history.go(-1);" />
<br /><br />
<input type="submit" value="Set Permissions" />

</form>
</center>
</body>
</html>
