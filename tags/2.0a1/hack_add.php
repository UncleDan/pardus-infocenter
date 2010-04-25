<?php
	require("security_mod.php");
	require("hack_mod.php");
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
	
	if (!SettingsMod::ENABLE_HACK_SHARE) {
		echo("Feature disabled.</p></body></html>");
		exit;
	}
	
	$permissions = $acc->getPermissions();
	if (!SecurityMod::checkPermission($permissions,"hack-share")) {
		echo("Insufficient permissions.</p></body></html>");
		exit;
	}
	
	$res = HackMod::addHack($acc->getUniverse(), stripslashes($_REQUEST["data"]));
	if ($res)
		echo("Ok.</p></body></html>");
	else
		echo("Internal error.</p></body></html>");
?>