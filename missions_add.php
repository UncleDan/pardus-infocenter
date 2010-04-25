<?php
	require("security_mod.php");
	require("mission_mod.php");
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
<body><p><?php	
	$acc = SecurityMod::checkLogin();
	if (is_null($acc)) {
		echo("Invalid credentials.</p></body></html>");
		exit;
	}
	
	if (!SettingsMod::ENABLE_MISSION_SHARE) {
		echo("Feature disabled.</p></body></html>");
		exit;
	}
	
	$permissions = $acc->getPermissions();
	if (!SecurityMod::checkPermission($permissions,"mission-share")) {
		echo("Insufficient permissions.</p></body></html>");
		exit;
	}
	
	$res = MissionMod::addMissions($acc->getUniverse(), stripslashes($_REQUEST["missions.</p></body></html>"]));
	if ($res)
		echo("Ok");
	else
		echo("Internal error.</p></body></html>");
?>