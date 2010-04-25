<?php
	require("security_mod.php");

	SecurityMod::login();
	
	$permissions = $_SESSION["account"]->getPermissions();
	if (SecurityMod::checkPermission($permissions,"is-banned"))
		SecurityMod::logout();
		
	$name = $_SESSION["account"]->getName();
	$universe = $_SESSION["account"]->getUniverse();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php echo(SettingsMod::PAGE_TITLE); ?></title>
<link rel="shortcut icon" href="<?php echo(SettingsMod::PAGE_FAVICON); ?>" type="image/x-icon">
<link rel="icon" href="<?php echo(SettingsMod::PAGE_FAVICON); ?>" type="image/x-icon">
<link rel="stylesheet" href="<?php echo(SettingsMod::STATIC_IMAGES)?>/main.css" type="text/css">
	<style type="text/css">
		html,body {border: 0px; margin: 0px;}
	</style>
</head>
<body style="margin:0">
	<table width="100%">
	<tr>
		<td align="center"><?php
		echo('<img src="http://static.pardus.at/various/universes/'.strtolower($universe).'_16x16.png"');
		echo(' title="'.$universe.': '.$name.'" style="vertical-align: middle;" alt="'.$universe.': '.$name.'"');
		echo(' border="0" height="13" width="13"> '."\n");
		if (SecurityMod::checkPermission($permissions,"is-admin"))
			echo('			<span style="color: red; font-weight: bold;">'.$name.'</span> | '."\n");
		else
			echo('			<span style="font-weight: bold;">'.$name.'</span> | '."\n");
			echo('			<a href="index.php" target="_top">Home</a> | '."\n");
		if (SettingsMod::ENABLE_MAIN_PAGE)
			echo('			<a href="main.php" target="main">Main</a> | '."\n");
		if (SettingsMod::ENABLE_COMBAT_SHARE && SecurityMod::checkPermission($permissions,"combat-view")) {
			echo('			<a href="combats.php?universe=');
			echo($universe);
			echo('" target="main">Combats</a> | '."\n");
			}
		if (SettingsMod::ENABLE_HACK_SHARE && SecurityMod::checkPermission($permissions,"hack-view")) {
			echo('			<a href="hacks.php?universe=');
			echo($universe);
			echo('" target="main">Hacks</a> | '."\n");
			}
		if (SettingsMod::ENABLE_MISSION_SHARE && SecurityMod::checkPermission($permissions,"mission-view")) {
			echo('			<a href="missions.php?universe=');
			echo($universe);
			echo('" target="main">Missions</a> | '."\n");
			}
		if ((SettingsMod::ENABLE_COMBAT_SHARE || SettingsMod::ENABLE_HACK_SHARE || SettingsMod::ENABLE_MISSION_SHARE )	&&
		    (SecurityMod::checkPermission($permissions,"combat-share") || SecurityMod::checkPermission($permissions,"hack-share") || SecurityMod::checkPermission($permissions,"mission-share")	)	)
			echo('			<a href="pardus_infocenter_share.user.js" target="_blank">GM Script</a> | '."\n");
		if (SecurityMod::checkPermission($permissions,"is-admin"))
			echo('			<a href="accounts.php" target="main">Accounts</a> | '."\n");
		echo('			<a href="logout.php" >Logout</a>');

?>		</td>
	</tr>
	</table>
</body>
</html>