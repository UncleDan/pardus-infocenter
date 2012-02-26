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

	$pageNumber = intval(v($_REQUEST, "page"));
	if ($pageNumber < 1)
		$pageNumber = 1;

	function drawNavigator() {
		global $pageCount, $pageNumber;
		$params = "";
		PageNavigator::draw($pageCount, $pageNumber, 33, $params, "accounts.php");
	}

	$accounts = AccountMod::getAccounts($pageNumber, $pageCount);

	$levels = LevelMod::getLevels();
?>
<html>
<head>
<title><?php echo(SettingsMod::PAGE_TITLE." :: Accounts"); ?></title>
<link rel="stylesheet" href="main.css">
</head>
<body>
	<h2 align="center">Account List</h2>
	<table align="center" width="600">
	<tr>
		<td align="center">
			<table background="<?php echo(SettingsMod::STATIC_IMAGES)?>/bgd.gif" class="messagestyle" align="center" width="100%">
			<tr>
				<td colspan="10"><?php drawNavigator()?></td>
			</tr>
			<tr>
				<th>&nbsp;</th>
				<th><u>Name</u></th>
				<th><u>Universe</u></th>
				<th><u>Security</u></th>
				<th><u>Permissions</u></th>
				<th><u>Password</u></th>
				<th><u>Delete</u></th>
			</tr>
			<?php
				$i = 0;
				foreach ($accounts as $acc):
				$i++;
			?>
			<tr bgcolor='#0b0b2f'>
				<td align='right' style='cursor:crosshair'>
					<?php echo(($pageNumber - 1) * SettingsMod::PAGE_RECORDS_PER_PAGE + $i)?>.
				</td>
				<td><?php $acc->drawName(); ?></td>
				<td style="text-align: center">
					<?php echo($acc->getUniverse()); ?>
				</td>

				<td style="text-align: center">
					<?php echo $acc->getLevel(); ?>
				</td>

				<!-- Permissions -->
				<form method="post" action="account_permissions.php">
				<td style="text-align: center">
					<input type="hidden" name="name" value="<?php echo($acc->getName()); ?>" />
					<input type="submit" value="Permissions" />
				</td>
				</form>

				<!-- Password -->
				<form method="post" action="account_password.php">
				<td style="text-align: center">
					<input type="hidden" name="name" value="<?php echo($acc->getName()); ?>" />
					<input type="submit" value="Password" />
				</td>
				</form>

				<!-- Delete -->
				<form action="account_delete.php" method="get">
				<td style="text-align: center">
						<input type="hidden" name="name" value="<?php echo($acc->getName()); ?>" />
						<input type="submit" value="Delete" />
				</td>
				</form>
			</tr>
			<?php endforeach; ?>
			<tr>
				<td colspan="99"><?php drawNavigator()?></td>
			</tr>
		</td>
	</tr>
	</table>

	<br />
	<h2 align="center">Create Account</h2>
	<form method="post" action="account_add.php">
	<table background="<?php echo(SettingsMod::STATIC_IMAGES)?>/bgd.gif" class="messagestyle" align="center">
	<tr>
		<th>Username:</th>
		<td><input type="text" name="name" style="width: 100%" /></td>
	</tr>
	<tr>
		<th>Password:</th>
		<td><input type="text" name="password" style="width: 100%" /></td>
	</tr>
	<tr>
		<th>Password Confirm:</th>
		<td><input type="text" name="password_confirm" style="width: 100%" /></td>
	</tr>
	<tr>
		<th>Security Level:</th>
		<td>
		<select name="level" style="width: 100%">
		<?php foreach($levels as $level): ?>
			<option><?php echo($level->getName()); ?></option>
		<?php endforeach; ?>
		</select>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" value="Create Account" style="width: 100%" /></td>
	</tr>
	</table>
	</form>
</body>
</html>
