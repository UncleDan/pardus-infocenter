<?php
	require_once("global.php");
	require_once("modules/security_mod.php");
	SecurityMod::login();

	$permissions = $_SESSION["account"]->getPermissions();
	if ($permissions->is_banned())
		SecurityMod::logout();
	$level = $_SESSION["account"]->getLevel();

	$name = $_SESSION["account"]->getName();
	$universe = $_SESSION["account"]->getUniverse();
?>
<html>
<head>
	<title><?php echo(SettingsMod::PAGE_TITLE." :: Index"); ?></title>
	<link rel="stylesheet" href="main.css">
	<link href="<?php echo(SettingsMod::PAGE_FAVICON); ?>" type=image/x-icon rel="shortcut icon">
</head>
<body style="margin:0">
	<table width="100%" height="100%">
	<tr height="20">
		<td align="center"><?php
		echo('<img src="http://static.pardus.at/various/universes/'.strtolower($universe).'_16x16.png"');
		echo(' title="'.$universe.': '.$name.' ('.$level.')" style="vertical-align: middle;" alt="'.$universe.': '.$name.' ('.$level.')"');
		echo(' border="0" height="13" width="13"> '."\n");
		echo('			<span style="font-weight: bold;">'.$name.'</span> <span style="font-weight: bold; color: #FF0000">('.$level.')</span> | '."\n");
		if (SettingsMod::ENABLE_MAIN_PAGE)
			echo('			<a href="main.php" target="mainFrame">Main</a> | '."\n");
		if (SettingsMod::ENABLE_COMBAT_SHARE && $permissions->has(Permissions::VIEW_COMBATS)) {
			echo('			<a href="combats.php?universe=');
			echo($universe);
			echo('" target="mainFrame">Combats</a> | '."\n");
			}
		if (SettingsMod::ENABLE_HACK_SHARE && $permissions->has(Permissions::VIEW_HACKS)) {
			echo('			<a href="hacks.php?universe=');
			echo($universe);
			echo('" target="mainFrame">Hacks</a> | '."\n");
			}
		if (SettingsMod::ENABLE_MISSION_SHARE && $permissions->has(Permissions::VIEW_MISSIONS)) {
			echo('			<a href="missions.php?universe=');
			echo($universe);
			echo('" target="mainFrame">Missions</a> | '."\n");
			}
		if (SettingsMod::ENABLE_PAYMENT_SHARE && $permissions->has(Permissions::VIEW_PAYMENTS)) {
			echo('			<a href="payments.php" target="mainFrame">Payments</a> | '."\n");
		}
		if ($level == "Admin") {
			echo('			<a href="accounts.php" target="mainFrame">Accounts</a> | '."\n");
		}
		if (
			$permissions->has(Permissions::ADD_COMBATS) ||
			$permissions->has(Permissions::ADD_HACKS) ||
			$permissions->has(Permissions::ADD_MISSIONS) ||
			$permissions->has(Permissions::ADD_PAYMENTS)
		){
			if (SettingsMod::EASY_INSTALL) {
				echo('			<a href="easy/pardus_infocenter_share.user.js" target="_blank">GM Script</a> | '."\n");
			} else {
				echo('			<a href="pardus_infocenter_share.user.js" target="_blank">GM Script</a> | '."\n");
			}
		}
		echo('			<a href="logout.php" >Logout</a>');

?>		</td>
	</tr>
	<tr>
		<td>
			<iframe width="100%" height="100%" name="mainFrame" src="<?php echo(SettingsMod::PAGE_STARTING_PAGE); ?>.php"></iframe>
		</td>
	</tr>
	</table>
</body>
</html>
