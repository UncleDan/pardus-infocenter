<?php
	require("security_mod.php");

	SecurityMod::login();
	
	$permissions = $_SESSION["account"]->getPermissions();
	if (SecurityMod::checkPermission($permissions,"is-banned"))
		SecurityMod::logout();
		
	$name = $_SESSION["account"]->getName();
	$universe = $_SESSION["account"]->getUniverse();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN"
        "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php echo(SettingsMod::PAGE_TITLE); ?></title>
<link rel="shortcut icon" href="<?php echo(SettingsMod::PAGE_FAVICON); ?>" type="image/x-icon">
<link rel="icon" href="<?php echo(SettingsMod::PAGE_FAVICON); ?>" type="image/x-icon">
<link rel="stylesheet" href="<?php echo(SettingsMod::STATIC_IMAGES)?>/main.css" type="text/css">
</head>
<frameset rows="20,*" frameborder="0" framespacing="0" border="0">
<frame src="menu.php" name="menu" marginheight="0" marginwidth="0" frameborder="0" noresize>
<frame src="<?php echo(SettingsMod::PAGE_STARTING_PAGE); ?>.php" name="main" marginheight="0" marginwidth="0" frameborder="0" noresize>
<noframes><body>Sorry, your browser has to support frames!</body></noframes>
</html>