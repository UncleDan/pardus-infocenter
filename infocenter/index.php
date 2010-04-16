<?php
	require("modules/security_mod.php");
	SecurityMod::login();
	
	$permissions = $_SESSION["account"]->getPermissions();
	if ($permissions<1 || $permissions>9)
		SecurityMod::logout();
		
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
		echo(' title="'.$universe.': '.$name.'" style="vertical-align: middle;" alt="'.$universe.': '.$name.'"');
		echo(' border="0" height="13" width="13"> '."\n");
		if ($permissions==3)
			echo('			<span style="color: red; font-weight: bold;">'.$name.'</span> | '."\n");
		else
			echo('			<span style="font-weight: bold;">'.$name.'</span> | '."\n");			
		if (SettingsMod::ENABLE_MAIN_PAGE)
			echo('			<a href="main.php" target="mainFrame">Main</a> | '."\n");
		if (SettingsMod::ENABLE_COMBAT_SHARE && ($permissions==2 || $permissions==3 || $permissions==5 || $permissions==6)) {
			echo('			<a href="combats.php?universe=');
			echo($universe);
			echo('" target="mainFrame">Combats</a> | '."\n");
			}
		if (SettingsMod::ENABLE_HACK_SHARE && ($permissions==2 || $permissions==3 || $permissions==8 || $permissions==9)) {
			echo('			<a href="hacks.php?universe=');
			echo($universe);
			echo('" target="mainFrame">Hacks</a> | '."\n");
			}
		if (SettingsMod::ENABLE_MISSION_SHARE && ($permissions==2 || $permissions==3)) {
			echo('			<a href="missions.php?universe=');
			echo($universe);
			echo('" target="mainFrame">Missions</a> | '."\n");
			}
		if ($permissions==1 || $permissions==3 || $permissions==4 || $permissions==6 || $permissions==7 || $permissions==9)			
			echo('			<a href="pardus_infocenter_share.user.js" target="_blank">GM Script</a> | '."\n");
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